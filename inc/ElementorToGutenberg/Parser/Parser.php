<?php

namespace ElementorToGutenberg\Parser;

use ElementorToGutenberg\Parser\Elementor;

class Parser {

	public function recursively($array): string
	{
		$result = '';

		if (!is_array($array)) {
			$array = json_decode($array);
		}
		foreach ($array as $element) {
			$result .= $this->level($element);
		}
		return $result;
	}

	public function level($element): string
	{
		$return = '';

		$section = new Elementor\Blocks\Section($element);
		$column = new Elementor\Blocks\Column($element);
		$widget = new Elementor\Blocks\Widget($element);

		if (!in_array($element->elType, ['section', 'column', 'widget'])) {
            wp_send_json_error('Unknown element type: '.$element->elType);
        }

		if ($element->elType === 'section') {
			$return .= $section->open();
		}

		if ($element->elType === 'column') {
			$return .= $column->open();
		}

		if ($element->elType === 'widget') {
			$return .= $widget->run();
		}

		if (!empty($element->elements)) {
			$return .= $this->recursively($element->elements);
		}

		if ($element->elType === 'column') {
			$return .= $column->close();
		}

		if ($element->elType === 'section') {
			$return .= $section->close();
		}

		return $return;
	}


}