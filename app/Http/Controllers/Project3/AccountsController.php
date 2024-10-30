<?php

namespace App\Http\Controllers\Project3;

use App\Http\Controllers\Controller;
use App\Models\Project3\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data'  =>  [
                'accounts' => $request->user()->p3_accounts,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|regex:/^[a-zA-Z\s]+$/',
        ]);

        $account = new Account();
        $account->full_name = $request->full_name;
        $account->user_id = $request->user()->id;
        $account->number = AccountsController::generateAccountNumber();
        if($account->save()) {
            return response()->json([
                'message' => 'success',
                'data' => $account,
            ]);
        }

        return response()->json([
            'message' => 'Failed to create account',
        ], 500);
    }

    public static function generateAccountNumber(): string
    {
        $accountNumber = '100';
        for ($i = 0; $i < 7; $i++) {
            $accountNumber .= rand(0, 9);
        }

        return $accountNumber;
    }
}
