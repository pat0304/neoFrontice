<?php

use App\Http\Controllers\v1\File\FileController;
use Illuminate\Support\Facades\Route;

Route::prefix('file')->middleware(['auth', 'role:all'])->group(function () {
    Route::post('upload', [FileController::class, 'upload']);
    Route::post('create', [FileController::class, 'create']);
});
