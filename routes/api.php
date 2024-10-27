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
});

// Project 2
Route::prefix("tasky")->group(function () {
    Route::get("/", function () {
        return "Tasky";
    });

    Route::post("/signup", [App\Http\Controllers\Project2\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project2\AuthController::class, "login"]);
});

// Project 3
Route::prefix("burgan-app")->group(function () {
    Route::get("/", function () {
        return "Burgan App";
    });

    Route::post("/signup", [App\Http\Controllers\Project3\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project3\AuthController::class, "login"]);
});

// Project 4
Route::prefix("burgan-assistant")->group(function () {
    Route::get("/", function () {
        return "Burgan Assistant";
    });

    Route::post("/signup", [App\Http\Controllers\Project4\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project4\AuthController::class, "login"]);
});

