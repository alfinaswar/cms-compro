<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LowonganKerja;
use App\Models\StaticPage;
use App\Models\CustomPage;
use App\Services\LocalizedUrlService;
use Illuminate\Http\Request;

class SitemapPageController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $today = now()->toDateString();

        $mainPages = [
            [
                'title' => $locale === 'id' ? 'Beranda' : 'Home',
                'url' => LocalizedUrlService::route('frontend.main', [], $locale),
                'icon' => 'fa-home',
            ],
            [
                'title' => $locale === 'id' ? 'Tentang Kami' : 'About Us',
                'url' => LocalizedUrlService::route('frontend.about-us', [], $locale),
                'icon' => 'fa-building',
            ],
            [
                'title' => $locale === 'id' ? 'Berita' : 'News',
                'url' => LocalizedUrlService::route('frontend.news', [], $locale),
                'icon' => 'fa-newspaper',
            ],
            [
                'title' => $locale === 'id' ? 'Karir' : 'Career',
                'url' => LocalizedUrlService::route('frontend.career', [], $locale),
                'icon' => 'fa-briefcase',
            ],
            [
                'title' => $locale === 'id' ? 'Kontak' : 'Contact',
                'url' => LocalizedUrlService::route('frontend.contact.index', [], $locale),
                'icon' => 'fa-envelope',
            ],
        ];

        $berita = Berita::where('Status', 'Diterbitkan')
            ->orderBy('TanggalPublikasi', 'desc')
            ->get()
            ->map(function ($item) use ($locale) {
                $trans = $item->translations->firstWhere('Locale', $locale)
                    ?? $item->translations->firstWhere('Locale', 'id');
                return [
                    'title' => $trans->Judul ?? $item->Judul ?? __('Untitled'),
                    'url' => LocalizedUrlService::route('frontend.detail', ['slug' => $item->Slug], $locale),
                    'date' => $item->TanggalPublikasi ? $item->TanggalPublikasi->format('d M Y') : null,
                ];
            });
        $lowongan = LowonganKerja::where('Status', 'Buka')
            ->where(function ($q) use ($today) {
                $q->whereNull('BatasWaktu')->orWhereDate('BatasWaktu', '>=', $today);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use ($locale) {
                $trans = $item->translations->firstWhere('Locale', $locale)
                    ?? $item->translations->firstWhere('Locale', 'id');
                return [
                    'title' => $trans->Posisi ?? $item->Posisi ?? __('Untitled'),
                    'url' => LocalizedUrlService::route('frontend.career.detail', ['id' => $item->id, 'slug' => $item->slug], $locale),
                    'location' => $item->getKota->name ?? null,
                ];
            });

        $staticPages = StaticPage::where('IsPublished', true)
            ->orderBy('Urutan')
            ->get()
            ->map(function ($page) use ($locale) {
                $trans = $page->translations->firstWhere('Locale', $locale)
                    ?? $page->translations->firstWhere('Locale', 'id');
                return [
                    'title' => $trans->Judul ?? $page->Label,
                    'url' => LocalizedUrlService::route('static-pages.show', ['slug' => $page->Slug], $locale),
                    'icon' => $page->Icon ?? 'fa-file-alt',
                ];
            });

        $customPages = collect();
        if (class_exists(CustomPage::class)) {
            $customPages = CustomPage::where('IsPublished', true)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($page) use ($locale) {
                    $trans = $page->translations->firstWhere('Locale', $locale)
                        ?? $page->translations->firstWhere('Locale', 'id');
                    return [
                        'title' => $trans->Judul ?? __('Untitled'),
                        'url' => LocalizedUrlService::route('frontend.halaman-custom', ['slug' => $page->Slug], $locale),
                    ];
                });
        }

        return view('frontend.sitemap', compact(
            'mainPages',
            'berita',
            'lowongan',
            'staticPages',
            'customPages',
            'locale'
        ));
    }
}
