<?php

namespace App\Providers;

use App\Livewire\Auth\Donors\Login;
use Illuminate\Contracts\Auth\StatefulGuard;
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
        //
    }
}
