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
            return null;
        }

        $path = $request->path();

        // Get the current guard from the auth configuration
        $guards = empty($guards) ? [null] : $guards;
        $adminRouteName = 'admin/';

        // If we're accessing an admin route, always redirect to admin login
        if (str_starts_with($path,$adminRouteName)) {

            return route('admin.login');
        }

        // Check if we're accessing a merchant subdomain
        $host = $request->getHost();
        $hostParts = explode('.', $host);
        $isSubdomain = count($hostParts) > 2 || (count($hostParts) === 2 && !str_contains($host, 'www'));

        if ($isSubdomain) {
            $subdomain = $hostParts[0];
            $merchant = Merchant::where('domain', $host)
                ->orWhere('slug', $subdomain)
                ->first();

            if (!$merchant) {
                return route('merchant.login');
            }

            // If on subdomain, return to user login
            return route('users.login', ['slug' => $merchant->slug]);
        }

        // If it's a merchant route
        if (str_starts_with($request->path(), 'merchant')) {
            return route('merchant.login');
        }

        // Default to merchant login for any other route
        return route('merchant.login');
    }

}
