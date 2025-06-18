<?php
namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IdentifyMerchant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        //Get merchant by the host
        $merchant = Merchant::where('domain', $host)
            ->orWhere('slug', explode('.', $host)[0]) // assumes subdomain slug
            ->first();

        if (! $merchant) {
            abort(404, 'Merchant not found');
        }

        // Share tenant globally (can also use a singleton or container binding)
        app()->instance('currentMerchant', $merchant);

        // Optionally share with views
        View::share('currentMerchant', $merchant);

        return $next($request);
    }
}
