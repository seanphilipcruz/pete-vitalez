<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotosController extends Controller
{
    public function index() {

    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'min:4|required',
            'description' => 'required',
            'image' => 'image|max:2048|required',
            'date_taken' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'success',
                'message' => $validator->errors()->all()
            ]);
        }

        $photo = new Photo($validator->validated());

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

    public function show($id) {
        $photo = Photo::with('Blog', 'Product')->findOrFail($id);

        return response()->json($photo);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'min:4|required',
            'description' => 'required',
            'date_taken' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'success',
                'message' => $validator->errors()->all()
            ]);
        }

        $photo = Photo::with('Blog', 'Product')->findOrFail($id);

        $photo->update($validator->validated());

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
