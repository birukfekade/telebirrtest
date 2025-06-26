<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TelebirrController;

Route::get('/pay', [TelebirrController::class, 'showPayForm']);
Route::post('/pay', [TelebirrController::class, 'submitPayment']);
Route::post('/telebirr/notify', [TelebirrController::class, 'handleCallback']);
Route::get('/payment/success', [TelebirrController::class, 'handleRedirect']);