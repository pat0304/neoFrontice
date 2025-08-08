<?php

use App\Http\Controllers\Auth\EmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth/email')->group(function () {
    Route::post('send', [EmailController::class, 'sendMail']);
    Route::get('verify', [EmailController::class, 'verifyEmailByToken'])->middleware('auth:all');
});
