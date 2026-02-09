<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;

class LogoutResponse implements \Filament\Auth\Http\Responses\Contracts\LogoutResponse
{
    public function toResponse($request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->to('/admin/login');
    }
}
