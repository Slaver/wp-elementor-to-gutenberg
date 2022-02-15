<?php

namespace ElementorToGutenberg\Parser;

use ElementorToGutenberg\Parser\Elementor;

class Parser
{

    public function recursively($array): string
    {
        $result = '';

        if ( ! is_array($array)) {
            $array = json_decode($array);
        }
        foreach ($array as $element) {
            // Check if the element has a sign of eToro/sticky blocks
            $checkElement = json_encode($element);
            if (strpos($checkElement, 'cta_rating') !== FALSE) {
                $result .= $this->custom($element, 'etoro');
            } elseif (strpos($checkElement, 'cta-sticky-nonsticky') !== FALSE) {
                $result .= $this->custom($element, 'sticky');
            } else {
                $result .= $this->level($element);
            }
        }

        return $result;
    }

    public function level($element): string
    {
        if ( ! in_array($element->elType, ['section', 'column', 'widget'])) {
            wp_send_json_error('Unknown element type: ' . $element->elType);
        }

        $return  = '';
        $section = new Elementor\Blocks\Section($element);
        $column  = new Elementor\Blocks\Column($element);
        $widget  = new Elementor\Blocks\Widget($element);

        $sectionNotEmpty = true;
        $hasColumns = (!empty($element->elements[0]) && $element->elements[0]->elType === 'column');

        if (count($element->elements) === 1 && empty($element->elements[0]->elements) && $element->elements[0]->elType === 'column') {
            $sectionNotEmpty = false;
        }

        if ($element->elType === 'section' && $sectionNotEmpty) {
            $return .= $section->open($hasColumns);
        }

        if ($element->elType === 'column') {
            $return .= $column->open();
        }

        if ( ! empty($element->elements) && $sectionNotEmpty) {
            $return .= $this->recursively($element->elements);
        }

        if ($element->elType === 'widget') {
            $return .= $widget->run();
        }

        if ($element->elType === 'column') {
            $return .= $column->close();
        }

        if ($element->elType === 'section' && $sectionNotEmpty) {
            $return .= $section->close($hasColumns);
        }

        return $return;
    }

    public function custom($element, $type): string
    {
        $return  = '';

        switch ($type) {
            case 'etoro':
                $block = new Elementor\Custom\EToro($element);
                break;
            case 'sticky':
                $block = new Elementor\Custom\Sticky($element);
                break;
        }

        if ( ! empty($block)) {
            $return = $block->run();
        }

        return $return;
    }

}