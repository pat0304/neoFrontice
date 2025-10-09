<?php

use Illuminate\Support\Facades\Route;

Route::prefix("auth/password")->middleware(['api', 'auth', 'role:all'])->group(function () {
    Route::put(
        '/change',
        [\App\Http\Controllers\v1\Auth\PasswordController::class, 'changePassword']
    );
});
Route::prefix("auth/password")->middleware(['api'])->group(function () {
    Route::post(
        '/send-mail',
        [\App\Http\Controllers\v1\Auth\PasswordController::class, 'sendMailVerify']
    );
    Route::get(
        '/reset',
        [\App\Http\Controllers\v1\Auth\PasswordController::class, 'resetPassword']
    );
});
