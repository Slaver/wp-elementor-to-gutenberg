<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Button extends Settings
{
    public function set()
    {
        $this->settings = [
            // $this->element->settings->size
            // $this->element->settings->button_hover_border_color
            // $this->element->settings->button_box_shadow_box_shadow
            // $this->element->settings->button_box_shadow_box_shadow_type
            // $this->element->settings->_animation
            // $this->element->settings->_animation_delay

            'background-color' => (!empty($this->element->settings->_background_color)) ? $this->element->settings->_background_color : null,
            'font-family' => (!empty($this->element->settings->typography_font_family)) ? $this->element->settings->typography_font_family : null,
            'font-style' => (!empty($this->element->settings->typography_font_style)) ? $this->element->settings->typography_font_style : null,
            'font-size' => (!empty($this->element->settings->typography_font_size->size)) ? implode('', [
                $this->element->settings->typography_font_size->size,
                ($this->element->settings->typography_font_size->unit ?: 'px')
            ]) : null,
            'font-weight' => (!empty($this->element->settings->typography_font_weight)) ? $this->element->settings->typography_font_weight : null,
            'border-color' => (!empty($this->element->settings->border_color)) ? $this->element->settings->border_color : null,

            'padding-top' => (!empty($this->element->settings->text_padding->top))
                ? $this->element->settings->text_padding->top.($this->element->settings->text_padding->unit ?: 'px') : null,
            'padding-right' => (!empty($this->element->settings->text_padding->right)) ?
                $this->element->settings->text_padding->right.($this->element->settings->text_padding->unit ?: 'px') : null,
            'padding-bottom' => (!empty($this->element->settings->text_padding->bottom)) ?
                $this->element->settings->text_padding->bottom.($this->element->settings->text_padding->unit ?: 'px') : null,
            'padding-left' => (!empty($this->element->settings->text_padding->left)) ?
                $this->element->settings->text_padding->left.($this->element->settings->text_padding->unit ?: 'px') : null,
        ];

        if (!empty($this->element->settings->border_radius)) {
            if (!empty($this->element->settings->border_radius->top)) {
                $this->settings['border-radius'] = $this->element->settings->border_radius->top.$this->element->settings->border_width->unit;
                if (!empty($this->element->settings->border_radius->bottom)
                    && ($this->element->settings->border_radius->top !== $this->element->settings->border_radius->bottom)) {
                    $this->settings['border-radius'] = implode(' ', [
                        $this->element->settings->border_radius->top.$this->element->settings->border_radius->unit,
                        $this->element->settings->border_radius->right.$this->element->settings->border_radius->unit,
                        $this->element->settings->border_radius->bottom.$this->element->settings->border_radius->unit,
                        $this->element->settings->border_radius->left.$this->element->settings->border_radius->unit,
                    ]);
                }
            }
        }
        if (!empty($this->element->settings->border_width)) {
            if (!empty($this->element->settings->border_width->top)) {
                $this->settings['border-width'] = $this->element->settings->border_width->top.$this->element->settings->border_width->unit;
                if (!empty($this->element->settings->border_width->bottom)
                    && ($this->element->settings->border_width->top !== $this->element->settings->border_width->bottom)) {
                    $this->settings['border-width'] = implode(' ', [
                        $this->element->settings->border_width->top.$this->element->settings->border_width->unit,
                        $this->element->settings->border_width->right.$this->element->settings->border_width->unit,
                        $this->element->settings->border_width->bottom.$this->element->settings->border_width->unit,
                        $this->element->settings->border_width->left.$this->element->settings->border_width->unit,
                    ]);
                }
            }
        }

        $this->replace = [
            // style.typography.*
            'font-family' => 'fontFamily',
            'font-size' => 'fontSize',
            'font-style' => 'fontStyle',
            'font-weight' => 'fontWeight',
            // style.color.background
            'background-color' => 'background',
            // style.border.*
            'border-color' => 'color',
            'border-radius' => 'radius',
            'border-width' => 'width',
            // spacing.padding.*
            'padding-top' => 'top',
            'padding-right' => 'right',
            'padding-bottom' => 'bottom',
            'padding-left' => 'left',
        ];

        $this->classes[] = 'wp-block-button__link';
        if (!empty($this->element->settings->_background_color)) {
            $this->classes[] = 'has-background';
        }

        if (!empty($this->element->settings->link->url)) {
            $this->attributes['href'] = $this->element->settings->link->url;
            if (!empty($this->element->settings->link->nofollow)) {
                $this->attributes['rel'] = 'nofollow';
            }
        }
    }

    public function json_settings(): array
    {
        $json = [];
        foreach ($this->settings as $name => $this->element->settings) {
            if (!empty($this->element->settings)) {
                if (!empty($this->replace[$name])) {
                    if (preg_match("/^(font|letter|text|line)/i", trim($name)) > 0) {
                        $json['style']['typography'][$this->replace[$name]] = $this->element->settings;
                    } elseif (preg_match("/^background/i", trim($name)) > 0) {
                        $json['style']['color'][$this->replace[$name]] = $this->element->settings;
                    } elseif (preg_match("/^border/i", trim($name)) > 0) {
                        $json['style']['border'][$this->replace[$name]] = $this->element->settings;
                    } elseif (preg_match("/^padding/i", trim($name)) > 0) {
                        $json['spacing']['padding'][$this->replace[$name]] = $this->element->settings;
                    } else {
                        $json[$this->replace[$name]] = $this->element->settings;
                    }
                }
            }
        }
        return $json;
    }
}