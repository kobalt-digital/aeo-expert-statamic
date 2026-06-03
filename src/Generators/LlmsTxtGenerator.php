<?php

namespace KobaltDigital\AeoExpert\Generators;

use Statamic\Facades\Entry;
use Statamic\Facades\Site;

class LlmsTxtGenerator
{
    public static function generate(): string
    {
        $lines = [];
        $siteName = config('aeo-expert.schema_org_name') ?: config('app.name');
        $lines[] = '# ' . $siteName;
        $lines[] = '';

        $description = config('aeo-expert.schema_org_description');
        if ($description) {
            $lines[] = '> ' . $description;
            $lines[] = '';
        }

        // Pages collection
        $pages = Entry::query()
            ->where('collection', 'pages')
            ->where('status', 'published')
            ->limit(20)
            ->get();

        if ($pages->isNotEmpty()) {
            $lines[] = '## Pages';
            $lines[] = '';
            foreach ($pages as $entry) {
                $lines[] = '- [' . $entry->get('title') . '](' . $entry->absoluteUrl() . ')';
            }
            $lines[] = '';
        }

        // Blog/articles collection
        $posts = Entry::query()
            ->where('collection', 'blog')
            ->where('status', 'published')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Fallback: try 'articles' collection if 'blog' is empty
        if ($posts->isEmpty()) {
            $posts = Entry::query()
                ->where('collection', 'articles')
                ->where('status', 'published')
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get();
        }

        if ($posts->isNotEmpty()) {
            $lines[] = '## Blog Posts';
            $lines[] = '';
            foreach ($posts as $entry) {
                $lines[] = '- [' . $entry->get('title') . '](' . $entry->absoluteUrl() . ')';
            }
            $lines[] = '';
        }

        return implode("\n", $lines);
    }
}
