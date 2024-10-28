<?php

namespace App\Http\Controllers\Project2;

use App\Http\Controllers\Controller;
use App\Models\Project2\LeaveRequest;
use App\Models\Project2\Notification;
use Illuminate\Http\Request;

class LeaveRequestsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data'  =>  [
                'leave_requests' => $request->user()->p2_leave_requests,
            ]
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|in:annual,sick',
        ]);

        $leaveRequest = new LeaveRequest();
        $leaveRequest->start_date = $request->start_date;
        $leaveRequest->end_date = $request->end_date;
        $leaveRequest->type = $request->type;
        $leaveRequest->user_id = $request->user()->id;
        $leaveRequest->status = 'pending';

        if($leaveRequest->save()) {
            $notification = new Notification();
            $notification->message = 'You have a new leave request';
            $notification->user_id = $request->user()->manager_id;
            $notification->type = 'leave_request';
            $notification->save();
            return response()->json([
                'message' => 'success',
                'data' => $leaveRequest,
            ]);
        }

        return response()->json([
            'message' => 'error',
            'data' => 'Leave request could not be created'
        ], 500);
    }

    public function update(LeaveRequest $leaveRequest, $request) {
        if($leaveRequest->status !== 'pending') {
            return response()->json([
                'message' => 'error',
                'data' => 'Leave request has already been processed'
            ], 403);
        }

        if($request->user()->id !== $leaveRequest->user->manager_id) {
            return response()->json([
                'message' => 'error',
                'data' => 'You are not allowed to update this leave request'
            ], 403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->status = $request->status;

        if($leaveRequest->save()) {
            $notification = new Notification();
            $notification->message = 'Your leave request has been ' . $request->status;
            $notification->user_id = $leaveRequest->user_id;
            $notification->type = 'leave_request';
            $notification->save();
            return response()->json([
                'message' => 'success',
                'data' => $leaveRequest,
            ]);
        }

        return response()->json([
            'message' => 'error',
            'data' => 'Leave request could not be updated'
        ], 500);
    }
}
