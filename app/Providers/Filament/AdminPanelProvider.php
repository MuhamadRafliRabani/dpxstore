<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('admin')
            ->authPasswordBroker('admins')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])
            ->userMenuItems([
                'profile' => \Filament\Navigation\MenuItem::make()->label('Edit profile'),
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Konfigurasi Website')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->collapsed(false),

                NavigationGroup::make()
                    ->label('Produk & Layanan')
                    ->icon('heroicon-o-inbox')
                    ->collapsed(false),

                NavigationGroup::make()
                    ->label('Manajemen Kontent')
                    ->icon('heroicon-o-cloud')
                    ->collapsed(false),

                NavigationGroup::make()
                    ->label('Admin & User Management')
                    ->icon('heroicon-o-users')
                    ->collapsed(false),

                NavigationGroup::make()
                    ->label('Integrasi & API')
                    ->icon('heroicon-o-code-bracket')
                    ->collapsed(true),
            ])
            // ->viteTheme('resources/css/admin-panel1.css')
        ;
    }
}
