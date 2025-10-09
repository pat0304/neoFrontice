<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->prefix('v1')->group(function () {
    foreach (glob(__DIR__ . '/api/v1/*.php') as $routeFile) {
        require_once $routeFile;
    }
});


Route::middleware('api')->prefix('v2')->group(function () {
    foreach (glob(__DIR__ . '/api/v2/*.php') as $routeFile) {
        require_once $routeFile;
    }
});
