<?php
/**
 * Plugin Name: Custom jQuery Version
 * Description: Replace Wordpress default Jquery version par CDN or local storage.
 * Version: 1.0
 * Author: German Pichardo
 * Author URI: http://www.german-pichardo.com
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'admin/class-custom-jquery-version-admin.php'; // Admin
require_once plugin_dir_path(__FILE__) . 'front/class-custom-jquery-version-front.php'; // Front
