<?php

namespace App\Livewire\Auth\Donors;

use App\Services\ForgotPasswordRateLimiterService;
use App\Services\ForgotPasswordService;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;


class ForgotPassword extends Component
{
    public string $email {
        set => $this->email = $value;
        get => $this->email;
    }

    protected ForgotPasswordService $forgotPasswordService {
        set => $this->forgotPasswordService = $value;
        get {
            return $this->forgotPasswordService ?? app(ForgotPasswordService::class);
        }
    }

    protected ForgotPasswordRateLimiterService $rateLimiterService {
        set => $this->rateLimiterService = $value;
        get {
            return $this->rateLimiterService ?? app(ForgotPasswordRateLimiterService::class);
        }
    }
    protected array $rules {
        set => $this->rules = $value;
        get {
            return $this->rules ?? [
                'email'  => ['required', 'string', 'email', 'max:255'],
            ];
        }
    }
    public function mount(
        ForgotPasswordService $forgotPasswordService,
        ForgotPasswordRateLimiterService $rateLimiterService
    ): void
    {
        $this->forgotPasswordService = $forgotPasswordService;
        $this->rateLimiterService = $rateLimiterService;
    }


    /**
     * @throws ValidationException
     */
    public function sendPasswordResetLink(): void
    {
        $this->ensureIsNotThrottled();
        $this->validate();

        $status = $this->forgotPasswordService->sendResetLink($this->email);


        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            $this->rateLimiterService->hit($this->email);

            return;
        }

        $this->reset('email');
        $this->rateLimiterService->clear($this->email);

        session()->flash('status', __(" passwords.reset"));
    }


    /**
     * @throws ValidationException
     */
    protected function ensureIsNotThrottled(): void
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
            'email' => __('passwords.throttled', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])
        ]);
    }


    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.auth.donors.forgot-password')
            ->layout("components.layouts.auth");
    }
}
