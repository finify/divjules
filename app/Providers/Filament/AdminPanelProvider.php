<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Firefly\FilamentBlog\Blog;
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
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugin(Blog::make())
            ->resources([
                \App\Filament\Resources\PostResource::class,
                \App\Filament\Admin\Resources\TeamMemberResource::class,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationItems([
                NavigationItem::make('WhatsApp Button')
                    ->url('/admin/contact-details/whatsapp-settings')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->group('Settings')
                    ->sort(11)
                    ->isActiveWhen(fn () => request()->is('admin/contact-details/whatsapp-settings')),
                NavigationItem::make('Social Media')
                    ->url('/admin/contact-details/social-media-settings')
                    ->icon('heroicon-o-share')
                    ->group('Settings')
                    ->sort(12)
                    ->isActiveWhen(fn () => request()->is('admin/contact-details/social-media-settings')),
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                \App\Filament\Admin\Widgets\ApplicationStatsWidget::class,
                \App\Filament\Admin\Widgets\TestimonialStatsWidget::class,
                \App\Filament\Admin\Widgets\SystemOverviewWidget::class,
                \App\Filament\Admin\Widgets\RecentApplicationsWidget::class,
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
