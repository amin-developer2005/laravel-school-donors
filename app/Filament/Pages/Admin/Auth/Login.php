<?php

namespace App\Filament\Pages\Admin\Auth;

use Filament\Pages\Page;
use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.admin.auth.login';
}
