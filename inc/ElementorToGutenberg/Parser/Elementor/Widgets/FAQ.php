<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class FAQ extends Elementor
{

    public function run(): string
    {
        $return = '';

        if ( ! empty($this->element->settings->faq_list)) {
            $settings = new Settings\Accordion($this->element);

            $return .= '<!-- wp:uagb/faq ';
            $return .= $settings->json();
            $return .= ' -->';
            $return .= '<div class="'.$settings->classes().'" '. $settings->attributes().'>';
            $return .= '<div class="uagb-faq__wrap uagb-buttons-layout-wrap">';

            foreach ($this->element->settings->faq_list as $line) {
                $blockId = $line->_id;
                $question = $line->question;
                $formattedAnswer = str_replace(['<p>', '</p>'], '', $line->answer);

                $return .= '<!-- wp:uagb/faq-child ';
                $return .= json_encode([
                    'block_id' => $blockId,
                    'question' => $question,
                    'answer' => $formattedAnswer,
                    'icon' => '',
                    'iconActive' => '',
                ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $return .= ' -->';

                $return .= '<div class="wp-block-uagb-faq-child uagb-faq-child__outer-wrap uagb-block-' . $blockId . '">';
                $return .= '<div class="uagb-faq-child__wrapper"><div class="uagb-faq-item" role="tab" tabindex="0">';
                $return .= '<div class="uagb-faq-questions-button uagb-faq-questions">';
                $return .= '<span class="uagb-icon uagb-faq-icon-wrap"></span>';
                $return .= '<span class="uagb-icon-active uagb-faq-icon-wrap"></span>';
                $return .= '<span class="uagb-question">' . $question . '</span>';
                $return .= '</div>';
                $return .= '<div class="uagb-faq-content"><span><p>' . $formattedAnswer .'</p></span></div>';
                $return .= '</div></div>';
                $return .= '</div>';

                $return .= '<!-- /wp:uagb/faq-child -->';
            }

            $return .= '</div></div>';
            $return .= '<!-- /wp:uagb/faq -->';
        }

        return $return;
    }
}