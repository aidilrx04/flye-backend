<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('unauthorized', function () {
    return response()->json(['messsage' => '401 Unauthorized'], 401);
})->name('login');

Route::prefix('auth')->group(function () {
    Route::post('signup', [AuthController::class, 'signUp']);
    Route::post('signin', [AuthController::class, 'signIn']);
    Route::middleware('auth:sanctum')->post('verify', [AuthController::class, 'verify']);
});

Route::apiResource('users', UserController::class)->except(['store']);

Route::apiResource('products', ProductController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('orders', OrderController::class);
    Route::prefix('orders')->group(function () {
        Route::post('status', [OrderController::class, 'status'])->name('orders.status');
    });

    Route::prefix('carts')->group(function () {
        Route::post('bulkSave', [CartItemController::class, 'store_bulk'])->name('bulkSave');
    });
    Route::apiResource('carts', CartItemController::class);
});
