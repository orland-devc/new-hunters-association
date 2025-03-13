<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Filament\Support\Facades\FilamentView;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;


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
    public function boot()
    {
        FilamentView::registerRenderHook('panels::body.end', fn (): string => Blade::render("@vite('resources/js/app.js')"));
        FilamentIcon::register([
            'home' => 'lucide-home',
            'users' => 'lucide-users',
            'settings' => 'lucide-settings',
            'tasks' => 'lucide-list-checks', // Example for your TaskBoard
        ]);
    }
}
