<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class IconList extends Elementor
{
    public function run(): string
    {
        $return = '';
        wp_send_json_error($this->element);die;
        return $return;
    }
}