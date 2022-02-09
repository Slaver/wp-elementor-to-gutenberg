<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Parser;
use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Models;

class Template extends Elementor
{
    public function run(): string
    {
        $templateId = (!empty($this->element->settings->template_id)
            ? $this->element->settings->template_id
            : (!empty($this->element->templateID)
                ? $this->element->templateID
                : false)
        );

        if ($templateId) {
            $template = (new Models\Posts())->post($templateId);
            return (new Parser())->recursively($template->elementor);
        }
    }
}