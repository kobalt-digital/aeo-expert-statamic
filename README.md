# AEO Expert for Statamic

Boost your Statamic site's AI Engine Optimization (AEO) readiness. This addon auto-generates `llms.txt`, schema.org JSON-LD, AI-friendly `robots.txt` rules, `.well-known` endpoints, security headers, and more -- all configurable from the Control Panel.

## Features

- **llms.txt** -- Auto-generated from your pages and blog collections, served at `/llms.txt` and `/.well-known/llms.txt`
- **Schema.org JSON-LD** -- Organization and FAQPage structured data
- **robots.txt AI bot rules** -- Per-bot allow/disallow for GPTBot, ClaudeBot, PerplexityBot, and others
- **`.well-known` endpoints** -- MCP manifest, security.txt, agent-skills, api-catalog, OAuth metadata
- **Security headers** -- X-Content-Type-Options, X-Frame-Options, Referrer-Policy, HSTS
- **Markdown variant** -- Serves Markdown versions of entries via `?format=md` or `Accept: text/markdown`
- **Link headers** -- HTTP `Link` header pointing to llms.txt and markdown variants
- **Meta tags** -- Auto-generated meta descriptions, Open Graph, and Twitter Card tags
- **FAQ schema** -- JSON-LD + visible HTML from an Antlers tag
- **Control Panel** -- Settings panel with AEO score overview

## Installation

```bash
composer require kobaltdigital/aeo-expert
```

Publish the config file:

```bash
php artisan vendor:publish --tag=aeo-expert-config
```

## Configuration

All features are togglable via `config/aeo-expert.php`. Key options:

| Option | Default | Description |
|--------|---------|-------------|
| `llms_txt_enabled` | `true` | Auto-generate and serve llms.txt |
| `robots_ai_enabled` | `true` | Manage AI bot rules in robots.txt |
| `schema_org_enabled` | `true` | Output Organization JSON-LD |
| `security_headers_enabled` | `false` | Add security response headers |
| `hsts_enabled` | `false` | Add HSTS header |
| `meta_tags_enabled` | `false` | Auto-generate meta description |
| `open_graph_enabled` | `false` | Output Open Graph + Twitter Card tags |
| `markdown_variant_enabled` | `true` | Serve Markdown versions of entries |
| `mcp_enabled` | `true` | Serve `.well-known/mcp` manifest |
| `security_txt_enabled` | `true` | Serve `.well-known/security.txt` |
| `faq_schema_enabled` | `true` | Enable FAQ schema tag |
| `api_consent` | `false` | Allow scoring API calls to aeo-expert.nl |

The settings panel in the Control Panel (`/cp/aeo-expert`) provides a UI for these options.

## Antlers Tags

### Schema.org Organization

```antlers
{{ aeo_schema }}
{{-- or specifically: --}}
{{ aeo_schema:organization }}
```

Outputs Organization JSON-LD based on your config values (name, URL, logo, contact info, sameAs links).

### Meta Description

```antlers
{{ aeo_meta }}
```

Auto-generates a meta description tag from entry content.

### Open Graph / Twitter Cards

```antlers
{{ aeo_og }}
```

Outputs Open Graph and Twitter Card meta tags.

### FAQ Schema

```antlers
{{ aeo_faq :items="faq_items" }}
```

Outputs FAQPage JSON-LD structured data and visible HTML for your FAQ items.

## Endpoints

| URL | Description |
|-----|-------------|
| `/llms.txt` | LLM-friendly site overview |
| `/.well-known/llms.txt` | Same as above (alternate location) |
| `/robots.txt` | Dynamic robots.txt with AI bot rules (only when no physical file exists) |
| `/.well-known/mcp` | MCP manifest |
| `/.well-known/security.txt` | Security contact info |
| `/.well-known/agent-skills` | Agent skills manifest |
| `/.well-known/api-catalog` | API catalog |

Any entry URL with `?format=md` appended returns the Markdown version.

## Requirements

- PHP ^8.1
- Statamic ^4.0 or ^5.0

## License

MIT -- see [LICENSE.md](LICENSE.md).
