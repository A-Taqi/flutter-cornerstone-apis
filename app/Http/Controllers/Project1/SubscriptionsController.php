<?php

namespace App\Http\Controllers\Project1;

use App\Http\Controllers\Controller;
use App\Models\Project1\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data'  =>  [
                'subscriptions' => $request->user()->p1_subscriptions,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|in:telecom,media',
        ]);

        $subscription = new Subscription();
        $subscription->title = $request->title;
        $subscription->price = $request->price;
        $subscription->type = $request->type;
        $subscription->user_id = $request->user()->id;
        if($subscription->save()){
            return response()->json([
                'message' => 'success',
                'data'  =>  [
                    'subscription' => $subscription,
                ]
            ]);
        }

        return response()->json([
            'message' => 'error',
            'data'  =>  [
                'subscription' => null,
            ]
        ]);
    }
}
