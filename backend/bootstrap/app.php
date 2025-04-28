<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: [
            'v1' => __DIR__.'/../routes/api/v1.php',
        ],
    )
    ->withMiddleware(function (Middleware $middleware) {
        return [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            
        ];
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
