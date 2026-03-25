<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;

// Apply rate limiting to all API routes
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::get('users/{uuid}', [UserController::class, 'show']);
    Route::post('/wallets', [WalletController::class, 'store']);
    Route::get('wallets/{uuid}', [WalletController::class, 'show']);
    Route::post('/transactions', [TransactionController::class, 'store']);
});
