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
if (!class_exists(' CustomJqueryVersion')) {
    class  CustomJqueryVersion
    {
        private static $jQuery_CDN = true; // true or false if you wish to use cdn instead
        private static $jQuery_in_Footer = false; // true or false
        private static $jQuery_Version = '2.1.3'; // 2.1.3 or 1.11.2

        public function __construct()
        {
            add_action('init', array($this, 'enqueue_jquery_script'));
        }

        /**
         * Use jQuery local or CDN instead of WordPress own jQuery version
         */
        public static function enqueue_jquery_script()
        {
            if (is_admin() || in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) return; // Do not dequeue on back-end or user areas
            wp_deregister_script('jquery');
            // If CDN storage preferred
            if (true === self::$jQuery_CDN) {
                wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/' . self::$jQuery_Version . '/jquery.min.js', array(), self::$jQuery_Version, self::$jQuery_in_Footer);
            } else {
                wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/vendors/jquery-' . self::$jQuery_Version . '.min.js', array(), self::$jQuery_Version, self::$jQuery_in_Footer);
            }
            wp_enqueue_script('jquery');

        }
    }
}

$custom_jquery_version = new CustomJqueryVersion();
