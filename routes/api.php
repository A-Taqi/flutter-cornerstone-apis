<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Project 1
Route::prefix("burgan-bill")->group(function () {
    Route::get("/", function () {
        return "Burgan Bill";
    });
    Route::post("/signup", [App\Http\Controllers\Project1\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project1\AuthController::class, "login"]);

    // Protected Routes
    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/subscriptions", [App\Http\Controllers\Project1\SubscriptionsController::class, "index"]);
        Route::post("/subscriptions", [App\Http\Controllers\Project1\SubscriptionsController::class, "store"]);
    });
});

// Project 2
Route::prefix("tasky")->group(function () {
    Route::get("/", function () {
        return "Tasky";
    });

    Route::post("/signup", [App\Http\Controllers\Project2\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project2\AuthController::class, "login"]);

    // Protected Routes
    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/profile", [App\Http\Controllers\Project2\ProfileController::class, "index"]);
        Route::put("/profile", [App\Http\Controllers\Project2\ProfileController::class, "update"]);
        Route::get("/notifications", [App\Http\Controllers\Project2\NotificationsController::class, "index"]);
        Route::get("/tasks", [App\Http\Controllers\Project2\TasksController::class, "index"]);
        Route::post("/tasks", [App\Http\Controllers\Project2\TasksController::class, "store"]);
        Route::put("/tasks/{task}", [App\Http\Controllers\Project2\TasksController::class, "update"]);
        Route::get("/leave-requests", [App\Http\Controllers\Project2\LeaveRequestsController::class, "index"]);
        Route::post("/leave-requests", [App\Http\Controllers\Project2\LeaveRequestsController::class, "store"]);
        Route::put("/leave-requests/{leaveRequest}", [App\Http\Controllers\Project2\LeaveRequestsController::class, "update"]);
//        Route::post("/logout", [App\Http\Controllers\Project1\AuthController::class, "logout"]);
    });
});

// Project 3
Route::prefix("burgan-app")->group(function () {
    Route::get("/", function () {
        return "Burgan App";
    });

    Route::post("/signup", [App\Http\Controllers\Project3\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project3\AuthController::class, "login"]);

    // Protected Routes
    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/accounts", [App\Http\Controllers\Project3\AccountsController::class, "index"]);
        Route::post("/accounts", [App\Http\Controllers\Project3\AccountsController::class, "store"]);
        Route::get("/cards", [App\Http\Controllers\Project3\CardsController::class, "index"]);
        Route::post("/cards", [App\Http\Controllers\Project3\CardsController::class, "store"]);
    });
});

// Project 4
Route::prefix("burgan-assistant")->group(function () {
    Route::get("/", function () {
        return "Burgan Assistant";
    });

    Route::post("/signup", [App\Http\Controllers\Project4\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project4\AuthController::class, "login"]);
});

