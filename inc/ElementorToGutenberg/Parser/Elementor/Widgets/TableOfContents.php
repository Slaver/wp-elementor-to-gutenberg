<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class TableOfContents extends Elementor {

	public function run(): string
	{
		$return = '<!-- wp:uagb/table-of-contents ';
		$return .= json_encode([
			'block_id'       => $this->element->id,
			'className'      => 'table-of-content',
			'classMigrate'   => true,
			// Generate TOC only from H2
			'mappingHeaders' => [ false, true, false, false, false, false ],
		]);
		$return .= ' /-->';

		return $return;
	}
}