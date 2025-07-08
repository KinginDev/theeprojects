<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle($request, Closure $next, $redirectToRoute = null)
    {
        // Handle JSON requests
        if ($request->expectsJson()) {
            return abort(403, 'Your email address is not verified.');
        }

        $user = $request->user();
        if (!$user || ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail())) {
            $path = $request->path();
            $host = $request->getHost();
            $hostParts = explode('.', $host);
            $isSubdomain = count($hostParts) > 2 || (count($hostParts) === 2 && !str_contains($host, 'www'));

            // If redirectToRoute is provided, use it
            if ($redirectToRoute) {
                return Redirect::guest(URL::route($redirectToRoute));
            }

            // Handle subdomains for merchant users
            if ($isSubdomain) {
                $subdomain = $hostParts[0];
                $merchant = Merchant::where('domain', $host)
                    ->orWhere('slug', $subdomain)
                    ->first();

                if ($merchant) {
                    return Redirect::guest(URL::route('users.verification.notice', ['slug' => $merchant->slug]));
                }
            }

            // Check current guard and route type
            $currentGuard = Auth::guard()->getName();

            $verificationRoute = match(true) {
                str_starts_with($path, 'merchant') || $currentGuard === 'merchant' => 'merchant.verification.notice',
                str_starts_with($path, 'admin') || $currentGuard === 'admin' => 'admin.verification.notice',
                default => 'users.verification.notice'
            };

            return Redirect::guest(URL::route($verificationRoute));
        }

        return $next($request);
    }
}
