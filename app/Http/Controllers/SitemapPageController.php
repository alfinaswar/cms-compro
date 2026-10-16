<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\LowonganKerja;
use App\Models\StaticPage;
use App\Models\CustomPage;
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
                'url' => url('/'),
                'icon' => 'fa-home',
            ],
            [
                'title' => $locale === 'id' ? 'Tentang Kami' : 'About Us',
                'url' => url($locale . '/tentang-kami'),
                'icon' => 'fa-building',
            ],
            [
                'title' => $locale === 'id' ? 'Berita' : 'News',
                'url' => url($locale . '/berita'),
                'icon' => 'fa-newspaper',
            ],
            [
                'title' => $locale === 'id' ? 'Karir' : 'Career',
                'url' => url($locale . '/karir'),
                'icon' => 'fa-briefcase',
            ],
            [
                'title' => $locale === 'id' ? 'Kontak' : 'Contact',
                'url' => url($locale . '/kontak'),
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
                    'title' => $trans->Judul ?? $item->Judul ?? 'Tanpa Judul',
                    'url' => url($locale . '/berita/' . $item->Slug),
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
                    'title' => $trans->Judul ?? $item->Posisi ?? 'Tanpa Judul',
                    'url' => url($locale . '/karir/' . $item->Slug),
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
                    'url' => url($locale . '/' . $page->Slug),
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
                        'title' => $trans->Judul ?? 'Tanpa Judul',
                        'url' => url($locale . '/page/' . $page->Slug),
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
