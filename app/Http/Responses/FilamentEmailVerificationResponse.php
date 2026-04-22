<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\EmailVerificationResponse as EmailVerificationResponseContract;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class FilamentEmailVerificationResponse implements EmailVerificationResponseContract
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        Filament::auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to(Filament::getLoginUrl());
    }
}
