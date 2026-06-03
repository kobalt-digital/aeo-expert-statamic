# Changelog

All notable changes to AEO Expert will be documented in this file.

## v1.0.0 (2025-06-03)

### Added

- Auto-generated `llms.txt` from pages and blog/articles collections
- Schema.org Organization JSON-LD via `{{ aeo_schema }}` tag
- FAQ schema JSON-LD + HTML via `{{ aeo_faq }}` tag
- Auto-generated meta description via `{{ aeo_meta }}` tag
- Open Graph and Twitter Card tags via `{{ aeo_og }}` tag
- Dynamic `robots.txt` with per-bot AI allow/disallow rules
- `.well-known` endpoints: MCP manifest, security.txt, agent-skills, api-catalog, OAuth metadata
- Markdown variant middleware (`?format=md` / `Accept: text/markdown`)
- Security headers middleware (X-Content-Type-Options, X-Frame-Options, Referrer-Policy)
- HSTS header middleware
- HTTP `Link` headers pointing to llms.txt and markdown variants
- Control Panel settings panel with AEO score overview
- All features individually togglable via config
