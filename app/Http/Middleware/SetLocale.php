<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil segmen pertama dari URL (misal: 'id' atau 'en')
        $locale = $request->segment(1);

        // Cek apakah segmen pertama adalah bahasa yang valid
        if (in_array($locale, ['id', 'en'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Jika tidak ada di URL, gunakan dari session atau default ke 'id'
            $defaultLocale = Session::get('locale', 'id');
            App::setLocale($defaultLocale);
        }

        return $next($request);
    }
}
