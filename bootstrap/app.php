<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Existing roles/permissions middleware
        $middleware->alias([
            'role'              => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'        => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission'=> \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,

            // ✅ Middleware 1: API Key verify karo
            'api.key'           => \App\Http\Middleware\VerifyApiKey::class,

            // ✅ Middleware 2: Request log karo
            'api.log'           => \App\Http\Middleware\LogApiRequest::class,

            // ✅ Middleware 3: SQL injection / XSS block karo
            'api.secure'        => \App\Http\Middleware\PreventMaliciousInput::class,
        ]);

        // Sab API routes pe automatically lagao:
        // - Logging (har request log ho)
        // - Security (har request sanitize ho)
        $middleware->appendToGroup('api', [
            \App\Http\Middleware\LogApiRequest::class,
            \App\Http\Middleware\PreventMaliciousInput::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
