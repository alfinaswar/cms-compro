<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share data ke semua view
        View::share('websiteSettings', Cache::remember('website_settings', 3600, function () {
            return \App\Models\PengaturanWebsite::first();
        }));

        View::share('keyFigures', Cache::remember('key_figures', 3600, function () {
            return \App\Models\KeyFigures::get();
        }));

        View::share('halamanSolusi', Cache::remember('halaman_solusi', 3600, function () {
            return \App\Models\HalamanSolusi::get();
        }));

        View::share('heroSliders', Cache::remember('hero_sliders', 3600, function () {
            return \App\Models\HeroSlider::get();
        }));
        URL::defaults(['locale' => app()->getLocale()]);
    }

    public function register(): void
    {
        
    }
}
