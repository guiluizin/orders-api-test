<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AccountWidget;
use App\Filament\Widgets\BestFiveSellersTable;
use App\Filament\Widgets\MediumTicketWidget;
use App\Filament\Widgets\DailyOrdersChart;
use App\Filament\Widgets\OrderStats;
use App\Filament\Widgets\ProvinceRefundsChart;
use App\Filament\Widgets\TopProductWidget;
use App\Filament\Widgets\TopTenCitiesWidget;
use App\Filament\Widgets\UpsellStats;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
            ->path('')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->brandLogo(asset('images/logo.svg'))
            ->brandLogoHeight('3rem')
            ->darkMode(true, true)
            ->favicon(asset('images/favicon.png'))
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
                OrderStats::class,
                BestFiveSellersTable::class,
                TopProductWidget::class,
                MediumTicketWidget::class,
                TopTenCitiesWidget::class,
                ProvinceRefundsChart::class,
                UpsellStats::class,
                DailyOrdersChart::class
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
            ]);
    }
}
