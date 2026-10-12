<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $role = Spatie\Permission\Models\Role::first();
    echo "Found role: " . ($role ? $role->id : 'none') . "\n";
        // Share errors bag as Web middleware does
        view()->share('errors', new \Illuminate\Support\ViewErrorBag);
        $user = \App\Models\User::first();
        if ($user) auth()->login($user);
        $request = Illuminate\Http\Request::create('/admin/manajemen-akun/roles/1/edit', 'GET');
        $response = $app->handle($request);
        echo "Status code for /admin/manajemen-akun/roles/1/edit: " . $response->getStatusCode() . "\n";
        if ($response->getStatusCode() === 500) {
            echo $response->getContent();
        }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . " LINE: " . $e->getLine() . "\n";
    echo $e->getTraceAsString();
}
