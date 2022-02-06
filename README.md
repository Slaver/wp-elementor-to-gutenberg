# Elementor to Gutenberg Convertor

A draft version of a simple plugin for conversion of Elementor elements to classic WordPress’ Gutenberg blocks.

## Requirements
* WordPress 5.6 or newer
* PHP 7.4

## Installation
1. Unpack the package
2. Upload the files to the `/wp-content/plugins/` directory
3. Run `composer install` for load vendors
4. Activate the plugin through the **Plugins** menu in WordPress and click **Activate**
5. Run conversion on the **Tools** page `/wp-admin/tools.php?page=elementor-to-gutenberg`

## Other Notes
The plugin uses [jQuery](https://developer.wordpress.org/plugins/javascript/jquery/) at the frontend for sending AJAX requests and library [htmlpurifier](https://github.com/ezyang/htmlpurifier) for filtering HTML.