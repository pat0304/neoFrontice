<?php

use App\Http\Controllers\v1\Admin\Challenge\ChallengeController;
use Illuminate\Support\Facades\Route;

Route::prefix("challenges")->group(function () {
    Route::get('', [ChallengeController::class, 'getAll']);
    Route::get('{id}', [ChallengeController::class, 'get']);
    Route::post('', [ChallengeController::class, 'create']);
    Route::post('{id}/translation', [ChallengeController::class, 'add']);
    Route::put('{id}', [ChallengeController::class, 'update']);
    Route::patch('{id}/published', [ChallengeController::class, 'published']);
});
