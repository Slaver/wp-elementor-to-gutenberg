<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Column extends Settings
{
    public function set()
    {
        $this->settings = [
            // $this->element->settings->margin->{top,right,bottom,left|unit}
            // $this->element->settings->background_overlay_image
            // $this->element->settings->background_overlay_repeat
            // $this->element->settings->background_overlay_size
            // $this->element->settings->background_overlay_opacity
            // $this->element->settings->overlay_blend_mode
            // $this->element->settings->box_shadow_box_shadow
            // $this->element->settings->border_radius

            'flex-basis'       => ( ! empty($this->element->settings->_column_size) && $this->element->settings->_column_size !== 100)
                ? $this->element->settings->_column_size . '%'
                : null,
            'padding-top'      => ( ! empty($this->element->settings->padding->top))
                ? $this->element->settings->padding->top . ($this->element->settings->padding->unit ?: 'px') : null,
            'padding-right'    => ( ! empty($this->element->settings->padding->right)) ?
                $this->element->settings->padding->right . ($this->element->settings->padding->unit ?: 'px') : null,
            'padding-bottom'   => ( ! empty($this->element->settings->padding->bottom)) ?
                $this->element->settings->padding->bottom . ($this->element->settings->padding->unit ?: 'px') : null,
            'padding-left'     => ( ! empty($this->element->settings->padding->left)) ?
                $this->element->settings->padding->left . ($this->element->settings->padding->unit ?: 'px') : null,
            'background-color' => ( ! empty($this->element->settings->background_color)
                                    && mb_strtolower($this->element->settings->background_color) !== '#ffffff')
                ? $this->element->settings->background_color
                : null,
        ];

        $this->replace = [
            'flex-basis'     => 'width',
            // style.spacing.padding.*
            'padding-top'    => 'top',
            'padding-right'  => 'right',
            'padding-bottom' => 'bottom',
            'padding-left'   => 'left',
        ];

        $this->classes[] = 'wp-block-column';

        if ( ! empty($this->element->settings->content_position)) {
            $this->classes[]                       = 'is-vertically-aligned-' . $this->element->settings->content_position;
            $this->additional['verticalAlignment'] = $this->element->settings->content_position;
        }
    }

    public function json_settings(): array
    {
        $json = [];
        foreach ($this->settings as $name => $this->element->settings) {
            if ( ! empty($this->element->settings)) {
                if ( ! empty($this->replace[$name])) {
                    if (preg_match("/^padding/i", trim($name)) > 0) {
                        $json['style']['spacing']['padding'][$this->replace[$name]] = $this->element->settings;
                    } else {
                        $json[$this->replace[$name]] = $this->element->settings;
                    }
                }
            }
        }

        return $json;
    }
}