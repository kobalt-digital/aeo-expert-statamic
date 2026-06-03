<?php

namespace KobaltDigital\AeoExpert\Http\Controllers;

use Illuminate\Http\Request;
use KobaltDigital\AeoExpert\Api\ScoreFetcher;
use KobaltDigital\AeoExpert\Generators\LlmsTxtGenerator;
use Statamic\Http\Controllers\CP\CpController as StatamicCpController;

class CpController extends StatamicCpController
{
    public function index()
    {
        $config = config('aeo-expert');

        return view('aeo-expert::cp.settings', [
            'title' => 'AEO Expert',
            'config' => $config,
        ]);
    }

    public function update(Request $request)
    {
        // Config values are managed via config file, not DB.
        // This controller can be extended for runtime overrides if needed.
        return back()->with('success', 'Settings are managed via config/aeo-expert.php');
    }

    public function fetchScore()
    {
        $fetcher = new ScoreFetcher();
        $result = $fetcher->fetch();

        if ($result === null) {
            return response()->json(['error' => 'Failed to fetch score'], 500);
        }

        return response()->json($result);
    }

    public function generateLlms()
    {
        $content = LlmsTxtGenerator::generate();

        return response()->json(['content' => $content]);
    }
}
