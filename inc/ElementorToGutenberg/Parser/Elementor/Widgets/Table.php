<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;

class Table extends Elementor
{
    public function run(): string
    {
        $return = '<!-- wp:table ';
        $return .= json_encode([
            'block_id'  => $this->element->id,
            'className' => 'me-table',
        ]);
        $return .= ' -->';
        $return .= '<figure class="wp-block-table me-table"><table>';

        $countCells = 0;
        if (!empty($this->element->settings->table_header)) {
            $countCells = count($this->element->settings->table_header);
            $return .= '<thead>';
            $return .= '<tr>';
            foreach ($this->element->settings->table_header as $cell) {
                $return .= '<th>'.$cell->title.'</th>';
            }
            $return .= '</tr>';
            $return .= '</thead>';
        }
        if (!empty($this->element->settings->table_body)) {
            $return .= '<tbody>';
            // or use $this->element->settings->table_body[$i]['new_row']
            $splitBody = array_chunk($this->element->settings->table_body, $countCells);
            foreach ($splitBody as $body) {
                $return .= '<tr>';
                foreach ($body as $cell) {
                    $return .= '<td>'.$cell->title.'</td>';
                }
                $return .= '</tr>';
            }
            $return .= '</tbody>';
        }

        $return .= '</table></figure>';
        $return .= '<!-- /wp:table -->';

        return $return;
    }
}