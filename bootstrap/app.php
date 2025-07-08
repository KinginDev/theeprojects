<?php

use App\Classes\Helper;
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
            'auth'              => \App\Http\Middleware\Authenticate::class,
            'verified'         => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'redirect.www'     => \App\Http\Middleware\RedirectWwwToNonWww::class,
            'require.merchant' => \App\Http\Middleware\RequireMerchantDomain::class,
        ]);

        // Apply www redirect middleware first, then identify.merchant middleware
        $middleware->web([
            \App\Http\Middleware\RedirectWwwToNonWww::class,
            \App\Http\Middleware\IdentifyMerchant::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            $guard = $e->guards()[0] ?? null;

            // Get host information
            $host = $request->getHost();
            $hostParts = explode('.', $host);
            $isSubdomain = count($hostParts) > 2 || (count($hostParts) === 2 && !str_contains($host, 'www'));

            // For subdomains, handle user authentication
            if ($isSubdomain && $guard === 'web') {
                $subdomain = $hostParts[0];
                $merchant = Merchant::where('domain', $host)
                    ->orWhere('slug', $subdomain)
                    ->first();

                if ($merchant) {
                    return redirect()->guest(route('users.login', ['slug' => $merchant->slug]));
                }
            }

            $login = match ($guard) {
                'merchant' => route('merchant.login'),
                'admin' => route('admin.login'),
                'web' => route('merchant.login'), // Default to merchant login if no subdomain match
                default => route('merchant.login'),
            };

            return redirect()->guest($login);
        });
    })
    ->create();
