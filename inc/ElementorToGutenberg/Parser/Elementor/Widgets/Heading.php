<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class Heading extends Elementor
{

    public function run(): string
    {
        $return = '';

        if ( ! empty($this->element->settings->title)) {
            $tag      = 'h2';
            $text     = $this->element->settings->title;
            $settings = new Settings\Heading($this->element);

            if ( ! empty($this->element->settings->header_size)) {
                if ($this->element->settings->header_size !== 'h2') {
                    $tag = $this->element->settings->header_size;
                }
            }

            $classes = $settings->classes();
            $style   = $settings->css();

            $return .= '<!-- wp:heading ';
            $return .= $settings->json();
            $return .= ' -->';
            $return .= '<' . $tag;
            if ( ! empty($classes)) {
                $return .= ' class="' . $classes . '"';
            }
            if ( ! empty($style)) {
                $return .= ' style="' . $style . '"';
            }
            $return .= '>' . $text;
            $return .= '</' . $tag . '>';
            $return .= '<!-- /wp:heading -->';
        }

        return $return;
    }
}