<?php

namespace App\Http\Controllers\Project2;

use App\Http\Controllers\Controller;
use App\Models\Project2\Employee;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'message' => 'success',
            'data' => [
                'name' => $user->p2_employee?->name,
                'email' => $user->email,
                'role'  =>  $user->role,
            ]
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string',
        ]);
        $employee = $user->p2_employee;
        if(!$employee) {
            $employee = new Employee();
            $employee->user_id = $user->id;
        }
        $employee->name = $request->name;
        if($employee->save()) {
            $user->refresh();
            return response()->json([
                'message' => 'success',
                'data' => [
                    'name' => $user->p2_employee->refresh()->name,
                    'email' => $user->email,
                    'role'  =>  $user->role,
            ]]);
        }

        return response()->json(['message' => 'Failed to update name'])->status(500);
    }
}
