<?php

namespace App\Providers\Filament;

use App\Http\Middleware\FilamentLocale;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Navigation\MenuItem;
use App\Filament\Pages\Auth\Login;
use Awcodes\Curator\CuratorPlugin;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\URL;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use Datlechin\FilamentMenuBuilder\MenuPanel\StaticMenuPanel;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Filament\View\PanelsRenderHook;
use Livewire\Livewire;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            // ->path('{locale}/backstage')
            ->path('{locale}/admin')
            ->bootUsing(function () {
                $locale = app()->getLocale(); // for dashboard，確保所有 URL 生成時都包含當前 locale
                URL::defaults(['locale' => $locale]);
            })
            ->authGuard('admin') // 這裡指定使用 admin guard
            ->authMiddleware([
                Authenticate::class,
            ])
            ->login()
            // ->login(Login::class)
            ->colors([
                'primary' => Color::Blue,
                // 'primary' => Color::Lime,
                // 'primary' => Color::Amber,
                // 'gray' => Color::Slate, // 這會影響背景色調
                'gray' => Color::Stone, // 這會影響背景色調
            ])
            // ->darkMode(false)
            ->sidebarCollapsibleOnDesktop()
            // ->sidebarFullyCollapsibleOnDesktop()
            ->viteTheme('resources/css/filament/admin/theme.css')
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
                FilamentLocale::class,
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
            ->profile()
            ->userMenuItems([
                // MenuItem::make()
                //     ->label('繁體中文')
                //     ->url('/tw/admin')
                //     ->color('success')
                //     ->icon('heroicon-o-language'),
                // MenuItem::make()
                //     ->label('English')
                //     ->color('info')
                //     ->url('/en/admin')
                //     ->icon('heroicon-o-language'),
                'logout' => MenuItem::make()->url(fn () => route('filament.admin.auth.logout', ['locale' => app()->getLocale()])
                ),
            ])
            ->renderHook(
                // PanelsRenderHook::TOPBAR_END,
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => Livewire::mount('components.language-switcher')
            )
            ->plugins([
                CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Media')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Content')
                    ->navigationSort(3)
                    ->navigationCountBadge()
                    ->registerNavigation(true)
                    ->defaultListView('grid' || 'list'),
                // FilamentMenuBuilderPlugin::make()
                //     ->addLocation('header', 'Header')
                //     ->addLocation('footer', 'Footer')
                //     ->addMenuPanels([
                //         StaticMenuPanel::make()
                //             ->addMany([
                //                 'Home' => url('/'),
                //                 'Blog' => url('/blog'),
                //             ])
                //             ->description('Lorem ipsum...')
                //             ->icon('heroicon-m-link')
                //             ->collapsed(true)
                //             ->collapsible(true)
                //             ->paginate(perPage: 5, condition: true)
                //     ])
                //     // ->showCustomLinkPanel(false)
                //     ->showCustomTextPanel()
                //     ->addMenuFields([
                //         Toggle::make('is_logged_in'),
                //     ])
                //     ->addMenuItemFields([
                //         TextInput::make('Visibility'),
                //     ])
                //     ,
            ])
            ;
    }

}
