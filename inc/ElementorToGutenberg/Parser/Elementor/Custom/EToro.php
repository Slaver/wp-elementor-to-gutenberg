<?php

namespace ElementorToGutenberg\Parser\Elementor\Custom;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class EToro extends Elementor
{
    private array $blockSettings = [];

    public function run(): string
    {
        $this->recursively($this->element->elements);

        $return = '<!-- wp:finixio-blocks/etoro ';
        $return .= json_encode($this->blockSettings);
        $return .= ' -->';
        $return .= '<!-- /wp:finixio-blocks/etoro -->';

        return $return;
    }

    public function recursively($element)
    {
        // Don't try to understand it!
        if (!empty($element->elements)) {
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
                case 'shortcode':
                    if ( ! empty($element->settings->shortcode)) {
                        $shortcode = shortcode_parse_atts($element->settings->shortcode);
                        // $shortcode->label = Arviomme
                        // $shortcode->info = ... -> balloon
                        if ( ! empty($shortcode->value) && ! empty($shortcode->name)) {
                            $this->blockSettings['title']  = $shortcode->name;
                            $this->blockSettings['rating'] = $shortcode->value;
                        }
                    }
                    break;
                case 'icon-list':
                    if ( ! empty($element->settings->icon_list)) {
                        foreach ($element->settings->icon_list as $item) {
                            $textParts = explode('<br>', $item->text);
                            if (count($textParts) > 1) {
                                $this->blockSettings['list'][] = [
                                    'text'  => trim(strip_tags($textParts[0])),
                                    'price' => trim(strip_tags($textParts[1])),
                                ];
                            } else {
                                $this->blockSettings['list'][]['text'] = trim(strip_tags($item->text));
                            }
                        }

                    }
                    break;
                case 'text-editor':
                    if ( ! empty($element->settings->editor)) {
                        // Hack: ignore text with 'Suosittelemme'
                        if ($element->settings->text_color !== '#FFFFFF') {
                            $this->blockSettings['text'][] = trim(strip_tags($element->settings->editor));
                        }
                    }
                    break;
                case 'spacer':
                    break;
                default:
                    wp_send_json_error('Unknown eToro element type: ' . $element->elType);
                    break;
            }
        }
    }
}