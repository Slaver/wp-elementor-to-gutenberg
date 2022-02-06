<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Image extends Settings
{
    public function set()
    {
        // $this->element->settings->opacity

        $this->attributes = [
            'align'  => ( ! empty($this->element->settings->align))
                ? (int)$this->element->settings->align
                : null,
            'width'  => ( ! empty($this->element->settings->image_custom_dimension->width))
                ? (int)$this->element->settings->image_custom_dimension->width
                : null,
            'height' => ( ! empty($this->element->settings->image_custom_dimension->height))
                ? (int)$this->element->settings->image_custom_dimension->height
                : null,
        ];

        // Two variants of image sizes in Elementor
        if ( ! empty($this->element->settings->width)) {
            $this->attributes['width'] = $this->element->settings->width;
        }
        if ( ! empty($this->element->settings->height)) {
            $this->attributes['height'] = $this->element->settings->height;
        }

        if ( ! empty($this->element->settings->image->id)) {
            $this->classes[] = 'wp-image-' . $this->element->settings->image->id;
        }

        // Problem with Elementor and default WP CSS reset
        // We need to know width of image, height is not enough, but Elementor saves only height
        if ( ! empty($this->element->settings->image->id) && $this->attributes['height'] && ! $this->attributes['width']) {
            $image = wp_get_attachment_image_src($this->element->settings->image->id, 'full');
            if ( ! empty($image[1]) && ! empty($image[2])) {
                $imageScale                = $image[1] / $image[2];
                $this->attributes['width'] = round($this->attributes['height'] * $imageScale);
            }
        }

        $this->additional = [
            'id'              => ( ! empty($this->element->settings->image->id)) ? $this->element->settings->image->id : null,
            'height'          => ( ! empty($this->element->settings->image_custom_dimension->height))
                ? (int)$this->element->settings->image_custom_dimension->height
                : null,
            'width'           => ( ! empty($this->element->settings->image_custom_dimension->width))
                ? (int)$this->element->settings->image_custom_dimension->width
                : null,
            // Default values
            'linkDestination' => 'none',
            'sizeSlug'        => 'large',
            'className'       => 'size-large',
        ];
    }
}