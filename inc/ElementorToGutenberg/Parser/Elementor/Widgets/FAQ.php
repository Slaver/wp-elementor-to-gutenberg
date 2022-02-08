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
            $return .= '<div class="wp-block-uagb-faq uagb-faq__outer-wrap uagb-block-'. $this->element->id . ' uagb-faq-icon-row uagb-faq-layout-accordion uagb-faq-inactive-other-true uagb-faq-equal-height" data-faqtoggle="true" role="tablist"><div class="uagb-faq__wrap uagb-buttons-layout-wrap">';

            foreach ($this->element->settings->faq_list as $line) {
                $blockId = $line->_id;
                $question = $line->question;
                $answer = $line->answer;

                $childOptions = json_encode([
                    'block_id' => $blockId
                ]);

                $return .= '<!-- wp:uagb/faq-child ';
                $return .= $childOptions;
                $return .= ' -->';

                $return .= '<div class="wp-block-uagb-faq-child uagb-faq-child__outer-wrap uagb-block-' . $blockId . '"' . '><div class="uagb-faq-child__wrapper"><div class="uagb-faq-item" role="tab" tabindex="0"><div class="uagb-faq-questions-button uagb-faq-questions"><span class="uagb-icon uagb-faq-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span><span class="uagb-icon-active uagb-faq-icon-wrap"><svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 448 512"><path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg></span><span class="uagb-question">' . $question . '</span></div><div class="uagb-faq-content"><span><p>' . $answer .'</p></span></div></div></div></div>';

                $return .= '<!-- /wp:uagb/faq-child -->';
            }

            $return .= '</div></div>';
            $return .= '<!-- /wp:uagb/faq -->';

        }

        return $return;
    }
}