<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class OlList extends Settings
{
    public function set()
    {
        $this->settings = [
            'font-family' => ( ! empty($this->element->settings->typography_font_family)) ? $this->element->settings->typography_font_family : null,
            'font-size'   => ( ! empty($this->element->settings->typography_font_size->size)) ? implode('', [
                $this->element->settings->typography_font_size->size,
                ($this->element->settings->typography_font_size->unit ?: 'px')
            ]) : null,
            'font-weight' => ( ! empty($this->element->settings->typography_font_weight)) ? $this->element->settings->typography_font_weight : null,
            'color'       => ( ! empty($this->element->settings->text_color)) ? $this->element->settings->text_color : null,
        ];

        $this->replace = [
            'font-family' => 'fontFamily',
            'font-size'   => 'fontSize',
            'font-weight' => 'fontWeight',
            'color'       => 'textColor',
        ];

        $this->additional = [
            'ordered' => true,
        ];
    }
}