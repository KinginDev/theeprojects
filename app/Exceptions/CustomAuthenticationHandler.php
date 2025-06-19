<?php
namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Throwable;

class CustomAuthenticationHandler
{
    protected function handle(Request $request, Throwable $e): Response
    {
        // Sanity check for expected exception type
        if (! $e instanceof AuthenticationException) {
            throw $e;
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $guard = $e->guards()[0] ?? null;
        dd($guard);

        $host     = $request->getHost();
        $slug     = explode('.', $host)[0];
        $merchant = \App\Models\Merchant::where('slug', $slug)->first();

        $login = match ($guard) {
            'merchant' => route('merchant.login'),
            'admin' => route('admin.login'),
            default => $merchant
            ? route('users.login', ['slug' => $merchant->slug])
            : route('login'),
        };

        return redirect()->guest($login);
    }
}
