<?php

namespace KobaltDigital\AeoExpert;

use KobaltDigital\AeoExpert\Http\Middleware\HstsHeader;
use KobaltDigital\AeoExpert\Http\Middleware\LinkHeaders;
use KobaltDigital\AeoExpert\Http\Middleware\MarkdownVariant;
use KobaltDigital\AeoExpert\Http\Middleware\SecurityHeaders;
use KobaltDigital\AeoExpert\Tags\AeoFaq;
use KobaltDigital\AeoExpert\Tags\AeoMetaTags;
use KobaltDigital\AeoExpert\Tags\AeoOpenGraph;
use KobaltDigital\AeoExpert\Tags\AeoSchema;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        AeoSchema::class,
        AeoMetaTags::class,
        AeoOpenGraph::class,
        AeoFaq::class,
    ];

    protected $routes = [
        'web' => __DIR__ . '/../routes/web.php',
        'cp' => __DIR__ . '/../routes/cp.php',
    ];

    protected $middlewareGroups = [
        'web' => [
            MarkdownVariant::class,
            SecurityHeaders::class,
            HstsHeader::class,
            LinkHeaders::class,
        ],
    ];

    public function bootAddon()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/aeo-expert.php', 'aeo-expert');

        $this->publishes([
            __DIR__ . '/../config/aeo-expert.php' => config_path('aeo-expert.php'),
        ], 'aeo-expert-config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'aeo-expert');

        if (config('aeo-expert.robots_ai_enabled')) {
            $this->appendRobotsTxt();
        }
    }

    protected function appendRobotsTxt()
    {
        // Statamic doesn't have a robots.txt filter like WordPress.
        // We create/append to the physical robots.txt via a command or
        // serve it dynamically if no physical file exists.
        // For now, we register a route that serves robots.txt if the
        // physical file doesn't exist in /public.
    }
}
