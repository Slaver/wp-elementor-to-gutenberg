<?php
/*
Plugin Name: Elementor to Gutenberg Convertor
Text Domain: elementor-go-gutenberg
Description: Convert Elementor elements to Gutenberg blocks
Author: Viacheslav Radionov
Author URI: https://github.com/Slaver
Version: 0.1
*/

// Exit
defined('ABSPATH') or die();

define('ETG_DIR', plugin_dir_path(__FILE__));
define('ETG_URL', plugins_url('', __FILE__));

// Get version of plugin for specifying js/css version number
$plugin_data = get_file_data(__FILE__, ['Version' => 'Version']);
define('ETG_VERSION', $plugin_data['Version']);

require __DIR__ . '/autoload.php';

new ElementorToGutenberg\Hooks();