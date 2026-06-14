<?php

namespace App\Providers;

use App\Models\HalamanSolusi;
use App\Models\HeroSlider;
use App\Models\KeyFigures;
use App\Models\PengaturanWebsite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
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

        View::share('keyFigures', Cache::remember('key_figures', 3600, function () {
            return KeyFigures::get();
        }));
        View::share('halamanSolusi', Cache::remember('halaman_solusi', 3600, function () {
            return HalamanSolusi::get();
        }));
        View::share('heroSliders', Cache::remember('hero_sliders', 3600, function () {
            return HeroSlider::get();
        }));
    }
}
