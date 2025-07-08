<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectWwwToNonWww
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // Check if the host starts with 'www.'
        if (str_starts_with($host, 'www.')) {
            $nonWwwHost = substr($host, 4);
            $url = $request->getScheme() . '://' . $nonWwwHost . $request->getRequestUri();

            // 301 redirect to the non-www URL
            return redirect($url, 301);
        }

        return $next($request);
    }
}
