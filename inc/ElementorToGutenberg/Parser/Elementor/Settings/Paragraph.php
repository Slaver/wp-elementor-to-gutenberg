<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Paragraph extends Settings
{
    public function set()
    {
        $this->settings = [
            //'font-family'      => ( ! empty($this->element->settings->typography_font_family)) ? $this->element->settings->typography_font_family : null,
            'font-style' => (!empty($this->element->settings->typography_font_style)) ? $this->element->settings->typography_font_style : null,
            'font-size' => (!empty($this->element->settings->typography_font_size->size)) ? implode('', [
                $this->element->settings->typography_font_size->size,
                ($this->element->settings->typography_font_size->unit ?: 'px')
            ]) : null,
            'font-weight' => (!empty($this->element->settings->typography_font_weight)) ? $this->element->settings->typography_font_weight : null,
            'color' => (!empty($this->element->settings->text_color)) ? $this->element->settings->text_color : null,
            'background-color' => (!empty($this->element->settings->_background_color)) ? $this->element->settings->_background_color : null,
            'letter-spacing' => (!empty($this->element->settings->typography_letter_spacing->size))
                ? $this->element->settings->typography_letter_spacing->size . ' ' . $this->element->settings->typography_letter_spacing->unit
                : null,
            'line-height' => (!empty($this->element->settings->typography_line_height->size))
                ? round($this->element->settings->typography_line_height->size, 1)
                : null,
            'border_style' => (!empty($this->element->settings->_border_border)) ? $this->element->settings->_border_border : null,
            'border-top-width' => (!empty($this->element->settings->_border_width->top)) ? implode('', [
                $this->element->settings->_border_width->top,
                ($this->element->settings->_border_width->unit ?: 'px')
            ]) : null,
            'border-right-width' => (!empty($this->element->settings->_border_width->right)) ? implode('', [
                $this->element->settings->_border_width->right,
                ($this->element->settings->_border_width->unit ?: 'px')
            ]) : null,
            'border-left-width' => (!empty($this->element->settings->_border_width->left)) ? implode('', [
                $this->element->settings->_border_width->left,
                ($this->element->settings->_border_width->unit ?: 'px')
            ]) : null,
            'border-bottom-width' => (!empty($this->element->settings->_border_width->bottom)) ? implode('', [
                $this->element->settings->_border_width->bottom,
                ($this->element->settings->_border_width->unit ?: 'px')
            ]) : null,
            'border-top-left-radius' => (!empty($this->element->settings->_border_radius->left)) ? implode('', [
                $this->element->settings->_border_radius->left,
                ($this->element->settings->_border_radius->unit ?: 'px')
            ]) : null,
            'border-top-right-radius' => (!empty($this->element->settings->_border_radius->top)) ? implode('', [
                $this->element->settings->_border_radius->top,
                ($this->element->settings->_border_radius->unit ?: 'px')
            ]) : null,
            'border-bottom-left-radius' => (!empty($this->element->settings->_border_radius->bottom)) ? implode('', [
                $this->element->settings->_border_radius->bottom,
                ($this->element->settings->_border_radius->unit ?: 'px')
            ]) : null,
            'border-bottom-right-radius' => (!empty($this->element->settings->_border_radius->right)) ? implode('', [
                $this->element->settings->_border_radius->right,
                ($this->element->settings->_border_radius->unit ?: 'px')
            ]) : null,
            'padding-top' => (!empty($this->element->settings->_padding->top)) ? implode('', [
                $this->element->settings->_padding->top,
                ($this->element->settings->_padding->unit ?: 'px')
            ]) : null,
            'padding-bottom' => (!empty($this->element->settings->_padding->bottom)) ? implode('', [
                $this->element->settings->_padding->bottom,
                ($this->element->settings->_padding->unit ?: 'px')
            ]) : null,
            'padding-right' => (!empty($this->element->settings->_padding->right)) ? implode('', [
                $this->element->settings->_padding->right,
                ($this->element->settings->_padding->unit ?: 'px')
            ]) : null,
            'padding-left' => (!empty($this->element->settings->_padding->left)) ? implode('', [
                $this->element->settings->_padding->left,
                ($this->element->settings->_padding->unit ?: 'px')
            ]) : null,

        ];


        $this->replace = [
            // style.typography.*
            //'font-family'      => 'fontFamily',
            'font-style' => 'fontStyle',
            'font-size' => 'fontSize',
            'font-weight' => 'fontWeight',
            'letter-spacing' => 'letterSpacing',
            'line-height' => 'lineHeight',
            //'text-transform' => 'textTransform',
            // *.*
            'color' => 'textColor',
            'background-color' => 'backgroundColor',
            'border-style' => 'borderStyle',
            'border-top-width' => 'borderTopWidth',
            'border-right-width' => 'borderRightWidth',
            'border-left-width' => 'borderLeftWidth',
            'border-bottom-width' => 'borderBottomWidth',
            'border-top-left-radius' => 'borderTopLeftRadius',
            'border-top-right-radius' => 'borderTopRightRadius',
            'border-bottom-left-radius' => 'borderBottomLeftRadius',
            'border-bottom-right-radius' => 'borderBottomRightRadius',
            'padding-top' => 'topPadding',
            'padding-right' => 'rightPadding',
            'padding-bottom' => 'bottomPadding',
            'padding-left' => 'leftPadding',
            'margin-top' => 'topMargin',
            'margin-right' => 'rightMargin',
            'margin-bottom' => 'bottomMargin',
            'margin-left' => 'leftMargin',
        ];
    }

    public function json_settings(): array
    {
        $json = [];
        foreach ($this->settings as $name => $this->element->settings) {
            if (!empty($this->element->settings)) {
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