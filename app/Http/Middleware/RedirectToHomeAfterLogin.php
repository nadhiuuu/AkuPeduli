<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToHomeAfterLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('baru_login')) {
            session()->forget('baru_login');

            if ($request->url() !== route('home')) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}