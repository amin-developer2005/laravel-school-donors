<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class SignIn extends Component
{
    protected string $layout = 'layouts.auth';
    public string $email {
        set => $this->email = $value;
        get => $this->email;
    }

    public string $password {
        set => $this->password = $value;
        get => $this->password;
    }

    public bool $remember {
        set => $this->remember = $value;
        get => $this->remember;
    }

    public function login()
    {
        dd("ggg");
    }

    public function render()
    {
        return view('livewire.auth.sign-in');
    }
}
