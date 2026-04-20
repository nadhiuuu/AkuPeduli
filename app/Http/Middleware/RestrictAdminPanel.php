<?php

namespace App\Http\Middleware;

use Closure;
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

        // Jika user mencoba masuk ke halaman /admin tapi dia adalah donatur biasa
        if ($user && !$user->canAccessDashboard()) {
            // Lempar/usir kembali ke halaman Home
            return redirect()->route('home');
        }

        return $next($request);
    }
}
