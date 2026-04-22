<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictAdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (! $user) {
            return $next($request);
        }

        if (
            $request->routeIs('filament.admin.auth.email-verification.*') ||
            $request->routeIs('filament.admin.auth.logout')
        ) {
            return $next($request);
        }

        if (
            $user instanceof MustVerifyEmail &&
            ! $user->hasVerifiedEmail()
        ) {
            return redirect()->to(Filament::getEmailVerificationPromptUrl());
        }

        if (! $user->canAccessDashboard()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
