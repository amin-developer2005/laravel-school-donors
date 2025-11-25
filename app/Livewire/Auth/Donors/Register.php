<?php

namespace App\Livewire\Auth\Donors;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use App\Providers\Filament\SchoolDonorsPanelProvider;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Register extends Component
{
    use PasswordValidationRules;

    public string $username {
        set => $this->username = $value;
        get => $this->username;
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

    protected StatefulGuard $guard {
        set => $this->guard = $value;
        get => $this->guard;
    }

   protected array $rules {
        get {
            return [
                    'username'  => ['required', 'string', 'min:3', 'max:255'],
                    'email'     => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
                    'password'   => $this->passwordRules(),
                ];
        }
   }

    public function mount(): void
    {
        $this->guard = app(StatefulGuard::class);
    }


    public function store(CreateNewUser $creator): void
    {
        $this->guard = app(StatefulGuard::class);
        $this->validate();
        $this->password = Hash::make($this->password);

        $user = $creator->create(['email' => $this->email, 'password' => $this->password, 'name' => $this->username]);

        //$user->donor()->create();
        $this->guard->login($user);

        $this->redirectRoute('filament.schoolDonors.pages.dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.donors.register')->layout('components.layouts.auth');
    }
}
