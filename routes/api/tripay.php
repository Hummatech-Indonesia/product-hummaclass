<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\TransactionController;
// Tripay

Route::middleware('enable.cors')->group(function () {
    Route::get('payment-channels', [TransactionController::class, 'getPaymentChannels']);
    Route::get('payment-instructions', [TransactionController::class, 'getPaymentInstructions']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('transaction-signature', [TransactionController::class, 'generateSignature']);
        Route::get('transaction-create/{course}', [TransactionController::class, 'store']);

        Route::get('return-callback', [TransactionController::class, 'returnCallback']);
        Route::get('check-status', [TransactionController::class, 'checkStatus']);
    });
    Route::post('callback', [TransactionController::class, 'callback'])->middleware('tripay.signature');
});
