<?php

namespace KobaltDigital\AeoExpert\Tags;

use Statamic\Tags\Tags;

class AeoMetaTags extends Tags
{
    protected static $handle = 'aeo_meta';

    /**
     * {{ aeo_meta }}
     *
     * Outputs meta description tag based on current entry content.
     */
    public function index(): string
    {
        if (! config('aeo-expert.meta_tags_enabled')) {
            return '';
        }

        $description = $this->getDescription();

        if (empty($description)) {
            return '';
        }

        return '<meta name="description" content="' . e($description) . '" />' . "\n";
    }

    protected function getDescription(): string
    {
        $context = $this->context;

        // Try entry content
        $content = $context->get('content', '');
        if ($content) {
            $stripped = strip_tags((string) $content);

            return \Illuminate\Support\Str::words($stripped, 30, '...');
        }

        // Fallback to site description
        return config('aeo-expert.schema_org_description', '');
    }
}
