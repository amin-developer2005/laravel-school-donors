<?php

namespace App\Providers;

use App\Livewire\Auth\Donors\Login;
use App\Models\Project;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Login::class, function ($app) {
            return new Login();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }



    private function configureRateLimiting(): void
    {
        RateLimiter::for('donors.forgottenPassword', function (Request $request) {
            $key = $request->user()?->id ?: $request->ip();

            return Limit::perSecond(2)->by($key);
        });

        RateLimiter::for('donors.forgottenPassword', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(2)->by($throttleKey);
        });

        RateLimiter::for('donors.login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(2)->by($throttleKey);
        });
    }
}
