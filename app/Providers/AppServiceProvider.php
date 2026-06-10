<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\PengaturanWebsite;
use Illuminate\Support\ServiceProvider;

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
        View::share('websiteSettings', Cache::remember('website_settings', 3600, function () {
            return PengaturanWebsite::first();
        }));
    }
}
