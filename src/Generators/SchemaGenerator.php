<?php

namespace KobaltDigital\AeoExpert\Generators;

class SchemaGenerator
{
    public static function organization(): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => config('aeo-expert.schema_org_type', 'Organization'),
            'name' => config('aeo-expert.schema_org_name') ?: config('app.name'),
            'url' => config('aeo-expert.schema_org_url') ?: config('app.url'),
        ];

        $description = config('aeo-expert.schema_org_description');
        if ($description) {
            $schema['description'] = $description;
        }

        $logo = config('aeo-expert.schema_org_logo');
        if ($logo) {
            $schema['logo'] = [
                '@type' => 'ImageObject',
                'url' => $logo,
            ];
        }

        // sameAs
        if (config('aeo-expert.sameas_enabled')) {
            $urls = array_filter(config('aeo-expert.sameas_urls', []));
            if ($urls) {
                $schema['sameAs'] = array_values($urls);
            }
        }

        // ContactPoint
        if (config('aeo-expert.contactpoint_enabled')) {
            $email = config('aeo-expert.contactpoint_email');
            $phone = config('aeo-expert.contactpoint_phone');

            if ($email || $phone) {
                $contact = [
                    '@type' => 'ContactPoint',
                    'contactType' => config('aeo-expert.contactpoint_type', 'customer support'),
                ];
                if ($phone) {
                    $contact['telephone'] = $phone;
                }
                if ($email) {
                    $contact['email'] = $email;
                }
                $schema['contactPoint'] = $contact;
            }

            // Address
            $addr = config('aeo-expert.contactpoint_address', []);
            if (is_array($addr) && (! empty($addr['street']) || ! empty($addr['city']))) {
                $address = ['@type' => 'PostalAddress'];
                if (! empty($addr['street'])) {
                    $address['streetAddress'] = $addr['street'];
                }
                if (! empty($addr['city'])) {
                    $address['addressLocality'] = $addr['city'];
                }
                if (! empty($addr['postal'])) {
                    $address['postalCode'] = $addr['postal'];
                }
                if (! empty($addr['country'])) {
                    $address['addressCountry'] = $addr['country'];
                }
                $schema['address'] = $address;
            }
        }

        return $schema;
    }

    public static function faqPage(array $items): ?array
    {
        if (empty($items)) {
            return null;
        }

        $entities = [];
        foreach ($items as $item) {
            if (empty($item['question']) || empty($item['answer'])) {
                continue;
            }
            $entities[] = [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ];
        }

        if (empty($entities)) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }
}
