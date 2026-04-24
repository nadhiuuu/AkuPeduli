<?php

namespace App\Providers\Filament;

use App\Http\Middleware\RestrictAdminPanel;
use Caresome\FilamentAuthDesigner\AuthDesignerPlugin;
use Caresome\FilamentAuthDesigner\Enums\MediaPosition;
use Filament\Enums\DatabaseNotificationsPosition;
use Filament\Http\Middleware\Authenticate;
// use Filament\Pages\Dashboard;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
// use Filament\Widgets\FilamentInfoWidget;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
// use Caresome\FilamentAuthDesigner\Data\AuthPageConfig;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->favicon('favicon.ico')
            ->globalSearch(false)
            ->databaseNotifications(position: DatabaseNotificationsPosition::Topbar)
            ->brandLogo(fn () => asset('assets/AkuPeduli color.png'))
            ->brandLogoHeight('6rem')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                // Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                RestrictAdminPanel::class,
            ])
            ->plugins([
                AuthDesignerPlugin::make()
                    ->defaults(
                        fn ($config) => $config
                            ->media(asset('assets/Background.jpg'))
                            ->mediaPosition(MediaPosition::Right)
                            ->blur(0)
                    )
                    ->login()
                    ->registration()
                    ->passwordReset(
                        fn ($config) => $config
                            ->mediaPosition(MediaPosition::Right)
                            ->mediaSize('45%')
                    )
                    ->emailVerification()
                    ->themeToggle(),

                FilamentEditProfilePlugin::make()
                    ->slug('edit-profil')
                    ->setTitle('Edit Profil')
                    ->setNavigationLabel('Edit Profil')
                    ->setNavigationGroup('Akun')
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->shouldRegisterNavigation(false)
                    ->shouldShowEmailForm()
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowSanctumTokens()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(),
                // ->customProfileComponents([
                //     \App\Livewire\CustomProfileComponent::class,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('Edit Profil')
                    ->url(fn (): string => route('filament.admin.pages.edit-profil'))
                    ->icon('heroicon-o-user-circle'),
                'home' => MenuItem::make()
                    ->label('Kembali ke Web')
                    ->url(fn (): string => route('home'))
                    ->icon('heroicon-o-home'),
            ])
            ->navigationItems([
                NavigationItem::make('Kembali ke Web')
                    ->url(fn (): string => route('home'))
                    ->icon('heroicon-o-arrow-left-on-rectangle')
                    ->group('Lainnya')
                    ->sort(100),
            ]);

    }
}
