<?php

namespace KobaltDigital\AeoExpert\Api;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('aeo-expert.api_url', 'https://aeo-expert.nl/api/v1/score');
    }

    /**
     * Fetch score for a URL.
     *
     * @return array|null Score data or null on failure.
     */
    public function getScore(string $url): ?array
    {
        if (! config('aeo-expert.api_consent')) {
            return null;
        }

        $response = Http::timeout(30)
            ->withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'AEO-Expert-Statamic/1.0.0',
            ])
            ->get($this->baseUrl, [
                'url' => $url,
            ]);

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();

        if (! is_array($data) || ! isset($data['scores'])) {
            return null;
        }

        return $data;
    }
}
