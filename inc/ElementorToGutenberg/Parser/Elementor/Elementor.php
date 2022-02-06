<?php

namespace ElementorToGutenberg\Parser\Elementor;

class Elementor
{

    protected object $element;
    protected Settings $settings;

    public function __construct(object $element)
    {
        $this->element = $element;
    }
}