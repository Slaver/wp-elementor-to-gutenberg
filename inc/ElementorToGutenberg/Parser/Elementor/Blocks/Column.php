<?php

namespace ElementorToGutenberg\Parser\Elementor\Blocks;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class Column extends Elementor {

	public function open(): string
	{
        $settings = new Settings\Column($this->element);
        $classes = $settings->classes();
        $style = $settings->css();

		$return = '<!-- wp:column ';
        $return .= $settings->json();
		$return .= ' -->';
		$return .= '<div ';
        if (!empty($classes)) {
            $return .= ' class="'.$classes.'"';
        }
        if (!empty($style)) {
            $return .= ' style="'.$style.'"';
        }
        $return .= '>';

		return $return;
	}

	public function close(): string
	{
		return '</div><!-- /wp:column -->';
	}

}