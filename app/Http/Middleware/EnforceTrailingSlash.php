<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceTrailingSlash
{
    /**
     * Handle an incoming request and enforce trailing slash for GET/HEAD requests.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['GET', 'HEAD'])) {
            $path = $request->getPathInfo();

            // Check if not root, does not end with slash, and does not look like a file asset with extension
            if ($path !== '/' && !str_ends_with($path, '/') && !preg_match('/\.[a-zA-Z0-9]{2,5}$/', $path)) {
                $queryString = $request->getQueryString();
                $target = $path . '/' . ($queryString ? '?' . $queryString : '');

                return redirect($target, 301);
            }
        }

        return $next($request);
    }
}
