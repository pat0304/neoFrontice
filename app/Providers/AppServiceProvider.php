<?php

namespace App\Providers;

use App\Eloquents\AuthEloquent;
use App\Models\User;
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
            ],
            [
                'Password',
                'Auth\\Password'
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
    public function boot(): void
    {
        foreach (glob(app_path('Observers') . '/*Observer.php') as $filename) {
            $observer = 'App\\Observers\\' . pathinfo($filename, PATHINFO_FILENAME);
            $model = 'App\\Models\\' . pathinfo(str_replace('Observer', '', $filename), PATHINFO_FILENAME);
            if (class_exists($observer) && class_exists($model)) {
                $model::observe($observer);
            }
        }
    }
}
