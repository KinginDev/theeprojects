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

            switch ($guard) {
                case 'merchant':
                    if (Auth::guard($guard)->check()) {
                        return redirect(route('merchant.dashboard'));
                    }
                    break;

                case 'web':
                    if (Auth::guard($guard)->check()) {
                        return redirect(route('user.dashboard'));
                    }
                    break;

            }
        }
        return $next($request);
    }
}
