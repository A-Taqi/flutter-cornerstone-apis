<?php

namespace App\Http\Controllers\Project3;

use App\Http\Controllers\Controller;
use App\Models\Project3\Account;
use App\Models\Project3\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CardsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data'  =>  [
                'cards' => $request->user()->p3_cards,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:debit,credit',
            'expiry_date' => 'required|date_format:m/Y',
            'account_number' => 'required|exists:p3_accounts,number,user_id,'.$request->user()->id,
        ]);



        $card = new Card();
        $card->type = $request->type;
        $card->expiry_date = Carbon::createFromFormat('m/Y', $request->expiry_date)->endOfMonth();
        $card->number = CardsController::generateCardNumber();
        $card->user_id = $request->user()->id;
        $card->account_id = Account::where('number', $request->account_number)->first()->id;
        if($card->save()) {
            return response()->json([
                'message' => 'success',
                'data' => $card->load('account'),
            ]);
        }

        return response()->json([
            'message' => 'Failed to create card',
        ], 500);
    }

    public static function generateCardNumber(): string
    {
        $cardNumber = '468564';
        for ($i = 0; $i < 10; $i++) {
            $cardNumber .= rand(0, 9);
        }

        return $cardNumber;
    }
}
