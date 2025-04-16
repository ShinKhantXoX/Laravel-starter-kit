<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function () {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::prefix('dashboard')
            ->group(base_path('routes/dashboard.php'));

        // Route::middleware('commands')
        //     ->group(base_path('routes/console.php'));

        // Route::get('/up', function () {
        //     return response()->json(['status' => 'up']);
        // });
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
