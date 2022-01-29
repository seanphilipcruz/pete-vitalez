<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
{
    public function index() {
        return redirect()->withErrors('Access to the resource is not allowed');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'phone_number',
            'address',
            'zip_code',
            'city',
            'country',
            'state',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 401);
        }

        if ($user_id = $request->input('user_id')) {
            $user = User::with('Role')->findOrFail($user_id);

            $profile = new Profile($validator->validated());

            $profile->User()->associate($user);
        }

        $profile = new Profile($validator->validated());

        $profile->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile has been saved',
        ], 201);
    }

    public function show($id) {
        $profile = Profile::with('User')->findOrFail($id);

        return response()->json($profile);
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'phone_number',
            'address',
            'zip_code',
            'city',
            'country',
            'state',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 401);
        }

        $profile = Profile::with('User')->findOrFail($id);

        $profile->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'User profile has been updated'
        ]);
    }

    public function destroy($id) {
        $profile = Profile::with('User')->findOrFail($id);

        $profile->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile has been removed'
        ]);
    }
}
