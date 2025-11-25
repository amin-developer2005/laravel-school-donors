<?php

namespace App\Livewire\Auth\Donors;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
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
            return $this->guard ?? app(StatefulGuard::class);
        }
    }



    public function mount(StatefulGuard $guard): void
    {
        $this->guard = $guard;
    }


    /**
     * @throws ValidationException
     */
    public function store(): void
    {
        $this->validate();

        if (! $this->guard->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->rememberMe)
        ) {
            $this->fireFailedEvent();
            $this->throwFailedAuthenticationException();
        }

        Session::regenerate();

        $this->redirectRoute('filament.admin.pages.dashboard', navigate: true);
    }


    private function throwFailedAuthenticationException()
    {
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

    public function render()
    {
        return view('livewire.auth.donors.login')->layout('components.layouts.auth');
    }
}
