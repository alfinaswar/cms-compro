<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Daftar locale yang didukung aplikasi.
     */
    public const SUPPORTED = ['id', 'en'];

    /**
     * Locale default aplikasi (Bahasa Indonesia).
     */
    public const DEFAULT = 'id';

    public function handle(Request $request, Closure $next): Response
    {
        // Ambil segmen pertama dari URL (misal: 'id' atau 'en')
        $locale = $request->segment(1);

        // Cek apakah segmen pertama adalah bahasa yang valid
        if (in_array($locale, self::SUPPORTED, true)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Jika tidak ada di URL, gunakan dari session atau default ke 'id'
            $locale = Session::get('locale', self::DEFAULT);

            // Jaga-jaga bila nilai session tidak valid / sudah usang
            if (!in_array($locale, self::SUPPORTED, true)) {
                $locale = self::DEFAULT;
            }

            App::setLocale($locale);
        }

        // WAJIB di-set setelah locale diketahui, supaya route() yang membutuhkan
        // parameter {locale} menghasilkan URL sesuai bahasa aktif (bukan selalu
        // locale default dari config).
        URL::defaults(['locale' => $locale]);

        // Redirect 301 ke canonical localized URL jika URL non-canonical diakses via GET
        if ($request->isMethod('GET') && !$request->ajax()) {
            $rawPath = trim($request->path(), '/');
            $segments = explode('/', $rawPath);
            if (!empty($segments[0]) && in_array($segments[0], self::SUPPORTED, true)) {
                $urlLocale = array_shift($segments);
                $subPath = implode('/', $segments);
                if ($subPath !== '') {
                    $canonicalSub = \App\Services\LocalizedUrlService::localizeSubPath($subPath, $urlLocale);
                    if ($canonicalSub !== $subPath) {
                        $canonicalUrl = url('/' . $urlLocale . '/' . $canonicalSub . '/');
                        if ($request->getQueryString()) {
                            $canonicalUrl .= '?' . $request->getQueryString();
                        }
                        return redirect($canonicalUrl, 301);
                    }
                }
            }
        }

        return $next($request);
    }
}
