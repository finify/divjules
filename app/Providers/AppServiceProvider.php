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
    }
}
