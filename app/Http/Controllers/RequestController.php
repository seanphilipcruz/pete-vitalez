<?php

namespace App\Http\Controllers;

use App\Mail\ProductInvoice;
use App\Models\Contact;
use App\Models\JobOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function index(Request $request) {
        $per_page = $request->get('per_page', 5);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $column_name = $request->get('column', 'id');
        $direction = $request->get('direction', 'asc');

        $requirements = JobOrder::with('Product', 'Customer')
            ->whereNull('deleted_at')
            ->paginate($per_page, ['*'], 'page', $page);

        if ($search) {
            $requirements = JobOrder::with('Product')
                ->whereNull('deleted_at')
                ->where('description', 'like', '%'.$search.'%')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($column_name) {
            $requirements = JobOrder::with('Product', 'Customer')
                ->whereNull('deleted_at')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($direction) {
            $requirements = JobOrder::with('Product', 'Customer')
                ->whereNull('deleted_at')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if (sizeof($requirements->items()) > 0) {
            return response()->json($requirements);
        } else {
            return response()->json(false);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'profile_id' => 'integer|required',
            'product_id' => 'integer|required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $requirement = new JobOrder($request->all());
        $requirement->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Request has been sent'
        ], 201);
    }

    public function show($id) {
        $requirement = JobOrder::with('Product', 'Customer')->findOrFail($id);

        return response()->json($requirement);
    }

    public function update($id, Request $request) {
        $requirement = JobOrder::with('Product', 'Customer')->findOrFail($id);

        $requirement->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Request has been updated'
        ]);
    }

    public function destroy($id) {
        $requirement = JobOrder::with('Product', 'Customer')->findOrFail($id);

        $requirement->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Request has been removed!'
        ]);
    }
}
