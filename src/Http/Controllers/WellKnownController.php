<?php

namespace KobaltDigital\AeoExpert\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use KobaltDigital\AeoExpert\Generators\McpManifestGenerator;
use KobaltDigital\AeoExpert\Generators\SecurityTxtGenerator;

class WellKnownController
{
    public function mcp(): JsonResponse
    {
        if (! config('aeo-expert.mcp_enabled')) {
            abort(404);
        }

        $manifest = McpManifestGenerator::generate();

        return response()->json($manifest, 200, [
            'Access-Control-Allow-Origin' => '*',
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function securityTxt(): Response
    {
        if (! config('aeo-expert.security_txt_enabled')) {
            abort(404);
        }

        return response(SecurityTxtGenerator::generate(), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    public function agentSkills(): JsonResponse
    {
        if (! config('aeo-expert.agent_skills_enabled')) {
            abort(404);
        }

        $skills = [
            'schema_version' => '1.0',
            'skills' => [
                [
                    'id' => 'website-content',
                    'name' => 'Website Content',
                    'description' => 'Access structured content from ' . config('app.name'),
                    'endpoints' => [
                        [
                            'url' => url('/llms.txt'),
                            'method' => 'GET',
                            'mimeType' => 'text/plain',
                        ],
                    ],
                ],
            ],
        ];

        // Add Content API if enabled
        if (config('statamic.api.enabled')) {
            $skills['skills'][] = [
                'id' => 'api-access',
                'name' => 'Content API',
                'description' => 'Statamic Content API for structured data',
                'endpoints' => [
                    [
                        'url' => url('/api'),
                        'method' => 'GET',
                        'mimeType' => 'application/json',
                    ],
                ],
            ];
        }

        return response()->json($skills, 200, [
            'Access-Control-Allow-Origin' => '*',
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function apiCatalog(): JsonResponse
    {
        if (! config('aeo-expert.api_catalog_enabled')) {
            abort(404);
        }

        $catalog = [
            'schema_version' => '1.0',
            'apis' => [],
        ];

        if (config('statamic.api.enabled')) {
            $catalog['apis'][] = [
                'name' => config('app.name') . ' Content API',
                'description' => 'Statamic Content API',
                'url' => url('/api'),
                'type' => 'REST',
                'version' => 'v1',
                'documentation' => 'https://statamic.dev/rest-api',
            ];
        }

        return response()->json($catalog, 200, [
            'Access-Control-Allow-Origin' => '*',
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function oauthAuthorizationServer(): JsonResponse
    {
        if (! config('aeo-expert.oauth_as_enabled')) {
            abort(404);
        }

        $metadata = [
            'issuer' => url('/'),
            'authorization_endpoint' => url('/oauth/authorize'),
            'token_endpoint' => url('/oauth/token'),
            'response_types_supported' => ['code'],
            'grant_types_supported' => ['authorization_code'],
            'code_challenge_methods_supported' => ['S256'],
        ];

        return response()->json($metadata, 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function oauthProtectedResource(): JsonResponse
    {
        if (! config('aeo-expert.oauth_pr_enabled')) {
            abort(404);
        }

        $metadata = [
            'resource' => url('/'),
            'authorization_servers' => [url('/')],
            'bearer_methods_supported' => ['header'],
        ];

        return response()->json($metadata, 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
