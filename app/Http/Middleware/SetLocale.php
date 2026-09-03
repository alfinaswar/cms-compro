<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek parameter URL (?lang=id atau ?lang=en)
        if ($request->has('lang') && in_array($request->get('lang'), ['id', 'en'])) {
            Session::put('locale', $request->get('lang'));
        }

        // Set locale dari session, default ke 'id'
        $locale = Session::get('locale', 'id');
        App::setLocale($locale);

        return $next($request);
    }
}
