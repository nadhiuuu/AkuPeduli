<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menyisipkan tombol di bawah form Register
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_REGISTER_FORM_AFTER,
            fn (): string => Blade::render('
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route(\'google.login\') }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); text-decoration: none;" onmouseover="this.style.backgroundColor=\'#f9fafb\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="height: 1.25rem; width: 1.25rem; flex-shrink: 0;">
                        Daftar dengan Google
                    </a>
                </div>
            ')
        );

        // Menyisipkan tombol di bawah form Login
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            fn (): string => Blade::render('
                <div style="margin-top: 1.5rem;">
                    <a href="{{ route(\'google.login\') }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); text-decoration: none;" onmouseover="this.style.backgroundColor=\'#f9fafb\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="height: 1.25rem; width: 1.25rem; flex-shrink: 0;">
                        Lanjutkan dengan Google
                    </a>
                </div>
            ')
        );

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Email Anda - AkuPeduli!')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Terima kasih telah bergabung dengan platform AkuPeduli! Satu langkah lagi sebelum Anda bisa mulai berdonasi atau membuat kampanye.')
                ->line('Silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:')
                ->action('Verifikasi Alamat Email', $url)
                ->line('Jika Anda tidak merasa mendaftar di platform kami, abaikan saja pesan email ini.');
        });
    }
}
