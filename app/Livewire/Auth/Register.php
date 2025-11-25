<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Register extends Component
{
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
    protected $layout = 'layouts.auth';

    public function register()
    {
        dd("ggg");
    }

    public function render()
    {
        return view('livewire.auth.signup')
            ->layout('layouts.auth');
    }
}
