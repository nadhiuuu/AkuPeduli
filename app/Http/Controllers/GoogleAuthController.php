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

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $user->avatar ? $user->avatar : $googleUser->avatar,
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null,
                    'email_verified_at' => now(),
                    'role' => 'user',
                ]);
            }

            Auth::login($user);

            return redirect()->intended(route('home')); 

        } catch (\Exception $e) {
            return redirect(filament()->getLoginUrl())->withErrors([
                'email' => 'Gagal login menggunakan Google. Silakan coba lagi.',
            ]);
        }
    }
}
