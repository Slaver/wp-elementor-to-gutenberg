<?php

namespace ElementorToGutenberg;

class Models
{
    protected $wpdb = false;

    public function __construct()
    {
        global $wpdb;

        if (is_object($wpdb)) {
            $this->wpdb = $wpdb;
        }
    }
}