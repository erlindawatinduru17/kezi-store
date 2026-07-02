<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔥 USE BOOTSTRAP 5 PAGINATION
        Paginator::useBootstrapFive();
        
        // 🔥 GLOBAL CONFIGURATION
        // Set default per page for pagination
        Paginator::useBootstrapFive();
    }
}
