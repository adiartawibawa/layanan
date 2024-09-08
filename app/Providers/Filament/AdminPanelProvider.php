<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EmailVerification;
use App\Filament\Pages\Auth\RequestPasswordReset;
use App\Filament\Pages\Dashboard;
use App\Livewire\MyPersonalInfo;
use App\Settings\GeneralSettings;
use Filament\FontProviders\BunnyFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->passwordReset(RequestPasswordReset::class)
            ->emailVerification(EmailVerification::class)
            ->favicon(fn (GeneralSettings $settings) => Storage::url($settings->app_favicon))
            ->brandName(fn (GeneralSettings $settings) => $settings->app_name)
            ->brandLogo(fn (GeneralSettings $settings) => Storage::url($settings->app_logo))
            ->colors([
                'primary' => Color::Rose,
            ])
            ->font('Figtree', provider: BunnyFontProvider::class)
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()->databaseNotificationsPolling('30s')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ])
            ->globalSearch()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->plugins([
                \BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'md' => 2
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true,
                        shouldRegisterNavigation: false,
                        navigationGroup: 'Settings',
                        hasAvatars: true,
                        slug: 'profile'
                    )
                    ->myProfileComponents([
                        'personal_info' => MyPersonalInfo::class
                    ])
                    ->passwordUpdateRules(
                        rules: [Password::default()->mixedCase()->uncompromised(3)],
                        requiresCurrentPassword: true,
                    )
                    ->enableTwoFactorAuthentication(force: false)
                    ->enableSanctumTokens(permissions: ["create", "view", "update", "delete"])
            ]);
    }

    public function boot()
    {
        FilamentAsset::register([
            Css::make('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'),
            Css::make('leaflet-marker-cluster-css', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.Default.min.css'),
            Js::make('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'),
            Js::make('leaflet-marker-cluster-js', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.min.js'),
        ]);
    }
}
