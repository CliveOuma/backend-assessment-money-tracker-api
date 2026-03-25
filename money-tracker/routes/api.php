<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;

// Apply rate limiting to all API routes
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/users',      [UserController::class, 'store']);
    Route::get('users/{id}',  [UserController::class, 'show'])->where('id', '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}');
    Route::post('/wallets',      [WalletController::class, 'store']);
    Route::get('wallets/{id}',  [WalletController::class, 'show'])->where('id', '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}');
    Route::post('/transactions', [TransactionController::class, 'store']);
});
