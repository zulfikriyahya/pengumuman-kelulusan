<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfileCustom;
use App\Filament\Pages\Auth\ForgotPasswordCustom;
use App\Filament\Pages\Auth\LoginCustom;
use App\Filament\Pages\Auth\RegisterCustom;
use App\Filament\Pages\Auth\VerifikasiOtp;
use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->theme(asset('css/filament/admin/theme.css'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            // ->login(LoginCustom::class)
            // ->registration(RegisterCustom::class)
            // ->passwordReset(ForgotPasswordCustom::class)
            // ->emailVerification(VerifikasiOtp::class)
            // ->profile(EditProfileCustom::class)
            ->spa()
            ->breadcrumbs(false)
            ->topNavigation()
            ->maxContentWidth(Width::Full)
            // ->simplePageMaxContentWidth(Width::Small)
            ->globalSearch(false)
            ->databaseNotifications()
            ->unsavedChangesAlerts()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->favicon(asset('images/default.png'))
            ->brandName('Academic Graduation Portal')
            ->darkModeBrandLogo(asset('/images/brand-darkmode.png'))
            ->brandLogo(asset('/images/brand-lightmode.png'))
            // ->brandLogo(asset('images/default.png'))
            ->brandLogoHeight('2.6rem')
            ->defaultThemeMode(ThemeMode::Dark)
            ->darkMode(true)
            ->font('Lexend')
            // ->navigationGroups([
            //     'Instansi',
            //     'Tahun Pelajaran',
            //     'Personil',
            //     'Alumni',
            //     'Siswa',
            //     'Tamu Undangan',
            // ])
            ->navigationItems([
                NavigationItem::make('Whatsapp')
                    ->url('https://wapi.zedlabs.id', shouldOpenInNewTab: true)
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->sort(7)
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
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
            ])
            ->plugins([
                EasyFooterPlugin::make()
                    ->withFooterPosition('footer')
                    ->withBorder()
                    ->hiddenFromPagesEnabled()
                    ->withSentence(new HtmlString('MTsN 1 Pandeglang | Crafted with dedication by<a href="https://zedlabs.id" target="_blank"><b>Yahya Zulfikri</b></a>')),
                AuthUIEnhancerPlugin::make()
                    ->formPanelPosition('left')
                    ->formPanelWidth('40%')
                    ->emptyPanelBackgroundColor(Color::hex('#010101'))
                    ->emptyPanelBackgroundImageUrl('/images/wallpaper.png')
                    ->emptyPanelBackgroundColor(Color::hex('#010101'))
                    ->showEmptyPanelOnMobile(false),
            ]);
    }
}
