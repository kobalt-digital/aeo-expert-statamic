<?php

namespace KobaltDigital\AeoExpert\Http\Controllers;

use Illuminate\Http\Response;

class RobotsTxtController
{
    public function show(): Response
    {
        // Only serve if no physical robots.txt exists
        if (file_exists(public_path('robots.txt'))) {
            abort(404);
        }

        $lines = [];
        $lines[] = 'User-agent: *';
        $lines[] = 'Allow: /';
        $lines[] = '';

        // AI bot rules
        if (config('aeo-expert.robots_ai_enabled')) {
            $bots = config('aeo-expert.robots_ai_bots', []);
            if (! empty($bots)) {
                $lines[] = '# AEO Expert - AI Bot Rules';
                foreach ($bots as $bot => $action) {
                    $lines[] = 'User-agent: ' . $bot;
                    $lines[] = ($action === 'allow') ? 'Allow: /' : 'Disallow: /';
                    $lines[] = '';
                }
            }
        }

        // Sitemap
        if (config('aeo-expert.robots_sitemap_enabled')) {
            $lines[] = '# Sitemap';
            $lines[] = 'Sitemap: ' . url('/sitemap.xml');
            $lines[] = '';
        }

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
