<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordService
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


    /**
     * @param array<array, string> $data
     * @return string
     */
    public function reset(array $data): string
    {
        $status = $this->passwordBroker->reset([
            $data['email'],
            $data['password'],
            $data['password_confirmation'],
            $data['token']
        ], function (User $user, string $newPassword) {
            $user->forceFill([
                'password' => Hash::make($newPassword)
            ])->save();

            $this->completeResetPassword($user);
        });

        return $status;
    }


    public function completeResetPassword(User $user): void
    {
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));
    }


    public function updatePassword(User $user, string $newPassword): void
    {
        $user->forceFill([
            'password' => Hash::make($newPassword)
        ])->save();

        $this->passwordBroker->deleteToken($user);
    }

}
