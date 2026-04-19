<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null,
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user);

            return redirect()->intended(route('home')); 

        } catch (\Exception $e) {
            return redirect(filament()->getLoginUrl())->withErrors([
                'email' => 'Gagal login menggunakan Google. Silakan coba lagi.',
            ]);
        }
    }
}
