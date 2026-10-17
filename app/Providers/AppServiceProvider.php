<?php

namespace App\Providers;

use App\Models\HeroSlider;
use App\Models\Berita;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        URL::defaults(['locale' => app()->getLocale()]);

        try {
            // ========================================
            // GLOBAL DATA (View::share - semua view)
            // ========================================
            View::share('websiteSettings', Cache::remember('website_settings', 3600, function () {
                return \App\Models\PengaturanWebsite::first();
            }));

            View::share('keyFigures', Cache::remember('key_figures', 3600, function () {
                return \App\Models\KeyFigures::get();
            }));

            View::share('halamanSolusi', Cache::remember('halaman_solusi', 3600, function () {
                return \App\Models\HalamanSolusi::with('translations')->get();
            }));

            View::share('heroSliders', Cache::remember('hero_sliders', 3600, function () {
                return HeroSlider::where('status', 1)->get();
            }));

            // ========================================
            // VIEW COMPOSER (khusus frontend.index)
            // ========================================
            View::composer('frontend.index', function ($view) {
                try {
                    $popularKeywords = Cache::remember('popular_search_keywords', 3600, function () {
                        // Ambil kategori unik dari berita yang diterbitkan
                        $categories = Berita::where('Status', 'Diterbitkan')
                            ->whereNotNull('Kategori')
                            ->where('Kategori', '!=', '')
                            ->distinct()
                            ->pluck('Kategori')
                            ->take(4)
                            ->toArray();

                        // Ambil tags unik (explode dari koma)
                        $tags = [];
                        $tagsRaw = Berita::where('Status', 'Diterbitkan')
                            ->whereNotNull('Tags')
                            ->where('Tags', '!=', '')
                            ->pluck('Tags')
                            ->take(20)
                            ->toArray();

                        foreach ($tagsRaw as $tagStr) {
                            foreach (explode(',', $tagStr) as $tag) {
                                $tag = trim($tag);
                                if ($tag && strlen($tag) > 1) {
                                    $tags[] = $tag;
                                }
                            }
                        }
                        $tags = array_values(array_unique($tags));
                        $tags = array_slice($tags, 0, 4);

                        // Gabungkan max 8 keyword
                        return array_values(array_unique(array_merge($categories, $tags)));
                    });
                } catch (\Throwable $e) {
                    $popularKeywords = [];
                }

                // Fallback jika kosong atau error
                if (empty($popularKeywords)) {
                    $locale = app()->getLocale();
                    $popularKeywords = $locale === 'en'
                        ? ['Identity', 'Payment', 'Security', 'Passport']
                        : ['Identitas', 'Pembayaran', 'Keamanan', 'Paspor'];
                }

                $view->with('popularKeywords', $popularKeywords);
            });

        } catch (\Throwable $e) {
            // Abaikan error database jika tabel/migrasi belum selesai atau saat cli setup
        }
    }

    public function register(): void
    {
        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();
            $app->instance('routes', $routes);

            $request = $app->has('request') ? $app['request'] : \Illuminate\Http\Request::createFromGlobals();
            $custom = new \App\Routing\CustomUrlGenerator(
                $routes,
                $request,
                $app['config']['app.asset_url']
            );

            $app->rebinding('request', function ($app, $request) use ($custom) {
                $custom->setRequest($request);
            });

            $custom->setSessionResolver(function () use ($app) {
                return $app['session'] ?? null;
            });

            $custom->setKeyResolver(function () use ($app) {
                $config = $app->make('config');
                return [$config->get('app.key'), ...($config->get('app.previous_keys') ?? [])];
            });

            return $custom;
        });
    }
}
