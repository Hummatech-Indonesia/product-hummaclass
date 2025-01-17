<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\TransactionController;
use App\Http\Controllers\PaymentController;

// Tripay

Route::middleware('enable.cors')->group(function () {
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::get('transactions-user', [TransactionController::class, 'getByUser'])->middleware('auth:sanctum');
    Route::get('payment-channels', [TransactionController::class, 'getPaymentChannels']);
    Route::get('payment-instructions', [TransactionController::class, 'getPaymentInstructions']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('transaction-signature', [TransactionController::class, 'generateSignature']);
        Route::get('transaction-create/{productType}/{id}', [TransactionController::class, 'store']);
        Route::get('return-callback', [TransactionController::class, 'returnCallback']);
        Route::post('payments-create', [PaymentController::class, 'store']);
        Route::get('check-status/{reference}', [TransactionController::class, 'checkStatus']);
        Route::get('transaction/{reference}/detail', [TransactionController::class, 'show']);
    });
    Route::post('callback', [TransactionController::class, 'callback'])->middleware('tripay.signature');
    Route::post('callback-payment', [PaymentController::class, 'callback'])->middleware('tripay.signature');
});
