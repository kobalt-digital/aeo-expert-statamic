<?php

namespace KobaltDigital\AeoExpert\Tags;

use KobaltDigital\AeoExpert\Generators\SchemaGenerator;
use Statamic\Tags\Tags;

class AeoFaq extends Tags
{
    protected static $handle = 'aeo_faq';

    /**
     * {{ aeo_faq }}
     *   {{ items }}
     *     {{ question }} / {{ answer }}
     *   {{ /items }}
     * {{ /aeo_faq }}
     *
     * Or pass items as parameter:
     * {{ aeo_faq :items="faq_items" }}
     *
     * Outputs FAQ schema JSON-LD + visible HTML.
     */
    public function index(): string
    {
        if (! config('aeo-expert.faq_schema_enabled')) {
            return '';
        }

        // Get items from parameter or context
        $items = $this->params->get('items', $this->context->get('faq_items', []));

        if (empty($items) || ! is_iterable($items)) {
            return '';
        }

        $faqItems = [];
        foreach ($items as $item) {
            $item = is_array($item) ? $item : (method_exists($item, 'toArray') ? $item->toArray() : (array) $item);
            $question = $item['question'] ?? '';
            $answer = $item['answer'] ?? '';

            if ($question && $answer) {
                $faqItems[] = [
                    'question' => strip_tags($question),
                    'answer' => $answer,
                ];
            }
        }

        if (empty($faqItems)) {
            return '';
        }

        $schema = SchemaGenerator::faqPage($faqItems);
        if (! $schema) {
            return '';
        }

        $output = '<script type="application/ld+json">' . "\n";
        $output .= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $output .= "\n" . '</script>' . "\n";

        // Visible HTML
        $output .= '<div class="aeo-faq">';
        foreach ($faqItems as $item) {
            $output .= '<div class="aeo-faq-item">';
            $output .= '<h3 class="aeo-faq-question">' . e($item['question']) . '</h3>';
            $output .= '<div class="aeo-faq-answer">' . $item['answer'] . '</div>';
            $output .= '</div>';
        }
        $output .= '</div>';

        return $output;
    }
}
