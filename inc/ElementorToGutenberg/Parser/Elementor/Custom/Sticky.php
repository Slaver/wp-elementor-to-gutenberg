<?php

namespace ElementorToGutenberg\Parser\Elementor\Custom;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class Sticky extends Elementor
{
    private array $blockSettings = [];

    public function run(): string
    {
        $this->recursively($this->element->elements);

        $return = '<!-- wp:finixio/sticky ';
        $return .= json_encode($this->blockSettings);
        $return .= ' -->';
        $return .= '<!-- /wp:finixio/sticky -->';

        return $return;
    }

    public function recursively($element)
    {
        // Don't try to understand it!
        if ( ! empty($element->elements)) {
            $this->recursively($element->elements);
        } else {
            if (is_array($element)) {
                foreach ($element as $el) {
                    if (!empty($el->elements)) {
                        $this->recursively($el->elements);
                    } else {
                        if (!in_array($el->elType, ['section', 'column'])) {
                            if ($el->elType === 'widget') {
                                $this->parse($el);
                            }
                        }
                    }
                }
            } else {
                $this->parse($element);
            }
        }
    }

    public function parse($element)
    {
        if ( ! empty($element->widgetType)) {
            switch ($element->widgetType) {
                case 'image':
                    // Only first image with logo!
                    if ( ! empty($element->settings->image->url) && ! isset($this->blockSettings['logo'])) {
                        $this->blockSettings['logo'] = $element->settings->image->url;
                    }
                    break;
                case 'button':
                    // Only first button
                    if ( ! isset($this->blockSettings['button'])) {
                        if ( ! empty($element->settings->text)) {
                            $this->blockSettings['button']['text'] = $element->settings->text;
                        }
                        if ( ! empty($element->settings->link->url)) {
                            $this->blockSettings['button']['url'] = $element->settings->link->url;
                        }
                    }
                    break;
                case 'text-editor':
                    if ( ! empty($element->settings->editor)) {
                        $text = trim(strip_tags($element->settings->editor));
                        if ( ! in_array($text, $this->blockSettings['text'])) {
                            $this->blockSettings['text'][] = $text;
                        }
                    }
                    break;
                case 'spacer':
                    break;
                default:
                    wp_send_json_error('Unknown sticky element type: ' . $element->elType);
                    break;
            }
        }
    }
}