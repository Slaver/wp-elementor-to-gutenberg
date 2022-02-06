<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class Shortcode extends Elementor
{

    public function run(): string
    {
        return '<!-- wp:shortcode -->' . $this->element->settings->shortcode . '<!-- /wp:shortcode -->';
    }

}