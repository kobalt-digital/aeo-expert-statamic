<?php

namespace KobaltDigital\AeoExpert\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LinkHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! config('aeo-expert.link_headers_enabled')) {
            return $response;
        }

        $links = [];

        // llms.txt
        if (config('aeo-expert.llms_txt_enabled')) {
            $links[] = '<' . url('/llms.txt') . '>; rel="llms-txt"; type="text/plain"';
        }

        // Markdown variant for current page
        if (config('aeo-expert.markdown_variant_enabled') && ! $request->is('api/*', 'cp/*')) {
            $mdUrl = $request->fullUrlWithQuery(['format' => 'md']);
            $links[] = '<' . $mdUrl . '>; rel="alternate"; type="text/markdown"';
        }

        if (! empty($links)) {
            $existing = $response->headers->get('Link', '');
            $linkValue = ($existing ? $existing . ', ' : '') . implode(', ', $links);
            $response->headers->set('Link', $linkValue);
        }

        return $response;
    }
}
