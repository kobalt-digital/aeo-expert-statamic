<?php

namespace KobaltDigital\AeoExpert\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use KobaltDigital\AeoExpert\Generators\MarkdownConverter;
use Statamic\Facades\Entry;

class MarkdownVariant
{
    public function handle(Request $request, Closure $next)
    {
        if (! config('aeo-expert.markdown_variant_enabled')) {
            return $next($request);
        }

        $wantsMarkdown = $request->query('format') === 'md'
            || str_contains($request->header('Accept', ''), 'text/markdown');

        if (! $wantsMarkdown) {
            return $next($request);
        }

        // Skip CP and API routes
        if ($request->is('cp/*', 'api/*', 'llms.txt', '.well-known/*', 'robots.txt')) {
            return $next($request);
        }

        $uri = '/' . ltrim($request->path(), '/');
        $entry = Entry::findByUri($uri);

        if (! $entry) {
            return $next($request);
        }

        $title = $entry->get('title', '');
        $content = $entry->get('content', '');

        // If content contains HTML, convert to markdown
        if ($content && strip_tags($content) !== $content) {
            $content = MarkdownConverter::convert($content);
        }

        $markdown = '# ' . $title . "\n\n" . $content;

        return response($markdown, 200, [
            'Content-Type' => 'text/markdown; charset=utf-8',
            'X-Robots-Tag' => 'noindex',
        ]);
    }
}
