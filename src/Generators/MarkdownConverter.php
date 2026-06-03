<?php

namespace KobaltDigital\AeoExpert\Generators;

class MarkdownConverter
{
    public static function convert(string $html): string
    {
        if (empty($html)) {
            return '';
        }

        $text = $html;

        // Normalize line breaks
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        // Convert headings
        $text = preg_replace('/<h1[^>]*>(.*?)<\/h1>/is', "# $1\n\n", $text);
        $text = preg_replace('/<h2[^>]*>(.*?)<\/h2>/is', "## $1\n\n", $text);
        $text = preg_replace('/<h3[^>]*>(.*?)<\/h3>/is', "### $1\n\n", $text);
        $text = preg_replace('/<h4[^>]*>(.*?)<\/h4>/is', "#### $1\n\n", $text);
        $text = preg_replace('/<h5[^>]*>(.*?)<\/h5>/is', "##### $1\n\n", $text);
        $text = preg_replace('/<h6[^>]*>(.*?)<\/h6>/is', "###### $1\n\n", $text);

        // Convert bold and italic
        $text = preg_replace('/<(strong|b)[^>]*>(.*?)<\/(strong|b)>/is', '**$2**', $text);
        $text = preg_replace('/<(em|i)[^>]*>(.*?)<\/(em|i)>/is', '*$2*', $text);

        // Convert links
        $text = preg_replace('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', '[$2]($1)', $text);

        // Convert images
        $text = preg_replace('/<img[^>]+src=["\']([^"\']+)["\'][^>]*alt=["\']([^"\']*)["\'][^>]*\/?>/is', '![$2]($1)', $text);
        $text = preg_replace('/<img[^>]+alt=["\']([^"\']*)["\'][^>]*src=["\']([^"\']+)["\'][^>]*\/?>/is', '![$1]($2)', $text);

        // Convert lists
        $text = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "- $1\n", $text);
        $text = preg_replace('/<\/?[ou]l[^>]*>/is', "\n", $text);

        // Convert paragraphs and line breaks
        $text = preg_replace('/<p[^>]*>(.*?)<\/p>/is', "$1\n\n", $text);
        $text = preg_replace('/<br\s*\/?>/is', "\n", $text);

        // Convert blockquotes
        $text = preg_replace('/<blockquote[^>]*>(.*?)<\/blockquote>/is', "> $1\n\n", $text);

        // Convert code
        $text = preg_replace('/<code[^>]*>(.*?)<\/code>/is', '`$1`', $text);
        $text = preg_replace('/<pre[^>]*>(.*?)<\/pre>/is', "```\n$1\n```\n\n", $text);

        // Convert horizontal rules
        $text = preg_replace('/<hr[^>]*\/?>/is', "\n---\n\n", $text);

        // Strip remaining HTML tags
        $text = strip_tags($text);

        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        // Clean up excessive whitespace
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = trim($text);

        return $text;
    }
}
