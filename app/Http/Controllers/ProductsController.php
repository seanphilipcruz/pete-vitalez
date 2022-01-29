<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index(Request $request) {
        $per_page = $request->get('per_page', 5);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $column_name = $request->get('column', 'id');
        $direction = $request->get('direction', 'asc');

        $products = Product::with('Order')
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->paginate($per_page, ['*'], 'page', $page);

        if ($search) {
            $products = Product::with('Order')
                ->whereNull('deleted_at')
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('price', 'like', '%'.$search.'%')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($column_name) {
            $products = Product::with('Order')
                ->whereNull('deleted_at')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($search && $column_name && $direction) {
            $products = Product::with('Order')
                ->whereNull('deleted_at')
                ->where('title', 'like', '%'.$search.'%')
                ->orWhere('sub_title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('price', 'like', '%'.$search.'%')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if (sizeof($products->items()) > 0) {
            return response()->json($products);
        } else {
            return response()->json(false);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'string|min:2|required',
            'sub_title' => 'required',
            'description' => 'required',
            'price' => 'numeric|required',
            'image' => 'string|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $product = new Product($request->all());
        $product['is_sold'] = 0;
        $product->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Artwork has been added'
        ], 201);
    }

    public function show($id) {
        $product = Product::with('Order.Customer')->findOrFail($id);

        return response()->json($product);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'string|min:2|required',
            'sub_title' => 'required',
            'description' => 'required',
            'price' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $product = Product::with('Order')->findOrFail($id);

        $product->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Artwork has been updated!'
        ]);
    }

    public function destroy($id) {
        $product = Product::with('Order')->findOrFail($id);

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Artwork has been deleted'
        ]);
    }

    public function save_receiver($request) {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'country' => 'required',
            'state' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 401);
        }

        $customer_id = $request->input('customer_id');

        $customer = Customer::with('Order')->findOrFail($customer_id);

        $receiver = new Shipping($validator->validated());

        $receiver->Customer()->associate($customer);

        $receiver->save();

        return true;
    }

    public function update_receiver($request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'country' => 'required',
            'state' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 401);
        }

        $receiver = Shipping::with('Customer.Order')->findOrFail($id);

        $receiver->update($validator->validated());

        return true;
    }
}
