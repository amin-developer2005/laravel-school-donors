<?php

namespace App\Livewire\Auth\Donors;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use App\Services\ResetPasswordService;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ResetPassword extends Component
{
    use PasswordValidationRules;

    public string $token {
        set => $this->token = $value;
        get => $this->token;
    }

    public string $email {
        set => $this->email = $value;
        get => $this->email;
    }

    public string $password {
        set => $this->password = $value;
        get => $this->password;
    }

    public string $password_confirmation {
        set => $this->password_confirmation = $value;
        get => $this->password_confirmation;
    }

    public ResetPasswordService $resetPasswordService {
        set => $this->resetPasswordService = $value;
        get => $this->resetPasswordService;
    }

    public User $user {
        set => $this->user = $value;
        get => $this->user;
    }


    protected array $rules {
        get {
            return [
                'email'    => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
                'password' => $this->passwordRules(),
                'token'    => ['required', 'string'],
            ];
        }
    }


    public function mount(ResetPasswordService $resetPasswordService,): void
    {
        $this->resetPasswordService = $resetPasswordService;
    }


    public function store(): void
    {
        $this->validate();

        $status = $this->resetPasswordService->reset(
            $this->only('email', 'password', 'password_confirmation', 'token')
        );

        if ($status !== Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('donors.login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.donors.reset-password');
    }
}
