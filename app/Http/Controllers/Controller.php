<?php

namespace App\Http\Controllers;

use App\Mail\ArtworkRequest;
use App\Mail\OrderInformation;
use App\Mail\OrderStatus;
use App\Mail\ProductInvoice;
use App\Models\Blog;
use App\Models\JobOrder;
use App\Models\Message;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function upload_image(Request $request) {
        $image = $request->file('image');
        $type = $request->get('type');

        // check if the type is artwork or artwork photo else it would fall into being named as blog
        $image_name = ($type === 'artwork' || $type === 'artwork_photo' ? 'artwork' : ($type === 'blog' || $type === 'blog_photo' ? 'blog' : 'about')) . '-' . date('Ymd') . '-' . mt_rand() . '.png';

        $path = 'images';

        if ($type) {
            if ($type === 'artwork' || $type === 'artwork_photo') {
                $path = 'images/artworks';
            } else if ($type === 'blogs' || $type === 'blog_photo') {
                $path = 'images/blogs';
            } else if ($type === 'about') {
                $path = 'assets/about';
            }
        }

        $image->move($path, $image_name);

        if ($type === 'artwork_photo') {
            $file = 'images/artworks/' . $image_name;
            Storage::disk('artwork')->put($image_name, file_get_contents($file));
        } else if ($type === 'blog_photo') {
            $file = 'images/blogs/' . $image_name;
            Storage::disk('blog')->put($image_name, file_get_contents($file));
        } else if ($type === 'about') {
            $file = 'assets/about/' . $image_name;
            Storage::disk($type)->put($image_name, file_get_contents($file));
        } else {
            $file = 'images/' . ($type === 'artwork' ? 'artworks' : 'blogs') . '/' . $image_name;
            Storage::disk($type)->put($image_name, file_get_contents($file));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Upload success',
            'image_name' => $image_name
        ], 201);
    }

    public function validate_checkout_form(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'min:2|required',
            'last_name' => 'min:2|required',
            'country_code' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'code' => 'max:2|required',
            'is_framed' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => $validator->messages()
        ]);
    }

    public function verify_photo($file_name, $directory) : string {
        if (!$file_name) {
            $file_name = $this->get_file_name();
        } else {
            if (Storage::disk($directory)->exists($file_name)) {
                return $file_name;
            } else {
                $file_name = $this->get_file_name();
            }
        }

        return $file_name;
    }

    public function get_file_name() {
        $file_name = 'default-square.png';

        return $file_name;
    }

    public function dashboard() {
        $sold = Order::with('Customer', 'Product')
            ->whereNull('deleted_at')
            ->where('is_done', '=', 1)
            ->count();

        $available = Order::with('Customer', 'Product')
            ->whereNull('deleted_at')
            ->where('is_done', '=', 0)
            ->count();

        $requests = JobOrder::with('Customer', 'Product')
            ->whereNull('deleted_at')
            ->where('is_done', '=', 0)
            ->count();

        $pending = JobOrder::with('Customer', 'Product')
            ->whereNull('deleted_at')
            ->where('is_done', '=', 1)
            ->count();

        $artworks_sold = Product::with('Order', 'Photo')
            ->whereNull('deleted_at')
            ->where('is_sold', '=', 1)
            ->count();

        $most_visits = Blog::with('Photo')
            ->whereNull('deleted_at')
            ->where('visits', '>', 0)
            ->orderBy('visits', 'desc')
            ->first();

        $most_likes = Blog::with('Photo')
            ->whereNull('deleted_at')
            ->where('likes', '>', 0)
            ->orderBy('likes', 'desc')
            ->first();

        $unread = Message::whereNull('deleted_at')
            ->where('is_read', '=', 0)
            ->count();

        $read = Message::whereNull('deleted_at')
            ->where('is_read', '=', 1)
            ->count();

        return response()->json([
            'sold' => $sold,
            'available' => $available,
            'requests' => $requests,
            'pending' => $pending,
            'artworks_sold' => $artworks_sold,
            'most_visited' => $most_visits,
            'most_liked' => $most_likes,
            'unread' => $unread,
            'read' => $read
        ]);
    }

    public function send_order_update($status) {
        $status['order']->Product->image = $this->verify_photo($status['order']->Product->image, 'artwork');

        if (!$status['order']->Customer->middle_name) {
            $status['order']->Customer->full_name = $status['order']->Customer->first_name . ' ' . $status['order']->Customer->last_name;
        } else {
            $status['order']->Customer->full_name = $status['order']->Customer->first_name . ' ' . $status['order']->Customer->middle_name . ' ' . $status['order']->Customer->last_name;
        }

        $status['order']->Customer->complete_address = $status['order']->Customer->address . ' ' . $status['order']->Customer->city . ',' . ' ' . $status['order']->Customer->state . ' ' . $status['order']->Customer->country . ',' . ' ' . $status['order']->Customer->zip_code;


        Mail::to([$status['order']->Customer->email])->send(new OrderStatus($status));

        return true;
    }

    public function send_invoice($invoice) {
        // get the contact information of the website
        $invoice['date_ordered'] = date('F d, Y', strtotime($invoice['order']->created_at));

        QrCode::size(250)
            ->format('png')
            ->generate(route('website.verify.invoice', $invoice['order']->code),
                public_path('images/qr/'.$invoice['order']->code.'-'.date('mdY', strtotime($invoice['order']->created_at)).'.png')
            );

        Mail::to([$invoice['order']->Customer->email, 'petevitalez@theartofpetevitalez.com'])->send(new ProductInvoice($invoice));

        return true;
    }

    public function send_order($details) {
        if (!$details['order']->Customer->middle_name) {
            $details['order']->Customer->full_name = $details['order']->Customer->first_name . ' ' . $details['order']->Customer->last_name;
        } else {
            $details['order']->Customer->full_name = $details['order']->Customer->first_name . ' ' . $details['order']->Customer->middle_name . ' ' . $details['order']->Customer->last_name;
        }

        Mail::to('petevitalez@theartofpetevitalez.com')->send(new OrderInformation($details));

        return true;
    }

    public function send_request($request_details) {
        if (!$request_details->Customer->middle_name) {
            $request_details->Customer->full_name = $request_details->Customer->first_name . ' ' . $request_details->Customer->last_name;
        } else {
            $request_details->Customer->full_name = $request_details->Customer->first_name . ' ' . $request_details->Customer->middle_name . ' ' . $request_details->Customer->last_name;
        }

        Mail::to('petevitalez@theartofpetevitalez.com')->send(new ArtworkRequest($request_details));

        return true;
    }

    public function save_extra_photo($photo_data, $model_id, $product = false) {
        // setting up variables of verifying the photo data
        $photo_count = sizeof($photo_data);

        // count the photo data from the array
        if ($photo_count > 0) {
            // create photo data from the array of photos in the request
            foreach ($photo_data as $data) {
                if (sizeof($data) === 3) {
                    if ($product == true) {
                        $photo = new Photo($data);
                        $photo->Product()->associate($model_id);
                        $photo->save();
                    } else {
                        $photo = new Photo($data);
                        $photo->Blog()->associate($model_id);
                        $photo->save();
                    }
                }
            }
        }
    }
}
