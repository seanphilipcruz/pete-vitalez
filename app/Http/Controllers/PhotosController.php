<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotosController extends Controller
{
    public function index(Request $request) {

    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'title' => 'min:4|required',
            'description' => 'required',
            'image' => 'image|max:2048|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 400);
        }

        $photo = new Photo($request->all());

        $product_id = $request->input('product_id');
        $blog_id = $request->input('blog_id');

        if ($blog_id) {
            $blog = Blog::with('Photo')->findOrFail($blog_id);

            $photo->Blog()->associate($blog);
        } else {
            $product = Product::with('Order')->findOrFail($product_id);

            $photo->Product()->associate($product);
        }

        $photo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Upload success'
        ], 201);
    }

    public function show($id, Request $request) {
        $photo = Photo::with('Blog', 'Product')->findOrFail($id);

        $type = !$request['type'] ? 'blog' : 'artwork';

        $photo->image = $this->verify_photo($photo->image, $type);

        return response()->json($photo);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'min:4|required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 400);
        }

        $photo = Photo::with('Blog', 'Product')->findOrFail($id);

        $photo->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Update success!'
        ]);
    }

    public function destroy($id) {
        $photo = Photo::with('Blog', 'Product')->findOrFail($id);

        $photo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Photo has been removed'
        ]);
    }
}
