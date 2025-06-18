<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web.php',
            __DIR__ . '/../routes/user.php',
            __DIR__ . '/../routes/merchant.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest'       => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'merchant.id' => \App\Http\Middleware\IdentifyMerchant::class, #get merchant for each user
        ]);

        $middleware->web([

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            \Illuminate\Http\Request $request
        ) {
            // This is an inline handler, or delegate to your own
            $guard = $e->guards()[0] ?? null;

            $loginRoute = match ($guard) {
                'merchant' => route('merchant.login'),
                'admin'    => route('admin.login'),
                default    => route('users.login'),
            };

            return $request->expectsJson()
            ? response()->json(['message' => 'Unauthenticated'], 401)
            : redirect()->guest($loginRoute);
        });
    })
    ->create();
