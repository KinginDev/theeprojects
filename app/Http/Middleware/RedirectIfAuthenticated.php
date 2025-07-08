<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated as RedirectIfAuthenticatedMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated extends RedirectIfAuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard ?? 'web')->check()) {
                // Get current user and their type
                $user = Auth::guard($guard ?? 'web')->user();

                // Handle merchant users on subdomain
                if ($guard === 'web' && $user->merchant) {
                    return redirect()->route('users.dashboard', [
                        'slug' => $user->merchant->slug
                    ]);
                }

                // Handle merchant admin
                if ($guard === 'merchant') {
                    return redirect()->route('merchant.dashboard');
                }

                // Handle system admin
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        return $next($request);
    }
}
