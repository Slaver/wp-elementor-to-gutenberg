<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class IconList extends Settings
{
    public function set()
    {
        $this->additional = [
            'classMigrate' => true,
            'childMigrate' => true,
        ];

        $this->classes = [
            'wp-block-uagb-icon-list',
            'uagb-icon-list__outer-wrap',
            'uagb-icon-list__layout-vertical',
            'uagb-block-' . $this->element->id,
        ];
    }
}