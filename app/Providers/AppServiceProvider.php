<?php

namespace App\Providers;

use App\View\Composers\NavigationComposer;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                $settings = Setting::query()->pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                $settings = [];
            }

            $view->with('siteSettings', $settings);
        });

        // Daftarkan NavigationComposer agar variabel $mainMenu tersedia di semua view
        View::composer('*', NavigationComposer::class);
    }
}
