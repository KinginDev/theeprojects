<?php

use App\Models\Merchant;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web.php',
            __DIR__ . '/../routes/merchant.php',
            __DIR__ . '/../routes/users.php',
            __DIR__ . '/../routes/admin.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest'             => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'identify.merchant' => \App\Http\Middleware\IdentifyMerchant::class, #get merchant for each user
        ]);

        $middleware->web([

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            \Illuminate\Http\Request $request
        ) {
            // if ($request->expectsJson()) {
            //     return response()->json(['message' => 'Unauthenticated.'], 401);
            // }

            $guard = $e->guards()[0] ?? null;
            // dd($guard);

            $host     = $request->getHost();
            $slug     = explode('.', $host)[0];
            $merchant = Merchant::where('slug', $slug)->first();

            $login = match ($guard) {
                'merchant' => route('merchant.login'),
                'admin'    => route('admin.login'),
                default    => $merchant
                ? route('users.login', ['slug' => $merchant->slug])
                : route('login'),
            };

            return redirect()->guest($login);
        });
    })
    ->create();
