<?php

use App\Console\Commands\DeleteTempFile;
use App\Console\Commands\MakeResponseCommand;
use App\Console\Commands\MakeServiceCommand;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Challenge;
use App\Policies\ChallengePolicy;
use App\Providers\GCSFilesystemServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Gate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )->withProviders([
        GCSFilesystemServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api([
            \App\Http\Middleware\UseJwtFromCookie::class,
            \App\Http\Middleware\ForceJsonResponse::class,
            \App\Http\Middleware\SetApiLocale::class,
        ]);
        $middleware->alias([
            'auth' => AuthMiddleware::class,
            'role' => RoleMiddleware::class
        ]);
    })->withCommands([
        MakeServiceCommand::class,
        MakeResponseCommand::class,
        DeleteTempFile::class
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
