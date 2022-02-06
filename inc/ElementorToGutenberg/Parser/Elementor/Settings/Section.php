<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Section extends Settings
{
    public function set()
    {
        $this->settings = [
            'padding-top' => (!empty($this->element->settings->_padding->top)) ? (int)$this->element->settings->_padding->top : null,
            'padding-right' => (!empty($this->element->settings->_padding->right)) ? (int)$this->element->settings->_padding->right : null,
            'padding-bottom' => (!empty($this->element->settings->_padding->bottom)) ? (int)$this->element->settings->_padding->bottom : null,
            'padding-left' => (!empty($this->element->settings->_padding->left)) ? (int)$this->element->settings->_padding->left : null,
            'margin-top' => (!empty($this->element->settings->_margin->top)) ? (int)$this->element->settings->_margin->top : null,
            'margin-right' => (!empty($this->element->settings->_margin->right)) ? (int)$this->element->settings->_margin->right : null,
            'margin-bottom' => (!empty($this->element->settings->_margin->bottom)) ? (int)$this->element->settings->_margin->bottom : null,
            'margin-left' => (!empty($this->element->settings->_margin->left)) ? (int)$this->element->settings->_margin->left : null,
            'background-color' => (!empty($this->element->settings->_background_color)) ? $this->element->settings->_background_color : null,
            'width' => (!empty($this->element->settings->width)) ? $this->element->settings->width : 1140,
        ];

        $this->replace = [
            'padding-top' => 'topPadding',
            'padding-right' => 'rightPadding',
            'padding-bottom' => 'bottomPadding',
            'padding-left' => 'leftPadding',
            'margin-top' => 'topMargin',
            'margin-right' => 'rightMargin',
            'margin-bottom' => 'bottomMargin',
            'margin-left' => 'leftMargin',
            'background-color' => 'backgroundColor',
            'width' => 'width',
        ];

        $bgClass = (!empty($this->element->settings->_background_color)
                ? 'uagb-section__background-color'
                : 'uagb-section__background-undefined'
            ) . ' section-inner-wrap';

        $this->additional = [
            'classMigrate' => true,
            'className' => $bgClass,
            'backgroundType' => (!empty($this->element->settings->_background_color)) ? 'color' : null,
        ];

        $this->classes = [
            $bgClass,
            'uagb-block-'. $this->element->id,
        ];
    }
}