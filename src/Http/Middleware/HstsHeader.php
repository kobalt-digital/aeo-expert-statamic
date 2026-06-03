<?php

namespace KobaltDigital\AeoExpert\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HstsHeader
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! config('aeo-expert.hsts_enabled')) {
            return $response;
        }

        if (! $request->isSecure()) {
            return $response;
        }

        $maxAge = (int) config('aeo-expert.hsts_max_age', 31536000);
        $response->headers->set('Strict-Transport-Security', 'max-age=' . $maxAge);

        return $response;
    }
}
