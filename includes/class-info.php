<?php
/**
 * Plugin general Info
 *
 * @package GP\Custom_Jquery_Version
 */

namespace GP\Custom_Jquery_Version;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class containing information about the plugin.
 * Class Info
 */
class Info {

	/**
	 * The plugin slug.
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = 'custom-jquery-version';

	/**
	 * Role Capacity
	 *
	 * @var string
	 */
	const CAPACITY = 'manage_options';

	/**
	 * Plugin name in extensions
	 *
	 * @return string The plugin title
	 */
	public static function get_plugin_title() {
		return self::get_plugin_data( 'Name' );
	}

	/**
	 * Retrieves the plugin data from the main plugin file.
	 *
	 * @param string $value Header param.
	 *
	 * @return mixed
	 */
	private static function get_plugin_data( $value = 'Version' ) {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$plugin_data = get_plugin_data( self::get_path() );

		return $plugin_data[ $value ];
	}

	/**
	 * Path to the main plugin entry file
	 *
	 * @return string
	 */
	public static function get_path() {
		return CUSTOM_JQUERY_VERSION_DIR . self::get_plugin_slug() . '.php';
	}

	/**
	 * Relative path to the main plugin entry file
	 *
	 * @return string
	 */
	public static function get_relative_path() {
		return self::get_plugin_slug() . '/' . self::get_plugin_slug() . '.php';
	}

	/**
	 * Returns plugin slug custom-jquery-version
	 *
	 * @return string
	 */
	public static function get_plugin_slug() {
		return self::PLUGIN_SLUG;
	}
}
