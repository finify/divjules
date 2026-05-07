<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        //
        Schema::defaultStringLength(191);

        // Override dimension validation to accept any image size
        \Illuminate\Support\Facades\Validator::replacer('dimensions', function ($message, $attribute, $rule, $parameters) {
            return $message;
        });

        \Illuminate\Support\Facades\Validator::extendImplicit('dimensions', function ($attribute, $value, $parameters, $validator) {
            // Always pass dimension validation
            return true;
        });

        // Register view composer for contact details
        \Illuminate\Support\Facades\View::composer('*', \App\View\Composers\ContactDetailsComposer::class);

        // Explicitly register the WhatsApp settings Livewire component so it is
        // always available regardless of Filament panel boot order.
        \Livewire\Livewire::component(
            'app.filament.admin.resources.contact-detail-resource.pages.whatsapp-settings',
            \App\Filament\Admin\Resources\ContactDetailResource\Pages\WhatsappSettings::class
        );

        \Livewire\Livewire::component(
            'app.filament.admin.resources.contact-detail-resource.pages.social-media-settings',
            \App\Filament\Admin\Resources\ContactDetailResource\Pages\SocialMediaSettings::class
        );
    }
}
