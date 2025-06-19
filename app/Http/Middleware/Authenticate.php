<?php
namespace App\Http\Middleware;

use App\Models\Merchant;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Illuminate\Http\Request;

class Authenticate extends BaseAuthenticate
{
    /**
     * Determine the path to redirect to when the user is not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null; // Let Laravel return JSON 401
        }

        $host     = $request->getHost();
        $merchant = Merchant::where('domain', $host)
            ->orWhere('slug', explode('.', $host)[0]) // assumes subdomain slug
            ->first();
        $path = $request->path();
        if (! $merchant && str_contains($path, 'admin')) {
            return route('admin.login');
        } else if (! $merchant && str_contains($path, 'merchant')) {
            return route('merchant.login');
        } else {
            return route('login', ['slug' => $merchant?->slug]);
        }
    }

}
