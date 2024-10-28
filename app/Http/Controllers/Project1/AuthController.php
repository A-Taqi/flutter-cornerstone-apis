<?php

namespace App\Http\Controllers\Project1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project1\LoginRequest;
use App\Http\Requests\Project1\SignupRequest;
use App\Models\Project1\User;
use Illuminate\Support\Facades\Hash;

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
                        'token' => $token
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
            'message' => 'The provided credentials are incorrect.',
        ], 401);
    }
}
