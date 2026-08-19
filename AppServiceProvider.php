<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\NavigationComposer;

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
        // Mengikat NavigationComposer ke semua view.
        // Anda bisa lebih spesifik jika hanya view tertentu yang butuh.
        // Contoh: View::composer(['partials.drawer-links', 'partials.ws-nav-links'], NavigationComposer::class);
        View::composer('*', NavigationComposer::class);
    }
}
