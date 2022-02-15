<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index(Request $request) {
        $per_page = $request->get('per_page', 5);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $column_name = $request->get('column', 'id');
        $direction = $request->get('direction', 'asc');

        $order = Order::with('Product', 'Customer')
            ->whereNull('deleted_at')
            ->paginate($per_page, ['*'], 'page', $page);

        if ($search) {
            $order = Order::with('Product', 'Customer')
                ->whereNull('deleted_at')
                ->where('code', 'like', '%'.$search.'%')
                ->orWhere('total', 'like', '%'.$search.'%')
                ->whereHas('Product', function (Builder $query) {
                    $search = request()->get('search');

                    $query->where('title', 'like', '%'.$search.'%');
                })->whereHas('Customer', function(Builder $query) {
                    $search = request()->get('search');

                    $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('middle_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%');
                })->paginate($per_page, ['*'], 'page', $page);
        }

        if ($column_name) {
            $order = Order::with('Product', 'Customer')
                ->whereNull('deleted_at')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($search && $column_name && $direction) {
            $order = Order::with('Product', 'Customer')
                ->whereNull('deleted_at')
                ->whereHas('Product', function (Builder $query) {
                    $search = request()->get('search');

                    $query->where('title', 'like', '%'.$search.'%');
                })->orWhereHas('Customer', function(Builder $query) {
                    $search = request()->get('search');

                    $query->where('first_name', 'like', '%'.$search.'%')
                        ->orWhere('middle_name', 'like', '%'.$search.'%')
                        ->orWhere('last_name', 'like', '%'.$search.'%');
                })
                ->orWhere('code', 'like', '%'.$search.'%')
                ->orWhere('total', 'like', '%'.$search.'%')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if (sizeof($order->items()) > 0) {
            return response()->json($order);
        } else {
            return response()->json(false);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'product_id' => 'integer|required',
            'customer_id' => 'integer|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 401);
        }

        $order = new Order($request->all());
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order has been made!'
        ], 201);
    }

    public function show($id) {
        $order = Order::with('Product', 'Customer.Shipping')->findOrFail($id);

        return response()->json($order);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'product_id' => 'integer|required',
            'customer_id' => 'integer|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 401);
        }

        $order = Order::with('Product', 'Customer.Shipping')->findOrFail($id);

        $order->update($request->all());

        $customer_order = Order::with('Customer', 'Product')->findOrFail($id);
        $contact_info = Contact::all()->first();

        $invoice_details = [
            'order' => $customer_order,
            'contact' => $contact_info
        ];

        // everytime the order has been updated
        if ($invoice_details['order']->is_done === 1) {
            $this->send_order_update($invoice_details);
        } else if ($invoice_details['order']->is_done === 2) {
            $this->send_order_update($invoice_details);
            $this->send_invoice($invoice_details);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order has been updated!'
        ]);
    }

    public function destroy($id) {
        $order = Order::with('Customer.Shipping')->findOrFail($id);

        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order has been removed.'
        ]);
    }
}
