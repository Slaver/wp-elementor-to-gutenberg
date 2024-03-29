<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class Image extends Elementor
{
    public function run(): string
    {
        $return = '';

        if ( ! empty($this->element->settings->image->id)) {
            $settings = new Settings\Image($this->element);

            $return .= '<!-- wp:image ';
            $return .= $settings->json();
            $return .= ' -->';

            $return .= '<figure class="wp-block-image size-large is-resized">';
            $return .= '<img src="' . $this->element->settings->image->url . '" ' . $settings->attributes();
            if ( ! empty($settings->classes())) {
                $return .= ' class="' . $settings->classes() . '"';
            }
            $return .= ' alt="" />';
            $return .= '</figure>';
            $return .= '<!-- /wp:image -->';
        } elseif ( ! empty($this->element->settings->image->url)) {
            $return .= '<!-- wp:image ';
            $return .= json_encode(['sizeSlug' => 'large']);
            $return .= ' -->';
            $return .= '<figure class="wp-block-image size-large"><img src="'.$this->element->settings->image->url.'" alt="" /></figure>';
            $return .= '<!-- /wp:image -->';
        }

        return $return;
    }
}