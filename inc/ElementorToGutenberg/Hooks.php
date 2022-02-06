<?php

declare(strict_types=1);

namespace ElementorToGutenberg;

class Hooks
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_enqueue_scripts', [$this, 'scripts']);
        add_action('wp_ajax_run_convert', [$this, 'run']);
        add_action('wp_ajax_next_convert', [$this, 'next']);
    }

    public function menu()
    {
        if (is_admin()) {
            add_management_page('Elementor to Gutenberg', 'Elementor to Gutenberg', 'manage_options',
                'elementor-to-gutenberg', ['ElementorToGutenberg\Admin', 'page']);
        }
    }

    public function scripts($hook)
    {
        if ('tools_page_elementor-to-gutenberg' !== $hook) {
            return;
        }

        wp_enqueue_script('e2g-scripts', ETG_URL . '/assets/js/elementor-to-gutenberg.js', ['jquery']);
        wp_enqueue_style('e2g-styles', ETG_URL . '/assets/css/elementor-to-gutenberg.css');
    }

    public function run()
    {
        (new Convertor)->run();
    }

    public function next()
    {
        (new Convertor)->next();
    }
}