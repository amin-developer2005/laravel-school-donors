<?php

namespace App\Providers;

use App\Livewire\Auth\Donors\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Auth\StatefulGuard;
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
        $this->app->singleton(Login::class, function ($app) {
            return new Login($this->app->make(StatefulGuard::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('donors.forgottenPassword', function (Request $request) {
            $key = $request->user()?->id ?: $request->ip();
            dd($key);
            return Limit::perSecond(2)->by($key);
        });
    }


    private function configureRateLimiting(): void
    {

    }
}
