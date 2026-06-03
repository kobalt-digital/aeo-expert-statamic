<?php

namespace KobaltDigital\AeoExpert\Api;

use Illuminate\Support\Facades\Cache;

class ScoreFetcher
{
    const CACHE_KEY = 'aeo_expert_score';

    const CACHE_TTL = 86400; // 24 hours

    /**
     * Get cached score.
     */
    public function get(): ?array
    {
        return Cache::get(self::CACHE_KEY);
    }

    /**
     * Fetch fresh score from API and cache it.
     */
    public function fetch(): ?array
    {
        $client = new ApiClient();
        $result = $client->getScore(config('app.url'));

        if ($result === null) {
            return null;
        }

        Cache::put(self::CACHE_KEY, $result, self::CACHE_TTL);

        return $result;
    }

    /**
     * Get badge CSS class based on total score.
     */
    public static function getBadgeClass(int $score): string
    {
        if ($score >= 80) {
            return 'aeo-badge-gold';
        }
        if ($score >= 60) {
            return 'aeo-badge-silver';
        }
        if ($score >= 40) {
            return 'aeo-badge-bronze';
        }

        return 'aeo-badge-red';
    }

    /**
     * Get badge label based on total score.
     */
    public static function getBadgeLabel(int $score): string
    {
        if ($score >= 80) {
            return 'Gold';
        }
        if ($score >= 60) {
            return 'Silver';
        }
        if ($score >= 40) {
            return 'Bronze';
        }

        return 'Needs Work';
    }
}
