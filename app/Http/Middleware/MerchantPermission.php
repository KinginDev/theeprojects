<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MerchantPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if(!Auth::guard('merchant')->check()) {
            return redirect()->route('merchant.login')
                ->with('error', 'You must be logged in to access this page.');
        }

        $merchant = Auth::guard('merchant')->user();

        // Owner has all permissions
        if ($merchant->roles()->where('slug', 'admin')->exists()) {
            return $next($request);
        }

        // Check permission for sub-merchants
        if (!$merchant->hasPermission($permission)) {
            return redirect()->route('merchant.dashboard')
                ->with('error', 'You do not have permission to access this resource.');
        }
        return $next($request);
    }
}
