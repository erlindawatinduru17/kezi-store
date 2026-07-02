<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Redirect setelah login
     */
    public const HOME = '/dashboard';

    /**
     * Boot route
     */
    public function boot(): void
    {
        // RATE LIMIT API
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?? $request->ip()
            );
        });

        // LOAD ROUTES
        $this->routes(function () {

            // API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // WEB
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}