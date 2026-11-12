<?php

namespace App\Services;

class LocalizedUrlService
{
    /**
     * Map exact path segments between ID and EN.
     * Keys are canonical ID paths without leading/trailing slashes.
     */
    public const EXACT_MAP = [
        // Investor Relations
        'laporan-investor/informasi-finansial' => 'investor-relations/financial-information',
        'laporan-investor/tata-kelola-perusahaan' => 'investor-relations/corporate-governance',
        'laporan-investor/informasi-lainnya' => 'investor-relations/other-information',
        'laporan-investor/kirim-wbs' => 'investor-relations/submit-wbs',
        'laporan-investor/permintaan-dokumen' => 'investor-relations/request-document',
        'laporan-investor' => 'investor-relations',

        // Sitemap
        'peta-situs' => 'sitemap',

        // Static pages
        'kebijakan-privasi' => 'privacy-policy',
        'syarat-ketentuan' => 'terms-conditions',
        'tentang-kami' => 'about-us',
        'karir' => 'career',
        'hubungi-kami' => 'contact-us',
    ];

    /**
     * Map prefix patterns (for routes with wildcards / slugs).
     * Format: 'id_prefix' => 'en_prefix'
     */
    public const PREFIX_MAP = [
        'berita' => 'news',
        'solusi' => 'solutions',
        'karir' => 'career',
        'halaman' => 'page',
    ];

    /**
     * Map canonical ID route names to EN route names.
     * Format: 'id_route_name' => 'en_route_name'
     */
    public const ROUTE_LOCALE_MAP = [
        'frontend.news.id' => 'frontend.news',
        'frontend.detail.id' => 'frontend.detail',
        'frontend.halaman-custom' => 'frontend.halaman-custom.en',
        'frontend.laporan-keuangan' => 'frontend.laporan-keuangan.en',
        'frontend.investor.informasi-finansial' => 'frontend.investor.informasi-finansial.en',
        'frontend.investor.tata-kelola' => 'frontend.investor.tata-kelola.en',
        'frontend.investor.informasi-lainnya' => 'frontend.investor.informasi-lainnya.en',
        'frontend.investor.wbs.store' => 'frontend.investor.wbs.store.en',
        'frontend.investor.permintaan-dokumen.store' => 'frontend.investor.permintaan-dokumen.store.en',
        'frontend.about-us.id' => 'frontend.about-us',
        'frontend.career.id' => 'frontend.career',
        'frontend.career.detail.id' => 'frontend.career.detail',
        'frontend.contact.index.id' => 'frontend.contact.index',
        'halaman-solusi.show' => 'halaman-solusi.show.en',
        'halaman-solusi.sub-show' => 'halaman-solusi.sub-show.en',
        'frontend.sitemap' => 'frontend.sitemap.en',
    ];

    /**
     * Resolve the canonical route name for a given route name and locale.
     */
    public static function routeName(string $routeName, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        if ($locale === 'en') {
            return self::ROUTE_LOCALE_MAP[$routeName] ?? $routeName;
        }
        $reverse = array_flip(self::ROUTE_LOCALE_MAP);
        return $reverse[$routeName] ?? $routeName;
    }

    /**
     * Generate a canonical localized URL for a named route.
     */
    public static function route(string $routeName, array $params = [], ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $resolvedName = self::routeName($routeName, $locale);
        $params['locale'] = $locale;
        if ($resolvedName === 'static-pages.show' && !empty($params['slug'])) {
            $params['slug'] = self::localizeSubPath((string) $params['slug'], $locale);
        }
        return route($resolvedName, $params);
    }

    /**
     * Localize a path (after the locale segment) to the desired target locale.
     */
    public static function localizeSubPath(string $subPath, string $targetLocale): string
    {
        $clean = trim($subPath, '/');
        if ($clean === '') {
            return '';
        }

        if ($targetLocale === 'en') {
            // Check exact map: ID -> EN
            if (isset(self::EXACT_MAP[$clean])) {
                return self::EXACT_MAP[$clean];
            }

            // Check prefix map: ID -> EN (e.g., berita/slug -> news/slug, solusi/id -> solutions/id)
            foreach (self::PREFIX_MAP as $idPre => $enPre) {
                if ($clean === $idPre) {
                    return $enPre;
                }
                if (str_starts_with($clean, $idPre . '/')) {
                    return $enPre . substr($clean, strlen($idPre));
                }
            }
        } elseif ($targetLocale === 'id') {
            // Check reverse exact map: EN -> ID
            $reverseExact = array_flip(self::EXACT_MAP);
            if (isset($reverseExact[$clean])) {
                return $reverseExact[$clean];
            }

            // Check reverse prefix map: EN -> ID (e.g., news/slug -> berita/slug, solutions/id -> solusi/id)
            foreach (self::PREFIX_MAP as $idPre => $enPre) {
                if ($clean === $enPre) {
                    return $idPre;
                }
                if (str_starts_with($clean, $enPre . '/')) {
                    return $idPre . substr($clean, strlen($enPre));
                }
            }
        }

        return $clean;
    }

    /**
     * Switch the locale of a given full request path or URL.
     * e.g., 'id/laporan-investor/informasi-finansial' + 'en' => url('/en/investor-relations/financial-information/')
     */
    public static function switchLocale(string $rawPathOrUrl, string $targetLocale): string
    {
        $path = parse_url($rawPathOrUrl, PHP_URL_PATH) ?? '';
        $path = trim($path, '/');
        $segments = explode('/', $path);

        $currentLocale = 'id';
        if (!empty($segments[0]) && in_array($segments[0], ['id', 'en'], true)) {
            $currentLocale = array_shift($segments);
        }

        $subPath = implode('/', $segments);
        $localizedSubPath = self::localizeSubPath($subPath, $targetLocale);

        $newPath = '/' . $targetLocale;
        if ($localizedSubPath !== '') {
            $newPath .= '/' . $localizedSubPath;
        }

        // Return full URL with trailing slash
        return url(rtrim($newPath, '/') . '/');
    }

    /**
     * Map slug for StaticPageController if requested via English alias
     */
    public static function resolveStaticPageSlug(string $slug): string
    {
        $map = [
            'privacy-policy' => 'kebijakan-privasi',
            'terms-conditions' => 'syarat-ketentuan',
            'about-us' => 'tentang-kami',
        ];

        return $map[$slug] ?? $slug;
    }
}
