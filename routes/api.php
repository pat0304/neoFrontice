<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    foreach (glob(__DIR__ . '/api/*.php') as $routeFile) {
        require_once $routeFile;
    }
});
