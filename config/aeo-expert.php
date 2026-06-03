<?php

return [

    // llms.txt
    'llms_txt_enabled' => true,
    'llms_txt_content' => '', // Custom content override; empty = auto-generate

    // robots.txt AI bots
    'robots_ai_enabled' => true,
    'robots_ai_bots' => [
        'GPTBot' => 'allow',
        'Google-Extended' => 'allow',
        'ChatGPT-User' => 'allow',
        'ClaudeBot' => 'allow',
        'Claude-Web' => 'allow',
        'PerplexityBot' => 'allow',
        'Bytespider' => 'disallow',
        'CCBot' => 'allow',
        'cohere-ai' => 'allow',
    ],
    'robots_sitemap_enabled' => true,

    // Schema Organization
    'schema_org_enabled' => true,
    'schema_org_name' => '', // Falls back to config('app.name')
    'schema_org_url' => '', // Falls back to config('app.url')
    'schema_org_logo' => '',
    'schema_org_description' => '',
    'schema_org_type' => 'Organization',

    // sameAs
    'sameas_enabled' => true,
    'sameas_urls' => [],

    // ContactPoint
    'contactpoint_enabled' => true,
    'contactpoint_phone' => '',
    'contactpoint_email' => '',
    'contactpoint_type' => 'customer support',
    'contactpoint_address' => [
        'street' => '',
        'city' => '',
        'postal' => '',
        'country' => 'NL',
    ],

    // Meta tags (auto-generated description)
    'meta_tags_enabled' => false,
    'open_graph_enabled' => false,
    'canonical_enabled' => false,

    // HTML lang
    'html_lang_enabled' => true,
    'html_lang_value' => '', // Falls back to config('app.locale')

    // Security headers
    'security_headers_enabled' => false,
    'hsts_enabled' => false,
    'hsts_max_age' => 31536000,

    // FAQ schema (Antlers tag)
    'faq_schema_enabled' => true,

    // .well-known endpoints
    'mcp_enabled' => true,
    'mcp_name' => '',
    'mcp_description' => '',
    'mcp_url' => '',

    'security_txt_enabled' => true,
    'security_txt_contact' => '', // Falls back to admin email
    'security_txt_expires' => '', // Falls back to +1 year

    'agent_skills_enabled' => true,
    'api_catalog_enabled' => true,
    'oauth_as_enabled' => false,
    'oauth_pr_enabled' => false,

    'markdown_variant_enabled' => true,
    'link_headers_enabled' => true,

    // API
    'api_consent' => false,
    'api_url' => 'https://aeo-expert.nl/api/v1/score',

];
