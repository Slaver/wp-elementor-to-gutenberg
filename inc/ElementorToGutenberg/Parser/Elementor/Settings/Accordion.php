<?php

namespace ElementorToGutenberg\Parser\Elementor\Settings;

use ElementorToGutenberg\Parser\Elementor\Settings;

class Accordion extends Settings
{
    public function set()
    {
        $this->additional = [
            'expandFirstItem' => true,
            'borderRadius'    => 10,
//            'schema' => '"{\u0022@context\u0022:\u0022https://schema.org\u0022,\u0022@type\u0022:\u0022FAQPage\u0022,\u0022@id\u0022:\u0022' . get_permalink() . '/\u0022,\u0022mainEntity\u0022:[
//
//            {\u0022@type\u0022:\u0022Question\u0022,\u0022name\u0022:\u0022What is FAQ?\u0022,\u0022acceptedAnswer\u0022:{\u0022@type\u0022:\u0022Answer\u0022,\u0022text\u0022:\u0022Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\u0022}},
//
//            {\u0022@type\u0022:\u0022Question\u0022,\u0022name\u0022:\u0022What is FAQ?\u0022,\u0022acceptedAnswer\u0022:{\u0022@type\u0022:\u0022Answer\u0022,\u0022text\u0022:\u0022Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\u0022}},
//
//            {\u0022@type\u0022:\u0022Question\u0022,\u0022name\u0022:\u0022What is FAQ?\u0022,\u0022acceptedAnswer\u0022:{\u0022@type\u0022:\u0022Answer\u0022,\u0022text\u0022:\u0022Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\u0022}},
//
//            {\u0022@type\u0022:\u0022Question\u0022,\u0022name\u0022:\u0022What is FAQ?\u0022,\u0022acceptedAnswer\u0022:{\u0022@type\u0022:\u0022Answer\u0022,\u0022text\u0022:\u0022Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\u0022}}
//
//            ]}"',
        ];
    }
}