<?php

namespace ElementorToGutenberg;

class Options
{

    const CONVERTOR_OPTIONS_FIELD = 'elementor_to_gutenberg';

    public function get($option = '')
    {
        $exists = get_option(self::CONVERTOR_OPTIONS_FIELD);

        if ($exists && ! empty($option) && ! empty($exists[$option])) {
            return $exists[$option];
        }
    }

    public function add(array $options)
    {
        $exists = get_option(self::CONVERTOR_OPTIONS_FIELD);

        if ( ! $exists) {
            add_option(self::CONVERTOR_OPTIONS_FIELD, $options);
        } else {
            update_option(self::CONVERTOR_OPTIONS_FIELD, array_merge($exists, $options));
        }
    }
}