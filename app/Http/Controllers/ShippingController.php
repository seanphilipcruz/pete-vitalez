<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function show($id) {
        $receiver = Shipping::with('Customer.Order')->findOrFail($id);

        return response()->json($receiver);
    }
}
