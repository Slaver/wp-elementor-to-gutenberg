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

            $return .= '<!-- wp:uagb/faq';
            $return .= $settings->json();
            $return .= '-->';

            $return .= '<div class="wp-block-uagb-faq uagb-faq__outer-wrap uagb-faq-icon-row uagb-faq-layout-accordion uagb-faq-expand-first-true uagb-faq-inactive-other-true uagb-faq-equal-height" data-faqtoggle="true" role="tablist"><div class="uagb-faq__wrap uagb-buttons-layout-wrap">';

            /*foreach ($this->element->settings->faq_list as $line) {
                $line->question
                $line->answer
            }*/

            //<!-- wp:uagb/faq-child {"block_id":"9402bb14","question":"Q1","answer":"A1"} -->
        }

        return $return;
    }
}