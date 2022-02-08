<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Paragraph extends Settings
{
    public function set()
    {
        $this->settings = [
            //'font-family'      => ( ! empty($this->element->settings->typography_font_family)) ? $this->element->settings->typography_font_family : null,
            'font-style'       => ( ! empty($this->element->settings->typography_font_style)) ? $this->element->settings->typography_font_style : null,
            'font-size'        => ( ! empty($this->element->settings->typography_font_size->size)) ? implode('', [
                $this->element->settings->typography_font_size->size,
                ($this->element->settings->typography_font_size->unit ?: 'px')
            ]) : null,
            'font-weight'      => ( ! empty($this->element->settings->typography_font_weight)) ? $this->element->settings->typography_font_weight : null,
            'color'            => ( ! empty($this->element->settings->text_color)) ? $this->element->settings->text_color : null,
            'background-color' => ( ! empty($this->element->settings->_background_color)) ? $this->element->settings->_background_color : null,
            'letter-spacing'   => ( ! empty($this->element->settings->typography_letter_spacing->size))
                ? $this->element->settings->typography_letter_spacing->size . ' ' . $this->element->settings->typography_letter_spacing->unit
                : null,
            'line-height'      => ( ! empty($this->element->settings->typography_line_height->size))
                ? round($this->element->settings->typography_line_height->size, 1)
                : null,
        ];

        $this->replace = [
            // style.typography.*
            //'font-family'      => 'fontFamily',
            'font-style'       => 'fontStyle',
            'font-size'        => 'fontSize',
            'font-weight'      => 'fontWeight',
            'letter-spacing'   => 'letterSpacing',
            'line-height'      => 'lineHeight',
            //'text-transform' => 'textTransform',
            // *.*
            'color'            => 'textColor',
            'background-color' => 'backgroundColor',
            'padding-top'      => 'topPadding',
            'padding-right'    => 'rightPadding',
            'padding-bottom'   => 'bottomPadding',
            'padding-left'     => 'leftPadding',
            'margin-top'       => 'topMargin',
            'margin-right'     => 'rightMargin',
            'margin-bottom'    => 'bottomMargin',
            'margin-left'      => 'leftMargin',
        ];
    }

    public function json_settings(): array
    {
        $json = [];
        foreach ($this->settings as $name => $this->element->settings) {
            if ( ! empty($this->element->settings)) {
                if (preg_match("/^(font|letter|text|line)/i", trim($name)) > 0) {
                    $json['style']['typography'][$this->replace[$name]] = $this->element->settings;
                } else {
                    $json[$this->replace[$name]] = $this->element->settings;
                }
            }
        }

        return $json;
    }
}