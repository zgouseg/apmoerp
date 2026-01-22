<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Branch;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // M2 FIX: Rate limiting configuration moved to AppServiceProvider for Laravel 11/12 compatibility
        // See AppServiceProvider::configureRateLimiting() for rate limiter definitions

        // Parameter patterns
        Route::pattern('id', '[0-9]+');

        // Simple binding for {branch}
        Route::bind('branch', function ($value) {
            return Branch::query()->findOrFail($value);
        });
    }
}
