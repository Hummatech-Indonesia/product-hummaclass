<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\TripayController;
// Tripay
Route::get('payment-channels', [TripayController::class, 'getPaymentChannels']);
Route::get('payment-instructions', [TripayController::class, 'getPaymentInstructions']);
Route::get('transaction-signature', [TripayController::class, 'generateSignature']);
Route::get('transaction-create', [TripayController::class, 'createTransaction']);

Route::get('callback', [TripayController::class, 'callback']);
Route::get('return-callback', [TripayController::class, 'returnCallback']);
Route::get('check-status', [TripayController::class, 'checkStatus']);