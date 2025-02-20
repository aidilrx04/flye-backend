<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('signup', [AuthController::class, 'signUp']);
    Route::post('signin', [AuthController::class, 'signIn']);
    Route::middleware('auth:sanctum')->post('verify', [AuthController::class, 'verify']);
});

Route::apiResource('users', UserController::class)->except(['store']);

Route::apiResource('products', ProductController::class);
