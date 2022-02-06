<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Heading extends Settings
{
    public function set()
    {
        $this->settings = [
            'background-color' => ( ! empty($this->element->settings->_background_color)) ? $this->element->settings->_background_color : null,
            'font-family'      => ( ! empty($this->element->settings->typography_font_family)) ? $this->element->settings->typography_font_family : null,
            'font-style'       => ( ! empty($this->element->settings->typography_font_style)) ? $this->element->settings->typography_font_style : null,
            'font-size'        => ( ! empty($this->element->settings->typography_font_size->size)) ? implode('', [
                $this->element->settings->typography_font_size->size,
                ($this->element->settings->typography_font_size->unit ?: 'px')
            ]) : null,
            'font-weight'      => ( ! empty($this->element->settings->typography_font_weight)) ? $this->element->settings->typography_font_weight : null,
            'line-height'      => ( ! empty($this->element->settings->typography_line_height->size))
                ? round($this->element->settings->typography_line_height->size, 1)
                : null,
            'letter-spacing'   => ( ! empty($this->element->settings->typography_letter_spacing)) ? $this->element->settings->typography_letter_spacing : null,
        ];

        $this->replace = [
            // style.typography.*
            'font-family'      => 'fontFamily',
            'font-size'        => 'fontSize',
            'font-style'       => 'fontStyle',
            'font-weight'      => 'fontWeight',
            'line-height'      => 'lineHeight',
            'letter-spacing'   => 'letterSpacing',
            'text-transform'   => 'textTransform', // ??
            // style.color.background
            'background-color' => 'background',
        ];

        $textColor = null;
        if ( ! empty($this->element->settings->title_color)) {
            $parsedColor = mb_strtolower(str_replace('#', '', $this->element->settings->title_color));
            // Gutenberg converts #ffffff to white and require such format
            $textColor = ($parsedColor === 'ffffff') ? 'white' : $parsedColor;
        }

        $this->additional = [
            'level'     => ( ! empty($this->element->settings->header_size)) ? (int)str_replace('h', '',
                $this->element->settings->header_size) : null,
            // For h1-h6 in Gutenberg color must be only in comments
            'textColor' => ( ! empty($textColor)) ? '#' . $textColor : null,
        ];

        if ( ! empty($this->element->settings->title_color)) {
            $this->classes[] = 'has-text-color';
            $this->classes[] = 'has-' . $textColor . '-color';
        }

        if ( ! empty($this->element->settings->_background_color)) {
            $this->classes[] = 'has-background';
        }
    }

    public function json_settings(): array
    {
        $json = [];
        foreach ($this->settings as $name => $this->element->settings) {
            if ( ! empty($this->element->settings)) {
                if ( ! empty($this->replace[$name])) {
                    if (preg_match("/^(font|letter|text|line)/i", trim($name)) > 0) {
                        $json['style']['typography'][$this->replace[$name]] = $this->element->settings;
                    } elseif (preg_match("/^(background)/i", trim($name)) > 0) {
                        $json['style']['color'][$this->replace[$name]] = $this->element->settings;
                    } else {
                        $json[$this->replace[$name]] = $this->element->settings;
                    }
                }
            }
        }

        return $json;
    }
}