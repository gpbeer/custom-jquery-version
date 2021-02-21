<?php
/**
 * Plugin init to include dependencies and register classes
 *
 * @package GP\Custom_Jquery_Version
 */

namespace GP\Custom_Jquery_Version;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Init
 */
class Init {
	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->register();
	}

	/**
	 * Load all dependencies
	 */
	private function load_dependencies() {
		$plugin_dir = CUSTOM_JQUERY_VERSION_DIR;

		include_once $plugin_dir . 'includes/class-i18n.php';
		include_once $plugin_dir . 'includes/class-admin.php';
		include_once $plugin_dir . 'includes/class-front.php';
	}

	/**
	 * Register all necessary hooks.
	 */
	private function register() {
		$translator = new I18n();
		add_action( 'plugins_loaded', array( $translator, 'load_plugin_textdomain' ) );

		$admin = new Admin();
		add_action( 'init', array( $admin, 'init' ) );

		$front = new Front();
		add_action( 'init', array( $front, 'init' ) );
	}
}
