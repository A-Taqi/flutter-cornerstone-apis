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

    public function update(Account $account, Request $request)
    {
        $request->validate([
            'full_name' => 'required|regex:/^[a-zA-Z\s]+$/',
        ]);

        $account->full_name = $request->full_name;
        if($account->save()) {
            return response()->json([
                'message' => 'success',
                'data' => $account,
            ]);
        }

        return response()->json([
            'message' => 'Failed to update account',
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

    public static function deposit(Account $account, Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $account->balance += $request->amount;
        if($account->save()) {
            return response()->json([
                'message' => 'success',
                'data' => $account,
            ]);
        }

        return response()->json([
            'message' => 'Failed to deposit into account',
        ], 500);
    }

    public static function withdraw(Account $account, Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        if($account->balance < $request->amount) {
            return response()->json([
                'message' => 'error',
                'data' => 'Insufficient funds'
            ], 403);
        }

        $account->balance -= $request->amount;
        if($account->save()) {
            return response()->json([
                'message' => 'success',
                'data' => $account,
            ]);
        }

        return response()->json([
            'message' => 'Failed to withdraw from account',
        ], 500);
    }

    public static function transfer(Account $account, Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'to_account_number' => 'required|exists:p3_accounts,number',
        ]);

        $recipientAccount = Account::where('number', $request->to_account_number)->first();

        if($recipientAccount->number === $account->number) {
            return response()->json([
                'message' => 'error',
                'data' => 'You cannot transfer funds to the same account'
            ], 403);
        }

        if($account->balance < $request->amount) {
            return response()->json([
                'message' => 'error',
                'data' => 'Insufficient funds'
            ], 403);
        }

        $account->balance -= $request->amount;
        $recipientAccount->balance += $request->amount;
        if($recipientAccount->save() && $account->save()) {
            return response()->json([
                'message' => 'success',
                'data' => $account,
            ]);
        }

        return response()->json([
            'message' => 'Failed to transfer funds',
        ], 500);
    }
}
