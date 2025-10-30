<?php

use Illuminate\Support\Facades\Route;

Route::prefix("admin")->middleware(['auth', 'role:admin'])->group(function () {
    foreach (glob(__DIR__ . '/admin/*.php') as $routeFile) {
        require_once $routeFile;
    }
});
