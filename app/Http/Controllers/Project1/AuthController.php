<?php

namespace App\Http\Controllers\Project1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project1\LoginRequest;
use App\Http\Requests\Project1\SignupRequest;
use App\Mail\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        if($user->save()) {
            $token = $user->createToken('auth_token')->plainTextToken;
            if($token) {
                return response()->json([
                    'message' => 'success',
                    'data' => [
                        'user' => $user->email,
                    ]
                ]);
            }
        }

        return response()->json([
            'message' => 'Failed to create user',
        ], 500);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if( $user && Hash::check($request->password, $user->password)) {
//            $token = $user->createToken('auth_token')->plainTextToken;
//            if($token) {
//                return response()->json([
//                    'message' => 'success',
//                    'data' => [
//                        'user' => $user->email,
//                        'token' => $token
//                    ]
//                ]);
//            }
            if($request->email === 'ali@joincoded.com') {
                Mail::to('ali@joincoded.com')->send(new Otp());
            }

            return response()->json([
                'message' => 'OTP sent to ' . $request->email,
                'data' => [
                    'otp' => '210305',
                ],
            ]);
        }

        return response()->json([
            'message' => 'The provided credentials are incorrect.',
        ], 401);
    }

    public function otp(Request $request) {
        $request->validate([
            'otp' => 'required|string|min:6|max:6',
            'email' => 'required|email|exists:users,email',
        ]);

        if($request->otp === '210305') {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            if($token) {
                return response()->json([
                    'message' => 'success',
                    'data' => [
                        'user' => $user->email,
                        'token' => $token
                    ]
                ]);
            }
        }

        return response()->json([
            'message' => 'The provided OTP is incorrect.',
        ], 401);

    }
}
