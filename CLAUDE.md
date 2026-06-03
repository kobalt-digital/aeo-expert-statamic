# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Statamic addon (`kobaltdigital/aeo-expert`) that improves AI Engine Optimization (AEO) readiness for Statamic sites. It auto-generates llms.txt, schema.org JSON-LD, robots.txt AI-bot rules, `.well-known` endpoints, security headers, and more.

- **Package**: `kobaltdigital/aeo-expert` — installed as a Composer dependency in a Statamic v4/v5 site
- **Namespace**: `KobaltDigital\AeoExpert\`
- **PHP**: ^8.1
- **Framework**: Statamic CMS (Laravel-based), extends `AddonServiceProvider`

## Development

This is a Statamic addon, not a standalone app. To develop:

1. Symlink or path-require this package into a Statamic site's `composer.json`
2. Run the host site with `php artisan serve` or Valet/Herd
3. All config lives in `config/aeo-expert.php` — publish with `php artisan vendor:publish --tag=aeo-expert-config`
4. CP settings panel at `/cp/aeo-expert`

No tests, build step, or linter configured yet.

## Architecture

### ServiceProvider (`src/ServiceProvider.php`)
Extends Statamic's `AddonServiceProvider`. Registers tags, routes (web + cp), and middleware. Config is merged from `config/aeo-expert.php`. All features are togglable via config booleans.

### Generators (`src/Generators/`)
Static generator classes, no dependencies injected:
- **LlmsTxtGenerator** — builds llms.txt from Statamic `pages` and `blog`/`articles` collections
- **SchemaGenerator** — builds Organization and FAQPage schema.org arrays
- **McpManifestGenerator** — `.well-known/mcp` JSON manifest
- **SecurityTxtGenerator** — `.well-known/security.txt`
- **MarkdownConverter** — HTML-to-Markdown conversion for the `?format=md` variant

### Controllers (`src/Http/Controllers/`)
- **LlmsTxtController** — serves `/llms.txt` and `/.well-known/llms.txt`
- **RobotsTxtController** — dynamic `robots.txt` with AI bot rules (only if no physical file exists)
- **WellKnownController** — serves MCP manifest, security.txt, agent-skills, api-catalog, OAuth metadata
- **CpController** — Statamic CP settings panel + score fetch + llms.txt preview

### Antlers Tags (`src/Tags/`)
Used in Statamic templates:
- `{{ aeo_schema }}` / `{{ aeo_schema:organization }}` — Organization JSON-LD
- `{{ aeo_meta }}` — auto-generated meta description
- `{{ aeo_og }}` — Open Graph + Twitter Card meta tags
- `{{ aeo_faq :items="faq_items" }}` — FAQ schema JSON-LD + visible HTML

### Middleware (`src/Http/Middleware/`)
All registered on the `web` group, each gated by config:
- **MarkdownVariant** — serves Markdown version of entries on `?format=md` or `Accept: text/markdown`
- **SecurityHeaders** — X-Content-Type-Options, X-Frame-Options, Referrer-Policy
- **HstsHeader** — Strict-Transport-Security
- **LinkHeaders** — HTTP `Link` header pointing to llms.txt and markdown variant

### API (`src/Api/`)
- **ApiClient** — calls external `aeo-expert.nl` scoring API (requires `api_consent` config)
- **ScoreFetcher** — wraps ApiClient for CP controller use

## Key Patterns

- Every feature is gated by a `config('aeo-expert.feature_enabled')` boolean — check this pattern when adding new features
- Generators are static classes with a `generate()` or named static method
- Config values fallback to `config('app.name')`, `config('app.url')`, etc. when addon-specific values are empty
- Routes are split: `routes/web.php` for public endpoints, `routes/cp.php` for CP panel
- Views are in `resources/views/` and namespaced as `aeo-expert::`
