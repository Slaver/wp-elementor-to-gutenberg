<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Accordion extends Settings
{

    public function set()
    {
        $currentPostId = wp_cache_get('converter_postId');

        $this->additional = [
            'expandFirstItem' => true,
            'borderRadius'    => 10,
        ];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            '@id' => get_permalink($currentPostId),
        ];

        foreach ($this->element->settings->faq_list as $line) {
            $formattedAnswer = str_replace(['<p>', '</p>'], '', $line->answer);

            $schema['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $line->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $formattedAnswer,
                ]
            ];
        }

        $this->additional['schema'] = json_encode($schema, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $this->attributes = [
            'data-faqtoggle' => 'true',
            'role' => 'tablist',
        ];

        $this->classes = [
            'wp-block-uagb-faq',
            'uagb-faq__outer-wrap',
            'uagb-block-' . $this->element->id,
            'uagb-faq-icon-row',
            'uagb-faq-layout-accordion',
            'uagb-faq-expand-first-true',
            'uagb-faq-inactive-other-true',
            'uagb-faq-equal-height',
            'custom-accordion',
        ];
    }
}