<?php

namespace KobaltDigital\AeoExpert\Generators;

class McpManifestGenerator
{
    public static function generate(): array
    {
        $name = config('aeo-expert.mcp_name') ?: config('app.name');
        $description = config('aeo-expert.mcp_description') ?: config('aeo-expert.schema_org_description', '');
        $mcpUrl = config('aeo-expert.mcp_url') ?: config('app.url');

        $manifest = [
            'schema_version' => '1.0',
            'name' => $name,
            'description' => $description,
            'url' => $mcpUrl,
            'provider' => [
                'name' => config('app.name'),
                'url' => config('app.url'),
            ],
            'capabilities' => [
                'resources' => true,
            ],
            'resources' => [
                [
                    'name' => 'Website Content',
                    'description' => 'Main website content and pages',
                    'uri' => url('/llms.txt'),
                    'mimeType' => 'text/plain',
                ],
            ],
        ];

        // Add Statamic API as a resource if enabled
        if (config('statamic.api.enabled')) {
            $manifest['resources'][] = [
                'name' => 'Content API',
                'description' => 'Statamic Content API',
                'uri' => url('/api'),
                'mimeType' => 'application/json',
            ];
        }

        return $manifest;
    }
}
