<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Project 1
Route::prefix("project1")->group(function () {
    Route::get("/", function () {
        return "Project 1";
    });
    Route::post("/signup", [App\Http\Controllers\Project1\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project1\AuthController::class, "login"]);
});

// Project 2
Route::prefix("project2")->group(function () {
    Route::get("/", function () {
        return "Project 2";
    });

    Route::post("/signup", [App\Http\Controllers\Project2\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project2\AuthController::class, "login"]);
});

// Project 3
Route::prefix("project3")->group(function () {
    Route::get("/", function () {
        return "Project 3";
    });

    Route::post("/signup", [App\Http\Controllers\Project3\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project3\AuthController::class, "login"]);
});

// Project 4
Route::prefix("project4")->group(function () {
    Route::get("/", function () {
        return "Project 4";
    });

    Route::post("/signup", [App\Http\Controllers\Project4\AuthController::class, "signup"]);
    Route::post("/login", [App\Http\Controllers\Project4\AuthController::class, "login"]);
});

