<?php

namespace App\Http\Controllers\Project2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data'  =>  [
                'notifications' => $request->user()->p2_notifications,
            ]
        ]);
    }

}
