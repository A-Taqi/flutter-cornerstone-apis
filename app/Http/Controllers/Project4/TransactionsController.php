<?php

namespace App\Http\Controllers\Project4;

use App\Http\Controllers\Controller;
use App\Models\Project4\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data'  =>  [
                'transactions' => $request->user()->p4_transactions,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'detail' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $transaction = new Transaction();
        $transaction->detail = $request->detail;
        $transaction->amount = $request->amount;
        $transaction->user_id = $request->user()->id;

        if($transaction->save()) {
            return response()->json([
                'message' => 'success',
                'data' => $transaction,
            ]);
        }

        return response()->json([
            'message' => 'error',
            'data' => 'Transaction could not be created'
        ], 500);
    }
}
