<?php
/**
 * Plugin Name:     Custom Jquery Version
 * Description:     Replace WordPress default Jquery version by Google hosted CDN.
 * Version:         2.0.0
 * Author:          German Pichardo
 * Text Domain:     gp
 * Domain Path:     /languages
 *
 * @package   GP\Custom_Jquery_Version
 * @link      https://github.com/german-pichardo/custom-jquery-version
 */

namespace GP\Custom_Jquery_Version;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CUSTOM_JQUERY_VERSION_DIR', plugin_dir_path( __FILE__ ) );
define( 'CUSTOM_JQUERY_VERSION_URL', plugin_dir_URL( __FILE__ ) );

// Plugin Global information.
require_once CUSTOM_JQUERY_VERSION_DIR . 'includes/class-info.php';

/**
 * Begins execution of the plugin.
 */
function run_init() {
	include_once CUSTOM_JQUERY_VERSION_DIR . 'includes/class-init.php';
	new Init();
}

run_init();
