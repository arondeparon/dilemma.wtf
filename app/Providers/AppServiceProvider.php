<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        RateLimiter::for('votes', function (Request $request) {
            if (! $request->route('hash')) {
                return Limit::none();
            }

            return Limit::perHour(1)
                ->by($request->ip().':'.$request->route('hash'));
        });
    }
}
