<?php

namespace App\Providers;

use App\View\Composers\MetaLayoutComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['components.layouts.landing.landing'], MetaLayoutComposer::class);
    }
}
