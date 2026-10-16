<?php

namespace App\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Routing\UrlGenerator;

class CustomUrlGenerator extends UrlGenerator
{
    /**
     * Create a new URL Generator instance.
     *
     * @param  \Illuminate\Routing\RouteCollectionInterface  $routes
     * @param  \Illuminate\Http\Request|null  $request
     * @param  string|null  $assetRoot
     */
    public function __construct(RouteCollectionInterface $routes, ?Request $request = null, $assetRoot = null)
    {
        $request = $request ?? Request::createFromGlobals();
        parent::__construct($routes, $request, $assetRoot);
    }

    /**
     * Format the given URL segments into a single URL with trailing slash.
     *
     * @param  string  $root
     * @param  string  $path
     * @param  \Illuminate\Routing\Route|null  $route
     * @return string
     */
    public function format($root, $path, $route = null)
    {
        $formatted = parent::format($root, $path, $route);

        $fragment = '';
        if (str_contains($formatted, '#')) {
            [$formatted, $fragment] = explode('#', $formatted, 2);
            $fragment = '#' . $fragment;
        }

        // Only append slash if there is no file extension (e.g. .css, .js, .png)
        if (!preg_match('/\.[a-zA-Z0-9]{2,5}$/', $formatted)) {
            $formatted = rtrim($formatted, '/') . '/';
        }

        return $formatted . $fragment;
    }
}
