<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\Helper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequireMerchantDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if we're in a merchant context
        $merchant = Helper::merchant();

        // If no merchant is found, throw a 404 error
        if (!$merchant) {
            throw new NotFoundHttpException('This page can only be accessed through a merchant domain.');
        }

        return $next($request);
    }
}
