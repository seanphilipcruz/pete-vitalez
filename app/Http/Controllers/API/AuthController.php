<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request) {
        $username = $request->input('username');
        $password= $request->input('password');

        $authenticate_username = ['username' => $username, 'password' => $password];
        $authenticate_email = ['email' => $username, 'password' => $password];

        if (!Auth::attempt($authenticate_username)) {
            if (!Auth::attempt($authenticate_email)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username and password does not match!'
                ], 401);
            }
        }

        $user = User::with('Profile')->findOrFail(Auth::id());

        $access_token = $user->createToken('user_token')->accessToken;

        return response()->json([
            'status' => 'success',
            'access_token' => $access_token,
            'user' => $user
        ]);
    }

    public function refresh() {
        //
    }

    public function logout(Request $request) {
        //
    }
}
