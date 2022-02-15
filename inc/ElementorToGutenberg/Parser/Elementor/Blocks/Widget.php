<?php

namespace ElementorToGutenberg\Parser\Elementor\Blocks;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Widgets;

class Widget extends Elementor
{

    public function run(): string
    {
        $return = '';

        switch ($this->element->widgetType) {
            case 'spacer':
                // In real life it is neccessary, too much paddings
                //$return = (new Widgets\Spacer($this->element))->run();
                break;

            case 'heading':
                $return = (new Widgets\Heading($this->element))->run();
                break;

            case 'text-editor':
                $return = (new Widgets\Text($this->element))->run();
                break;

            case 'shortcode':
                $return = (new Widgets\Shortcode($this->element))->run();
                break;

            case 'image':
                $return = (new Widgets\Image($this->element))->run();
                break;

            case 'button':
                $return = (new Widgets\Button($this->element))->run();
                break;

            case 'me-toc':
                $return = (new Widgets\TableOfContents($this->element))->run();
                break;

            case 'me-table':
                $return = (new Widgets\Table($this->element))->run();
                break;

            case 'me-faq':
                $return = (new Widgets\FAQ($this->element))->run();
                break;

            case 'template':
            case 'global':
                $return = (new Widgets\Template($this->element))->run();
                break;

            case 'icon-list':
                $return = (new Widgets\IconList($this->element))->run();
                break;

            case 'video':
                $return = (new Widgets\Video($this->element))->run();
                break;

            default:
                // me-banner, me-posts - are not for posts
                $currentPostId = wp_cache_get('converter_postId');
                wp_send_json_error('Unknown widget type: ' . $this->element->widgetType . ' in post ID #<a href="/wp-admin/post.php?post='.$currentPostId.'&action=edit">' . $currentPostId . '</a>');
                break;
        }

        return $return;
    }


}