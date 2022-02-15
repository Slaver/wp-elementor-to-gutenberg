<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class Video extends Elementor
{
    public function run(): string
    {
        $video = [];
        $return = '';

        // If vimeo placeholder
        if ( ! empty($this->element->settings->vimeo_url) && $this->element->settings->vimeo_url !== 'https://vimeo.com/235215203') {
            $video = [
                'url' => $this->element->settings->vimeo_url,
                'provider' => 'vimeo',
            ];
        // If dailymotion placeholder
        } elseif ( ! empty($this->element->settings->dailymotion_url) && $this->element->settings->dailymotion_url !== 'https://www.dailymotion.com/video/x6tqhqb') {
            $video = [
                'url' => $this->element->settings->dailymotion_url,
                'provider' => 'dailymotion',
            ];
        } elseif ( ! empty($this->element->settings->youtube_url)) {
            $video = [
                'url' => $this->element->settings->youtube_url,
                'provider' => 'youtube',
            ];
        }

        if ( ! empty($video)) {
            $return .= '<!-- wp:embed ';
            $return .= json_encode([
                'block_id' => $this->element->id,
                'url'      => $video['url'],
                'type'     => 'video',
                'responsive' => true,
                'className'  => 'wp-embed-aspect-16-9 wp-has-aspect-ratio',
                'providerNameSlug' => $video['provider'],
            ]);
            $return .= ' -->';
            $return .= '<figure class="wp-block-embed is-type-video is-provider-'.$video['provider'].' wp-block-embed-'.$video['provider'].' wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">'.$this->element->settings->youtube_url.'</div></figure>';
            $return .= '<!-- /wp:embed -->';
        }

        return $return;
    }
}