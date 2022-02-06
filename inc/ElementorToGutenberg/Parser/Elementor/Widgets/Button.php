<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class Button extends Elementor
{

    public function run(): string
    {
        $return = '';

        if ( ! empty($this->element->settings->text)) {
            $text = $this->element->settings->text;

            $settings = new Settings\Button($this->element);
            $style    = $settings->css();

            $return                            .= '<!-- wp:buttons ';
            $wrapperSettings['className']      = 'wp-block-button';
            $wrapperSettings['layout']['type'] = 'flex';
            //$wrapperSettings['layout']['orientation'] = 'horizontal';
            if ( ! empty($this->element->settings->align)) {
                $wrapperSettings['layout']['justifyContent'] = $this->element->settings->align;
            }
            $return .= json_encode($wrapperSettings);
            $return .= ' -->';
            $return .= '<div class="wp-block-buttons wp-block-button">';
            $return .= '<!-- wp:button ';
            $return .= $settings->json();
            $return .= ' -->';
            $return .= '<div class="wp-block-button"><a ' . $settings->attributes();
            if ( ! empty($settings->classes())) {
                $return .= ' class="' . $settings->classes() . '"';
            }
            if ( ! empty($style)) {
                $return .= ' style="' . $style . '"';
            }
            $return .= '>' . $text;
            $return .= '</a></div>';
            $return .= '<!-- /wp:button --></div>';
            $return .= '<!-- /wp:buttons -->';
        }

        return $return;
    }
}