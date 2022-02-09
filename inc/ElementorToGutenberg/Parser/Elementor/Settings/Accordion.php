<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Accordion extends Settings
{
    public function set()
    {
        $this->additional = [
            'expandFirstItem' => true,
            'borderRadius'    => 10,
        ];
    }
}