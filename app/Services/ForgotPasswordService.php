<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;


class ForgotPasswordService
{
    protected PasswordBroker $passwordBroker {
        set => $this->passwordBroker = $value;
        get => $this->passwordBroker;
    }

    /**
     * Create a new class instance.
     */
    public function __construct(PasswordBroker $passwordBroker)
    {
        $this->passwordBroker = $passwordBroker;
    }


    public function sendResetLink(string $email): string
    {
        $status = $this->passwordBroker->sendResetLink([
            'email'  => $email,
        ]);

        return $status;
    }
}
