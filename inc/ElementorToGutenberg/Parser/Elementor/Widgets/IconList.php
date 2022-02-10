<?php

namespace ElementorToGutenberg\Parser\Elementor\Widgets;

use ElementorToGutenberg\Parser\Elementor\Elementor;
use ElementorToGutenberg\Parser\Elementor\Settings;

class IconList extends Elementor
{
    public function run(): string
    {
        $return = '';

        if ( ! empty($this->element->settings->icon_list)) {
            $settings = new Settings\IconList($this->element);

            $return .= '<!-- wp:uagb/icon-list ';
            $return .= $settings->json();
            $return .= ' -->';
            $return .= '<div class="' . $settings->classes() . '"><div class="uagb-icon-list__wrap">';

            foreach ($this->element->settings->icon_list as $line) {
                $return .= '<!-- wp:uagb/icon-list-child ';
                $return .= json_encode([
                    'block_id' => $line->_id,
                    'label'    => strip_tags($line->text),
                    'icon'     => 'arrow-right',
                    'label_color' => '',
                    'icon_hover_color'    => '',
                    'label_hover_color'   => '',
                    'icon_bg_color'       => '',
                    'icon_bg_hover_color' => '',
                    'icon_border_color'   => '',
                    'icon_border_hover_color' => '',
                ]);
                $return .= ' -->';

                $return .= '<div class="wp-block-uagb-icon-list-child uagb-icon-list-repeater uagb-icon-list__wrapper uagb-block-'.$line->_id.'">';
                $return .= '<div class="uagb-icon-list__content-wrap">';
                $return .= '<span class="uagb-icon-list__source-wrap"><span class="uagb-icon-list__source-icon">';
                $return .= '<svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"></path></svg>';
                $return .= '</span></span>';
                $return .= '<div class="uagb-icon-list__label-wrap"><span class="uagb-icon-list__label">';
                $return .= strip_tags($line->text);
                $return .= '</span></div>';
                $return .= '</div></div>';
                $return .= '<!-- /wp:uagb/icon-list-child -->';
            }

            $return .= '</div></div>';
            $return .= '<!-- /wp:uagb/icon-list -->';
        }

        return $return;
    }
}