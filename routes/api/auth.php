<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::middleware("role:all")->group(function () {
        Route::post('profile', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
