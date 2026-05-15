<?php

namespace App\Providers;

use App\Http\Responses\FilamentEmailVerificationResponse;
use App\Http\Responses\FilamentRegistrationResponse;
use Filament\Auth\Http\Responses\Contracts\EmailVerificationResponse as EmailVerificationResponseContract;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse as RegistrationResponseContract;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RegistrationResponseContract::class, FilamentRegistrationResponse::class);
        $this->app->bind(EmailVerificationResponseContract::class, FilamentEmailVerificationResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Event::listen(function (Login $event) {
            // Beri tanda rahasia di session bahwa dia baru saja login
            session()->put('baru_login', true);
        });
        
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_REGISTER_FORM_AFTER,
            fn (): string => Blade::render('
                <div style="display: flex; align-items: center; justify-content: center; margin-top: 0.1rem; margin-bottom: 0.1rem;">
                    <div style="flex-grow: 1; height: 1px; background-color: #d1d5db;"></div>
                    <span style="padding: 0 10px; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap;">
                        Atau Lebih Cepat
                    </span>
                    <div style="flex-grow: 1; height: 1px; background-color: #d1d5db;"></div>
                </div>
                <div style="margin-top: 0.01rem;">
                    <a href="{{ route(\'google.login\') }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); text-decoration: none;" onmouseover="this.style.backgroundColor=\'#f9fafb\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="height: 1.25rem; width: 1.25rem; flex-shrink: 0;">
                        Daftar dengan Google
                    </a>
                </div>
            ')
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            fn (): string => Blade::render('
                <div style="display: flex; align-items: center; justify-content: center; margin-top: 0.1rem; margin-bottom: 0.1rem;">
                    <div style="flex-grow: 1; height: 1px; background-color: #d1d5db;"></div>
                    <span style="padding: 0 10px; font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.1em; white-space: nowrap;">
                        Atau Lebih Cepat
                    </span>
                    <div style="flex-grow: 1; height: 1px; background-color: #d1d5db;"></div>
                </div>
                <div style="margin-top: 0.01rem;">
                    <a href="{{ route(\'google.login\') }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: #374151; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); text-decoration: none;" onmouseover="this.style.backgroundColor=\'#f9fafb\'" onmouseout="this.style.backgroundColor=\'#ffffff\'">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" style="height: 1.25rem; width: 1.25rem; flex-shrink: 0;">
                        Masuk dengan Google
                    </a>
                </div>
            ')
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::SCRIPTS_AFTER,
            fn (): string => Blade::render(<<<'BLADE'
                <script>
                    (() => {
                        const patchMapPickerRefresh = () => {
                            if (! window.mapPicker || window.mapPicker.__akuPeduliZoomPatched) {
                                return;
                            }

                            const originalFactory = window.mapPicker;

                            const extractPayload = (payload) => {
                                if (payload && typeof payload === 'object' && 'detail' in payload) {
                                    return payload.detail ?? {};
                                }

                                return payload ?? {};
                            };

                            const patchedFactory = ($wire, config) => {
                                const instance = originalFactory($wire, config);
                                const originalRefreshMap = instance.refreshMap?.bind(instance);

                                instance.refreshMap = function (payload = {}) {
                                    const detail = extractPayload(payload);
                                    const zoom = Number(detail?.zoom);

                                    if (this.map && Number.isFinite(zoom)) {
                                        this.map.flyTo(this.getCoordinates(), zoom);
                                        this.updateMarker();

                                        return;
                                    }

                                    return originalRefreshMap?.(detail);
                                };

                                return instance;
                            };

                            patchedFactory.__akuPeduliZoomPatched = true;
                            window.mapPicker = patchedFactory;
                        };

                        patchMapPickerRefresh();
                        window.addEventListener('map-script-loaded', patchMapPickerRefresh);
                    })();
                </script>
            BLADE)
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
