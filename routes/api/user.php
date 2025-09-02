<?php

use App\Http\Controllers\v1\Client\User\UserController;

use Illuminate\Support\Facades\Route;

Route::prefix('user')->middleware(['auth', 'role:all'])->group(function () {
    Route::put('update', [UserController::class, 'update']);
});
