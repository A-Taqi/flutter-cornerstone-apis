<?php

namespace App\Http\Controllers\Project2;

use App\Http\Controllers\Controller;
use App\Models\Project2\Notification;
use App\Models\Project2\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'data'  =>  [
                'tasks' => $request->user()->p2_tasks,
            ]
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'user_id'  =>  'required|exists:users,id'
        ]);

        $assignee = User::find($request->user_id);

        if($assignee->manager_id !== $request->user()->id) {
            return response()->json([
                'message' => 'error',
                'data' => 'You are not allowed to assign tasks to this user'
            ], 403);
        }

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;

        if($task->save()) {
            $notification = new Notification();
            $notification->message = 'You have been assigned a new task';
            $notification->user_id = $request->user_id;
            $notification->type = 'task';
            $notification->save();
            return response()->json([
                'message' => 'success',
                'data' => $task,
            ]);
        }

        return response()->json([
            'message' => 'error',
            'data' => 'Task could not be created'
        ], 500);

    }

    public function update(Task $task, Request $request) {
        if($request->user()->id == $task->user_id && in_array($task->status, ['not started', 'in progress'])) {
            $request->validate([
                'status' => 'required|string|in:in progress,pending',
            ]);
            $task->status = $request->status;
            if($task->save() ) {
                return response()->json([
                    'message' => 'success',
                    'data' => $task,
                ]);
            }
        }

        if($request->user()->id == $task->user->manager_id && $task->status == 'pending') {
            $request->validate([
                'status' => 'required|string|in:accepted,rejected',
                'comments'  =>  'nullable|string',
            ]);
            $task->status = $request->status;
            $task->comments = $request->comments;
            if($task->save() ) {
                $notification = new Notification();
                $notification->message = 'Your task has been ' . $request->status . ' by your manager';
                $notification->user_id = $task->user_id;
                $notification->type = 'task';
                $notification->save();

                return response()->json([
                    'message' => 'success',
                    'data' => $task,
                ]);
            }
        }

        return response()->json([
            'message' => 'error',
            'data' => 'Task could not be updated'
        ], 500);
    }
}
