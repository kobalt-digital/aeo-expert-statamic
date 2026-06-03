<?php

namespace KobaltDigital\AeoExpert\Tags;

use KobaltDigital\AeoExpert\Generators\SchemaGenerator;
use Statamic\Tags\Tags;

class AeoSchema extends Tags
{
    protected static $handle = 'aeo_schema';

    /**
     * {{ aeo_schema:organization }}
     *
     * Outputs Organization schema.org JSON-LD on the page.
     */
    public function organization(): string
    {
        if (! config('aeo-expert.schema_org_enabled')) {
            return '';
        }

        $schema = SchemaGenerator::organization();

        if (empty($schema['name'])) {
            return '';
        }

        return '<script type="application/ld+json">' . "\n"
            . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            . "\n" . '</script>' . "\n";
    }

    /**
     * {{ aeo_schema }}
     *
     * Default: outputs Organization schema.
     */
    public function index(): string
    {
        return $this->organization();
    }
}
