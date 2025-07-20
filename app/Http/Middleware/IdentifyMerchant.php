<?php
namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IdentifyMerchant {
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function handle(Request $request, Closure $next): Response {
        $host = $request->getHost();

        $appDomain = config('app.domain');
        if($host === $appDomain) {
            // If the host is the main domain, we can skip identifying a merchant
            return $next($request);
        }

        // Check for custom domain
        $merchant = Merchant::where('domain', $host)->first();

        if($merchant == null){
            // If no merchant found by domain, check if it's a subdomain
            $hostParts = explode('.', $host);
            $subdomain = $hostParts[0];

            // Don't process 'www' as a subdomain
            if ($subdomain !== 'www') {
                $merchant = Merchant::where('slug', $subdomain)->first();
            }
        }


        if($merchant->isSubMerchant() && !$merchant->onboarded_at) {
            // If this is a sub-merchant, we can skip identifying a merchant
            return $next($request);
        }

        // If not found by domain, check if it's a subdomain
        if (!$merchant) {
            $hostParts = explode('.', $host);
            $subdomain = $hostParts[0];

            // Don't process 'www' as a subdomain
            if ($subdomain !== 'www') {
                $merchant = Merchant::where('slug', $subdomain)->first();
            }
        }

        if ($merchant) {
            app()->instance('currentMerchant', $merchant);
            View::share('currentMerchant', $merchant);
        }

        return $next($request);
    }
}
