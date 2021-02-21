<?php
/**
 * Front
 *
 * @package GP\Custom_Jquery_Version
 */

namespace GP\Custom_Jquery_Version;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Front
 */
class Front {

	/**
	 * Initialize front-related functionality.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_jquery_script' ] );
	}

	/**
	 * Use jQuery Google hosted CDN version instead of WordPress own jQuery version.
	 */
	public function enqueue_jquery_script() {
		// Do not dequeue on admin or user areas.
		if ( is_admin() || in_array( $GLOBALS['pagenow'], [ 'wp-login.php', 'wp-register.php' ], true ) ) {
			return;
		}

		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/' . Admin::get_version() . '/jquery.min.js', [], Admin::get_version(), Admin::get_in_footer() );
		wp_enqueue_script( 'jquery' );
	}
}
