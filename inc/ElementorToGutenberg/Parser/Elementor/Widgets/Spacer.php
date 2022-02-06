<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class Spacer extends Elementor
{

    public function run(): string
    {
        $height = ( ! empty($this->element->settings->space->size)) ? (int)$this->element->settings->space->size : 50;

        $return = '<!-- wp:spacer ';
        $return .= json_encode([
            'height' => $height,
        ]);
        $return .= ' -->';

        $return .= '<div style="height: ' . $height . 'px" aria-hidden="true" class="wp-block-spacer"></div>';
        $return .= '<!-- /wp:spacer -->';

        return $return;
    }
}