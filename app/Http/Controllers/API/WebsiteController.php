<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ArtworkRequest;
use App\Mail\OrderInformation;
use App\Mail\ProductInvoice;
use App\Mail\WebsiteMessage;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Event;
use App\Models\JobOrder;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\Social;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WebsiteController extends Controller
{
    public function home() {

    }

    public function artworks(Request $request) {
        $page = $request->get('page', 1);
        $per_page = $request->get('perPage', 5);
        $search = $request->get('keyword');
        $product_status = $request->get('productStatus', "0");
        $column_name = $request->get('columnName', 'id');
        $direction = $request->get('direction', 'asc');

        $artworks = Product::with('Order', 'Photo')
            ->whereNull('deleted_at')
            ->where('is_sold', '=', 0)
            ->latest()
            ->paginate($per_page, ['*'], 'page', $page);

        if ($search) {
            $artworks = Product::with('Order', 'Photo')
                ->whereNull('deleted_at')
                ->where('is_sold', '=', 0)
                ->latest()
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'$')
                ->orWhere('price', 'like', '%'.$search.'%')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($column_name) {
            $artworks = Product::with('Order', 'Photo')
                ->whereNull('deleted_at')
                ->where('is_sold', '=', 0)
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($search && $column_name && $direction) {
            $artworks = Product::with('Order', 'Photo')
                ->whereNull('deleted_at')
                ->where('is_sold', '=', 0)
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('price', 'like', '%'.$search.'%')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($product_status === "1") {
            $artworks = Product::with('Order', 'Photo')
                ->whereNull('deleted_at')
                ->where('is_sold', '=', 1)
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);

            if ($search) {
                $artworks = Product::with('Order', 'Photo')
                    ->whereNull('deleted_at')
                    ->where('is_sold', '=', 1)
                    ->latest()
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('sub_title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'$')
                    ->orWhere('price', 'like', '%'.$search.'%')
                    ->paginate($per_page, ['*'], 'page', $page);
            }

            if ($column_name) {
                $artworks = Product::with('Order', 'Photo')
                    ->whereNull('deleted_at')
                    ->where('is_sold', '=', 1)
                    ->orderBy($column_name, $direction)
                    ->paginate($per_page, ['*'], 'page', $page);
            }

            if ($search && $column_name && $direction) {
                $artworks = Product::with('Order', 'Photo')
                    ->whereNull('deleted_at')
                    ->where('is_sold', '=', 1)
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('sub_title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('price', 'like', '%'.$search.'%')
                    ->orderBy($column_name, $direction)
                    ->paginate($per_page, ['*'], 'page', $page);
            }
        }

        if (sizeof($artworks->items()) > 0) {
            foreach ($artworks->items() as $artwork) {
                $artwork->image = $this->verify_photo($artwork->image, 'artwork');
            }

            return response()->json($artworks);
        } else {
            return response()->json(false);
        }
    }

    public function get_artwork($id) {
        $artwork = Product::with('Order', 'Photo')->findOrFail($id);

        $artwork->image = $this->verify_photo($artwork->image, 'artwork');

        return response()->json($artwork);
    }

    public function blogs(Request $request) {
        $page = $request->get('page', 1);
        $per_page = $request->get('perPage', 5);
        $search = $request->get('keyword');
        $column_name = $request->get('columnName', 'id');
        $direction = $request->get('direction', 'asc');
        $visits = $request->get('visits');
        $blog_id = $request->get('blog_id');

        $blogs = Blog::with('Photo')
            ->whereNull('deleted_at')
            ->latest()
            ->where('is_published', '=', 1)
            ->paginate($per_page, ['*'], 'page', $page);

        if ($search) {
            // TODO: Filtering based on Date using Search, need to convert January to 01 etc.
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->latest()
                ->where('is_published', '=', 1)
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($column_name) {
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->latest()
                ->where('is_published', '=', 1)
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($search && $column_name && $direction) {
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->latest()
                ->where('is_published', '=', 1)
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        // getting the most visited & articles/blogs
        if ($visits) {
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->orderBy('visits', 'desc')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($visits && $blog_id) {
            $blogs = Blog::with('Photo')
                ->whereNull('deleted_at')
                ->where('id', '!=', $blog_id)
                ->orderBy('visits', 'desc')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if (sizeof($blogs->items()) > 0) {
            foreach ($blogs->items() as $blog) {
                $blog->image = $this->verify_photo($blog->image, 'blog');
            }

            return response()->json($blogs);
        } else {
            return response()->json(false);
        }
    }

    public function get_blog($id, Request $request) {
        $blog = Blog::with('Photo')->findOrFail($id);

        ++$blog->visits;

        if ($request->has('add_like')) {
            ++$blog->likes;
        }

        $blog->save();

        $blog->image = $this->verify_photo($blog->image, 'blog');

        return response()->json($blog);
    }

    public function create_order($id, Request $request) {
        $this->create_customer($request);

        $customer_id = Customer::with('Shipping')->latest()->first()->id;
        $customer = Customer::with('Shipping')->findOrFail($customer_id);

        $product = Product::with('Photo')->findOrFail($id);

        $order = new Order([
            'code' => $request->get('order_code'),
            'total' => $request->get('order_total'),
        ]);

        $order->Product()->associate($product);
        $order->Customer()->associate($customer);
        $order->save();

        $customer_order = Order::with('Customer', 'Product')->latest()->first();
        $contact_info = Contact::all()->first();

        $invoice_details = [
            'order' => $customer_order,
            'contact' => $contact_info
        ];

        // send the invoice to the email
        $this->send_invoice($invoice_details);
        $this->send_order($invoice_details);

        $product->update([
            'is_sold' => 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order has been created.'
        ], 201);
    }

    public function create_request(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required',
            'country_code' => 'required',
            'phone_number' => 'required',
            'address' => 'min:10|required',
            'zip_code' => 'required',
            'city' => 'required',
            'state' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $product_id = $request->get('product_id');

        $this->create_customer($request);

        $customer_id = Customer::with('Shipping')->latest()->first()->id;
        $customer = Customer::with('Shipping')->findOrFail($customer_id);

        $product = Product::with('Photo')->findOrFail($product_id);

        $jobOrder = new JobOrder($request->only(['description', 'is_done']));
        $jobOrder->Customer()->associate($customer);
        $jobOrder->Product()->associate($product);
        $jobOrder->save();

        $job_order = JobOrder::latest()->get()->first();

        $this->send_request($job_order);

        return response()->json([
            'status' => 'success',
            'message' => 'Request has been sent',
        ], 201);
    }

    public function send_message(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'min:2|required',
            'email' => 'email|required',
            'subject' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $message = new Message($request->all());
        $message->save();

        $website_message = Message::latest()->get()->first();

        Mail::to('petevitalez@theartofpetevitalez.com')->send(new WebsiteMessage($website_message));

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for reaching out to us'
        ], 201);
    }

    public function create_customer($request) {
        $create_customer = new Customer($request->all());
        $create_customer->phone_number = $request->get('country_code') . $request->get('phone_number');
        $create_customer->country = $request->get('code');

        try {
            $create_customer->save();

            return true;
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 400);
        }
    }

    public function get_content() {
        $contact = Contact::latest()->first();
        $events = Event::whereNull('deleted_at')->orderBy('start')->count();
        $socials = Social::whereNull('deleted_at')->get();

        if ($events > 0) {
            $events = Event::whereNull('deleted_at')->orderBy('start')->get();

            foreach ($events as $event) {
                if ($event->start && $event->end) {
                    $event->start = date('F d, Y', strtotime($event->start));
                    $event->end = date('F d, Y', strtotime($event->end));
                } elseif ($event->start) {
                    $event->start = date('F d, Y', strtotime($event->start));
                }
            }
        }

        $content = [
            'contact' => $contact,
            'events' => $events,
            'socials' => $socials
        ];

        return response()->json($content);
    }

    public function verify_invoice($invoice_id) {
        $order = Order::with('Product', 'Customer')
            ->where('code', '=', $invoice_id)
            ->count();

        $response = [
            'code' => 404,
            'status' => 'unauthentic',
            'message' => 'Receipt authentication failed [No orders found with '.$invoice_id.']',
        ];

        if ($order > 0) {
            $order = Order::with('Product', 'Customer')
                ->where('code', '=', $invoice_id)
                ->get()->first();

            $order->Product->image = $this->verify_photo($order->Product->image, 'artwork');

            if (!$order->Customer->middle_name) {
                $order->Customer->full_name = $order->Customer->first_name . ' ' . $order->Customer->last_name;
            } else {
                $order->Customer->full_name = $order->Customer->first_name . ' ' . $order->Customer->middle_name . ' ' . $order->Customer->last_name;
            }

            $order->Customer->complete_address = $order->Customer->address . ' ' . $order->Customer->city . ',' . ' ' . $order->Customer->state . ' ' . $order->Customer->country . ',' . ' ' . $order->Customer->zip_code;

            $response['code'] = 200;
            $response['status'] = 'authentic';
            $response['message'] = 'Receipt authenticated [Certified sale from The Art of Pete Vitalez]';
            $response['order'] = $order;

            return view('verify', compact('response'));
        }
        return view('verify', compact('response'));
    }
}
