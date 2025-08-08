<?php

use App\Console\Commands\MakeResponseCommand;
use App\Console\Commands\MakeServiceCommand;
use App\Exceptions\AppException;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api([
            \App\Http\Middleware\UseJwtFromCookie::class,
            \App\Http\Middleware\ForceJsonResponse::class,
            \App\Http\Middleware\SetApiLocale::class,
        ]);
        $middleware->alias(['auth' => AuthMiddleware::class]);
    })->withCommands([MakeServiceCommand::class, MakeResponseCommand::class])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
