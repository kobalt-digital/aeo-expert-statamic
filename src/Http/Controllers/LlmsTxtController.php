<?php

namespace KobaltDigital\AeoExpert\Http\Controllers;

use Illuminate\Http\Response;
use KobaltDigital\AeoExpert\Generators\LlmsTxtGenerator;

class LlmsTxtController
{
    public function show(): Response
    {
        if (! config('aeo-expert.llms_txt_enabled')) {
            abort(404);
        }

        $content = config('aeo-expert.llms_txt_content');
        if (empty($content)) {
            $content = LlmsTxtGenerator::generate();
        }

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'X-Robots-Tag' => 'noindex',
        ]);
    }
}
