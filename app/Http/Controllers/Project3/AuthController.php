<?php

namespace App\Http\Controllers\Project3;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project3\LoginRequest;
use App\Http\Requests\Project3\SignupRequest;
use App\Models\Project3\Account;
use App\Models\Project3\Card;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        if($user->save()) {
            $account = new Account();
            $account->full_name = "Beneficiary";
            $account->user_id = $request->user()->id;
            $account->account_number = AccountsController::generateAccountNumber();
            if($account->save()) {
                $card = new Card();
                $card->type = $request->type;
                $card->expiry_date = Carbon::now()->addYears(3)->endOfMonth();
                $card->number = CardsController::generateCardNumber();
                $card->user_id = $request->user()->id;
                $card->account_id = $account->refresh()->id;
            }
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
