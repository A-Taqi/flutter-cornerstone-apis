<?php

namespace App\Http\Controllers\Project2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index(Request $request) {
        return response()->json([
            'message' => 'success',
            'data' => [
                'employees' => $request->user()->p2_employees,
            ]
        ]);
    }
}
