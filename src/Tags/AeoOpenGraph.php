<?php

namespace KobaltDigital\AeoExpert\Tags;

use Illuminate\Support\Str;
use Statamic\Tags\Tags;

class AeoOpenGraph extends Tags
{
    protected static $handle = 'aeo_og';

    /**
     * {{ aeo_og }}
     *
     * Outputs Open Graph and Twitter Card meta tags.
     */
    public function index(): string
    {
        if (! config('aeo-expert.open_graph_enabled')) {
            return '';
        }

        $context = $this->context;
        $title = $context->get('title', config('app.name'));
        $url = $context->get('permalink', $context->get('url', url('/')));
        $siteName = config('app.name');

        // Description
        $content = $context->get('content', '');
        $desc = config('aeo-expert.schema_org_description', '');
        if ($content) {
            $desc = Str::words(strip_tags((string) $content), 30, '...');
        }

        $output = '';
        $output .= '<meta property="og:title" content="' . e($title) . '" />' . "\n";
        $output .= '<meta property="og:type" content="website" />' . "\n";
        $output .= '<meta property="og:url" content="' . e($url) . '" />' . "\n";
        if ($desc) {
            $output .= '<meta property="og:description" content="' . e($desc) . '" />' . "\n";
        }
        $output .= '<meta property="og:site_name" content="' . e($siteName) . '" />' . "\n";

        // Featured image
        $image = $context->get('image');
        if ($image) {
            $imageUrl = is_string($image) ? $image : (string) $image;
            if ($imageUrl) {
                $output .= '<meta property="og:image" content="' . e($imageUrl) . '" />' . "\n";
            }
        }

        // Twitter Card
        $output .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";
        $output .= '<meta name="twitter:title" content="' . e($title) . '" />' . "\n";
        if ($desc) {
            $output .= '<meta name="twitter:description" content="' . e($desc) . '" />' . "\n";
        }

        return $output;
    }
}
