<?php

use App\Http\Controllers\Auth\EmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/email')->middleware('auth:verify')->group(function () {
    Route::post('send', [EmailController::class, 'sendMail']);
    Route::get('verify', [EmailController::class, 'verifyEmailByToken']);
    Route::post('verify', [EmailController::class, 'verifyEmailByOTP']);
});
