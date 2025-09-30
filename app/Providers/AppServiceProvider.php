<?php

namespace App\Providers;

use App\Eloquents\AuthEloquent;
use App\Services\Auth\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * Bind Eloquent to Service
         * Format: [Eloquent, Service]
         */
        $services = [
            [
                "Auth",
                "Auth\\Auth"
            ],
            [
                "Email",
                "Auth\\Email"
            ],
            [
                "User",
                "User"
            ],
            [
                "File",
                "File\\File"
            ]
        ];


        foreach ($services as $service) {
            $this->app->bind(
                "App\\Eloquents\\{$service[0]}Eloquent",
                "App\\Services\\{$service[1]}Service"
            );
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
