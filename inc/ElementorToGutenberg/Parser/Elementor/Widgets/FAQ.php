<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class FAQ extends Elementor
{

    public function run(): string
    {
        // TODO make this more elegant
        $excessiveTags = ['<p>', '</p>'];

        $return = '';
        if ( ! empty($this->element->settings->faq_list)) {
            $settings = new Settings\Accordion($this->element);

            $currentPostId = wp_cache_get('converter_postId');

            $return .= '<!-- wp:uagb/faq ';

            $schemaOption = ',"schema":"{\u0022@context\u0022:\u0022https://schema.org\u0022,\u0022@type\u0022:\u0022FAQPage\u0022,\u0022@id\u0022:\u0022' . get_permalink($currentPostId) . '\u0022,\u0022mainEntity\u0022:[';

            foreach ($this->element->settings->faq_list as $line) {
                $question = $line->question;
                $formattedAnswer= str_replace($excessiveTags, '', $line->answer);
                $schemaOption .= '{\u0022@type\u0022:\u0022Question\u0022,\u0022name\u0022:\u0022' . $question . '\u0022,\u0022acceptedAnswer\u0022:{\u0022@type\u0022:\u0022Answer\u0022,\u0022text\u0022:\u0022' . $formattedAnswer . '\u0022}},';
            }

            $schemaOption = substr($schemaOption, 0, -1);
            $schemaOption .= ']}"}';

            $params = $settings->json();
            $params = substr($params, 0, -1);
            $params .= $schemaOption;
            $return .= $params;

            $return .= ' -->';
            $return .= '<div class="wp-block-uagb-faq uagb-faq__outer-wrap uagb-block-'. $this->element->id . ' uagb-faq-icon-row uagb-faq-layout-accordion uagb-faq-inactive-other-true uagb-faq-equal-height" data-faqtoggle="true" role="tablist"><div class="uagb-faq__wrap uagb-buttons-layout-wrap">';

            foreach ($this->element->settings->faq_list as $line) {
                $blockId = $line->_id;
                $question = $line->question;

                $formattedAnswer = str_replace($excessiveTags, '', $line->answer);

                $childOptions = json_encode([
                    'block_id' => $blockId,
                    'question' => $question,
                    'answer' => $formattedAnswer
                ]);

                $return .= '<!-- wp:uagb/faq-child ';
                $return .= $childOptions;
                $return .= ' -->';

                $return .= '<div class="wp-block-uagb-faq-child uagb-faq-child__outer-wrap uagb-block-' . $blockId . '"' . '><div class="uagb-faq-child__wrapper"><div class="uagb-faq-item" role="tab" tabindex="0"><div class="uagb-faq-questions-button uagb-faq-questions"><span class="uagb-icon uagb-faq-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span><span class="uagb-icon-active uagb-faq-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 448 512"><path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span><span class="uagb-question">' . $question . '</span></div><div class="uagb-faq-content"><span><p>' . $formattedAnswer .'</p></span></div></div></div></div>';

                $return .= '<!-- /wp:uagb/faq-child -->';
            }

            $return .= '</div></div>';
            $return .= '<!-- /wp:uagb/faq -->';

        }

        return $return;
    }
}