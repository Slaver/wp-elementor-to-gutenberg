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
                // In real life it is neccessary
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

            case 'me-faq':
                $return = (new Widgets\FAQ($this->element))->run();
                break;

            case 'template':
                // @TODO $this->element->settings->template_id
                break;

            case 'icon-list':
                // @TODO
                break;

            default:
                wp_send_json_error('Unknown widget type: ' . $this->element->widgetType);
                break;
        }

        return $return;
    }


}