<?php

namespace App\Http\Controllers\Project4;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project4\LoginRequest;
use App\Http\Requests\Project4\SignupRequest;
use App\Models\User;
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
            'message' => 'failed to create user',
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
