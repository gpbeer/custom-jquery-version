<?php
/**
 * Admin
 *
 * @package GP\Custom_Jquery_Version
 */

namespace GP\Custom_Jquery_Version;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin
 */
class Admin {

	const VERSIONS  = '3.5.1, 3.5.0, 3.4.1, 3.4.0, 3.3.1, 3.2.1, 3.2.0, 3.1.1, 3.1.0, 3.0.0, 2.2.4, 2.2.3, 2.2.2, 2.2.1, 2.2.0, 2.1.4, 2.1.3, 2.1.1, 2.1.0, 2.0.3, 2.0.2, 2.0.1, 2.0.0, 1.12.4, 1.12.3, 1.12.2, 1.12.1, 1.12.0, 1.11.3, 1.11.2, 1.11.1, 1.11.0, 1.10.2, 1.10.1, 1.10.0, 1.9.1, 1.9.0, 1.8.3, 1.8.2, 1.8.1, 1.8.0, 1.7.2, 1.7.1, 1.7.0, 1.6.4, 1.6.3, 1.6.2, 1.6.1, 1.6.0, 1.5.2, 1.5.1, 1.5.0, 1.4.4, 1.4.3, 1.4.2, 1.4.1, 1.4.0, 1.3.2, 1.3.1, 1.3.0, 1.2.6, 1.2.3';
	const PAGE_NAME = 'custom-jquery-version-sections';

	/**
	 * Jquery version.
	 *
	 * @var string The version.
	 */
	protected static $version = '2.1.3';

	/**
	 * Enqueue the script in footer.
	 *
	 * @var bool In footer.
	 */
	protected static $in_footer = false;

	/**
	 * Initialize admin-related functionality.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'admin_menu', [ $this, 'add_options_page' ] );
		add_action( 'admin_init', [ $this, 'add_settings' ] );
		add_filter( 'plugin_action_links', [ $this, 'add_settings_link' ], 10, 2 );
	}

	/**
	 * Add page to theme.php menu
	 */
	public function add_options_page() {
		add_options_page(
			Info::get_plugin_title(),
			Info::get_plugin_title(),
			Info::CAPACITY,
			Info::get_plugin_slug(),
			[ $this, 'output_admin_page' ]
		);
	}

	/**
	 * Function that will display the options page.
	 */
	public function output_admin_page() { ?>
		<div class="wrap">
			<h2><?php esc_html_e( 'JQuery version control', 'gp' ); ?></h2>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'custom_jquery_version_options' );
				do_settings_sections( self::PAGE_NAME );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Add section and settings.
	 */
	public function add_settings() {
		$section_name = 'custom_jquery_version_section';

		// Register Settings.
		register_setting(
			'custom_jquery_version_options', // Option_group.
			'custom_jquery_version_settings'
		);

		// Add Section for option fields.
		add_settings_section(
			$section_name,
			'',
			'__return_false',
			self::PAGE_NAME
		);

		add_settings_field(
			'jquery_hosted_version',
			__( 'Google Hosted CDN versions', 'gp' ),
			[ $this, 'render_field_hosted_version' ],
			self::PAGE_NAME,
			$section_name
		);

		add_settings_field(
			'enqueue_script_in_footer',
			__( 'Enqueue the script in footer', 'gp' ),
			[ $this, 'render_field_in_footer' ],
			self::PAGE_NAME,
			$section_name
		);
	}

	/**
	 * Fields render
	 */
	public function render_field_hosted_version() {
		?>
		<label class="screen-reader-text" for="jquery_hosted_version"><?php echo esc_html( __( 'Google Hosted CDN versions', 'gp' ) ); ?></label>
		<select name="custom_jquery_version_settings[jquery_hosted_version]" id="jquery_hosted_version">
			<?php

			/**
			 * Jquery versions.
			 *
			 * @param array $versions Array of jquery versions.
			 */
			$options = apply_filters( 'custom_jquery_version_versions', explode( ',', (string) self::VERSIONS ) );

			foreach ( (array) $options as $option ) :
				?>
				<option value='<?php echo esc_attr( trim( $option ) ); ?>'
						<?php
						selected(
							$this->get_version(),
							trim( $option )
						);
						?>
				>
					<?php echo esc_html( trim( $option ) ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Render field is in footer.
	 */
	public function render_field_in_footer() {
		?>
		<label class="screen-reader-text" for="enqueue_script_in_footer"><?php echo esc_html( __( 'Enqueue the script in footer', 'gp' ) ); ?></label>
		<input id="enqueue_script_in_footer" type="checkbox" name="custom_jquery_version_settings[enqueue_script_in_footer]" <?php checked( $this->get_in_footer(), true ); ?> value="1">
		<?php
	}

	/**
	 * Filters the action links displayed for each plugin in the Plugins list table.
	 *
	 * @param string[] $links       An array of plugin action links.
	 * @param string   $plugin_file Path to the plugin file relative to the plugins directory.
	 *
	 * @return string[]
	 */
	public function add_settings_link( $links, $plugin_file ) {
		$this_plugin = Info::get_relative_path();

		if ( is_plugin_active( $this_plugin ) && $plugin_file === $this_plugin ) {
			$links[] = sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( add_query_arg( 'page', Info::get_plugin_slug(), admin_url( 'options-general.php' ) ) ),
				__( 'Settings', 'gp' )
			);
		}

		return $links;
	}

	/**
	 * Get the chosen and fallback version
	 *
	 * @return string
	 */
	public static function get_version() {
		if ( self::get_option( 'jquery_hosted_version' ) ) {
			self::set_version( self::get_option( 'jquery_hosted_version' ) );
		}

		return (string) self::$version;
	}

	/**
	 * Set version
	 *
	 * @param string $version The selected version.
	 */
	public static function set_version( $version ) {
		self::$version = (string) $version;
	}

	/**
	 * Check if we enqueue JQuery in footer
	 *
	 * @return bool
	 */
	public static function get_in_footer() {
		if ( self::get_option( 'enqueue_script_in_footer' ) ) {
			self::set_in_footer( true );
		}

		return (bool) self::$in_footer;
	}

	/**
	 * Set in footer
	 *
	 * @param bool $in_footer True is is in footer.
	 */
	public static function set_in_footer( $in_footer ) {
		self::$in_footer = $in_footer;
	}

	/**
	 * Retrieves option.
	 *
	 * @param string $option_name The option name.
	 *
	 * @return false|mixed
	 */
	public static function get_option( $option_name ) {
		return isset( get_option( 'custom_jquery_version_settings' )[ $option_name ] ) ? get_option( 'custom_jquery_version_settings' )[ $option_name ] : false;
	}
}
