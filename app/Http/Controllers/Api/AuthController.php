<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{
    public function login (Request $request){
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (\Auth::attempt($validatedData)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->api_token = $token;
            $expire = Carbon::now()->addHours(24);
            $user->api_created_at = $expire;
            $user->save();

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expired' => $expire
            ], 200);
        }

        return response()->json([
            'message' => 'username or password is failed'
        ], 422);

    }

    public function logout(Request $request){
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];

        $user = User::where('api_token', $token)->first();
        $user->api_token = null;
        $user->api_created_at = null;
        $user->save();

        return response()->json([
            'message' => 'successfully logged out'
        ], 200);
    }
}
