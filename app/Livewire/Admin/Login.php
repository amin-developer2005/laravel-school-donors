<?php

namespace App\Livewire\Admin;

use App\Actions\Fortify\PasswordValidationRules;
use App\Services\LoginRateLimiterService;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    use PasswordValidationRules;

    public string $email {
        set => $this->email = $value;
        get => $this->email;
    }
    public string $password {
        set => $this->password = $value;
        get => $this->password;
    }
    public bool $rememberMe {
        set => $this->rememberMe = $value;
        get => $this->rememberMe ?? false;
    }

    protected array $rules {
        get {
            return [
                'email'     => ['required', 'string', 'email', 'max:255'],
                'password'   => ['required', 'string'],
            ];
        }
    }

    protected StatefulGuard $guard {
        set => $this->guard = $value;
        get {
            return $this->guard;
        }
    }


    protected LoginRateLimiterService $rateLimiterService {
        set => $this->rateLimiterService = $value;
        get {
            return $this->rateLimiterService;
        }
    }



    public function mount(StatefulGuard $guard, LoginRateLimiterService $rateLimiterService): void
    {
        $this->guard = $guard;
        $this->rateLimiterService = $rateLimiterService;
    }


    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $this->ensureThisIsNotThrottled();
        $this->validate();

        if (! $this->guard->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->rememberMe)
        ) {
            $this->fireFailedEvent();
            $this->throwFailedAuthenticationException();
        }

        $this->rateLimiterService->clear($this->email);
        Session::regenerate();

        $this->redirectRoute('filament.admin.pages.dashboard', navigate: true);
    }


    /**
     * @throws ValidationException
     */
    private function throwFailedAuthenticationException()
    {
        $this->rateLimiterService->hit($this->email);

        throw ValidationException::withMessages([
            'email'   => [trans('auth.failed')],
        ])->errorBag('login');
    }


    private function fireFailedEvent(): void
    {
        $user = $this->guard->user() ?? null;

        event(new Failed($this->guard?->name, $user, [
            'email' => $this->email,
            'password' => $this->password,
        ]));
    }


    /**
     * @throws ValidationException
     */
    private function ensureThisIsNotThrottled(): void
    {
        if (! $this->rateLimiterService->hasExceededAttempts($this->email)) {
            return;
        }

        event(new Lockout(request()));

        $this->throwThrottledException();
    }

    /**
     * @throws ValidationException
     */
    protected function throwThrottledException(): void
    {
        $seconds = $this->rateLimiterService->availableIn($this->email);

        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60)
            ])]
        ]);
    }


    public function render()
    {
        return view('livewire.admin.login')->layout('components.layouts.auth');
    }
}
