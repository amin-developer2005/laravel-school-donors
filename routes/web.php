<?php

use App\Livewire\Auth\Donors\ForgotPassword;
use App\Livewire\Auth\Donors\Login;
use App\Livewire\Auth\Donors\Register;
use App\Livewire\Auth\Donors\ResetPassword;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::permanentRedirect('/', '/home');

Route::get('/home', function () {
    return view('pages/index');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('guest')->prefix('donors')->group(function () {
    Volt::route('login', Login::class)
        ->name('donors.login')
        ->middleware(['throttle:2']);
    Volt::route('register', Register::class)->name('donors.register');

    Volt::route('forgot-password', ForgotPassword::class)
        ->name('donors.forgottenPassword')
        ;
    Volt::route('reset-password', ResetPassword::class)
        ->name('donors.resetPassword');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
