<?php

/**
 * Example Panel Provider showing basic usage of Filament Navigation Search
 */

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use HkDevs\FilamentNavigationSearch\FilamentNavigationSearchPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ExampleAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
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
            ->navigationItems([
                // Dashboard
                NavigationItem::make('Dashboard')
                    ->url('/admin')
                    ->icon('heroicon-o-home')
                    ->isActiveWhen(fn() => request()->is('admin')),
            ])
            ->navigationGroups([
                // Content Management
                NavigationGroup::make('Content')
                    ->items([
                        NavigationItem::make('Posts')
                            ->url('/admin/posts')
                            ->icon('heroicon-o-document-text')
                            ->badge('12'),
                        NavigationItem::make('Pages')
                            ->url('/admin/pages')
                            ->icon('heroicon-o-document'),
                        NavigationItem::make('Categories')
                            ->url('/admin/categories')
                            ->icon('heroicon-o-tag'),
                        NavigationItem::make('Media Library')
                            ->url('/admin/media')
                            ->icon('heroicon-o-photo'),
                    ]),

                // E-commerce
                NavigationGroup::make('E-commerce')
                    ->items([
                        NavigationItem::make('Products')
                            ->url('/admin/products')
                            ->icon('heroicon-o-cube')
                            ->badge('156'),
                        NavigationItem::make('Orders')
                            ->url('/admin/orders')
                            ->icon('heroicon-o-shopping-cart')
                            ->badge('23', 'danger'),
                        NavigationItem::make('Customers')
                            ->url('/admin/customers')
                            ->icon('heroicon-o-users'),
                        NavigationItem::make('Coupons')
                            ->url('/admin/coupons')
                            ->icon('heroicon-o-ticket'),
                        NavigationItem::make('Reviews')
                            ->url('/admin/reviews')
                            ->icon('heroicon-o-star'),
                    ]),

                // User Management
                NavigationGroup::make('Users')
                    ->items([
                        NavigationItem::make('All Users')
                            ->url('/admin/users')
                            ->icon('heroicon-o-user-group'),
                        NavigationItem::make('Roles & Permissions')
                            ->url('/admin/roles')
                            ->icon('heroicon-o-shield-check'),
                        NavigationItem::make('Teams')
                            ->url('/admin/teams')
                            ->icon('heroicon-o-user-group'),
                    ]),

                // Analytics & Reports
                NavigationGroup::make('Analytics')
                    ->items([
                        NavigationItem::make('Dashboard')
                            ->url('/admin/analytics')
                            ->icon('heroicon-o-chart-bar'),
                        NavigationItem::make('Sales Reports')
                            ->url('/admin/reports/sales')
                            ->icon('heroicon-o-currency-dollar'),
                        NavigationItem::make('User Analytics')
                            ->url('/admin/reports/users')
                            ->icon('heroicon-o-users'),
                        NavigationItem::make('Traffic Sources')
                            ->url('/admin/reports/traffic')
                            ->icon('heroicon-o-globe-alt'),
                    ]),

                // Settings
                NavigationGroup::make('Settings')
                    ->items([
                        NavigationItem::make('General Settings')
                            ->url('/admin/settings')
                            ->icon('heroicon-o-cog-6-tooth'),
                        NavigationItem::make('Email Templates')
                            ->url('/admin/settings/email')
                            ->icon('heroicon-o-envelope'),
                        NavigationItem::make('Payment Methods')
                            ->url('/admin/settings/payments')
                            ->icon('heroicon-o-credit-card'),
                        NavigationItem::make('Shipping')
                            ->url('/admin/settings/shipping')
                            ->icon('heroicon-o-truck'),
                        NavigationItem::make('Tax Configuration')
                            ->url('/admin/settings/tax')
                            ->icon('heroicon-o-calculator'),
                        NavigationItem::make('Backup & Restore')
                            ->url('/admin/settings/backup')
                            ->icon('heroicon-o-archive-box'),
                    ]),

                // Tools & Utilities
                NavigationGroup::make('Tools')
                    ->items([
                        NavigationItem::make('File Manager')
                            ->url('/admin/files')
                            ->icon('heroicon-o-folder'),
                        NavigationItem::make('Database Backup')
                            ->url('/admin/tools/backup')
                            ->icon('heroicon-o-server-stack'),
                        NavigationItem::make('Cache Management')
                            ->url('/admin/tools/cache')
                            ->icon('heroicon-o-lightning-bolt'),
                        NavigationItem::make('System Logs')
                            ->url('/admin/tools/logs')
                            ->icon('heroicon-o-document-text'),
                        NavigationItem::make('API Documentation')
                            ->url('/admin/tools/api-docs')
                            ->icon('heroicon-o-code-bracket'),
                    ]),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
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
                // Basic Usage
                FilamentNavigationSearchPlugin::make(),

                // Advanced Configuration (commented out - choose one)
                /*
                FilamentNavigationSearchPlugin::make()
                    ->placeholder('Search admin features...')
                    ->position('top')
                    ->showResultsCount(true)
                    ->searchDelay(300)
                    ->minSearchLength(2)
                    ->highlightMatches(true)
                    ->enabled(fn () => auth()->user()?->hasRole('admin')),
                */
            ]);
    }
}
