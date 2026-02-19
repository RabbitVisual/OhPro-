<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->group(base_path('routes/teacher.php'));
            Route::middleware('web')->group(base_path('routes/admin.php'));
            Route::middleware('web')->group(base_path('routes/support.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'pro' => \App\Http\Middleware\EnsureUserIsPro::class,
        ]);
        $middleware->redirectUsersTo(fn () => route('dashboard'));
        $middleware->validateCsrfTokens(except: [
            'webhooks/stripe',
            'webhooks/mercadopago',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => __('Não tem permissão para aceder a esta área.')], 403);
            }

            return $request->user()
                ? redirect()->route('dashboard')->with('error', __('Não tem permissão para aceder a esta área.'))
                : redirect()->guest(route('login'));
        });
    })->create();
