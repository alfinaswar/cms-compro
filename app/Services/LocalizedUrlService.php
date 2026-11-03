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
    ];

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
