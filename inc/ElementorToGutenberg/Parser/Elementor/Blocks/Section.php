<?php

namespace ElementorToGutenberg\Parser\Elementor\Blocks;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class Section extends Elementor
{

    public function open(): string
    {
        $settings = new Settings\Section($this->element);

        $return = '<!-- wp:uagb/section ';
        $return .= $settings->json();
        $return .= ' -->';

        $return .= '<section class="wp-block-uagb-section uagb-section__wrap section-inner-wrap ' . $settings->classes() . '">';
        $return .= '<div class="uagb-section__overlay"></div>';
        $return .= '<div class="uagb-section__inner-wrap">';
        $return .= '<!-- wp:columns -->';
        $return .= '<div class="wp-block-columns">';

        return $return;
    }

    public function close(): string
    {
        $return = '</div>';
        $return .= '<!-- /wp:columns -->';
        $return .= '</div></section><!-- /wp:uagb/section -->';

        return $return;
    }

}