<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Tetap pertahankan alias untuk Spatie Permission
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        // 2. EnforceTrailingSlash di-prepend (tidak butuh session).
        //    SetLocale di-append supaya berjalan SETELAH StartSession, sehingga
        //    Session::get()/put() aman. Semua middleware grup 'web' tetap jalan
        //    sebelum controller, jadi locale & URL::defaults sudah benar saat
        //    view merender __('...') dan route().
        $middleware->web(
            prepend: [
                \App\Http\Middleware\EnforceTrailingSlash::class,
            ],
            append: [
                \App\Http\Middleware\SetLocale::class,
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
