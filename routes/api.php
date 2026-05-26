<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatBreedController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\ViewHistoryController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return "OK";
});

// @TODO: Move Auth endpoint from /api to /auth

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// @TODO: External API requires local SSL certificate to be configured
Route::get
('/cats',    [CatController::class, 'index']);
Route::get('/cats/breeds',    [CatBreedController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('view-histories', ViewHistoryController::class);
});
