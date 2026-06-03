<?php

namespace KobaltDigital\AeoExpert\Generators;

class SecurityTxtGenerator
{
    public static function generate(): string
    {
        $lines = [];

        $contact = config('aeo-expert.security_txt_contact');
        if (empty($contact)) {
            $contact = 'mailto:' . config('mail.from.address', 'admin@example.com');
        }
        $lines[] = 'Contact: ' . $contact;

        // Expires is required by RFC 9116
        $expires = config('aeo-expert.security_txt_expires');
        if (empty($expires)) {
            $expires = gmdate('Y-m-d\TH:i:s\Z', strtotime('+1 year'));
        }
        $lines[] = 'Expires: ' . $expires;

        $lines[] = 'Preferred-Languages: en, nl';

        $lines[] = 'Canonical: ' . url('/.well-known/security.txt');

        return implode("\n", $lines) . "\n";
    }
}
