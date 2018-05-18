<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}
if (!class_exists(' CustomJqueryVersionFront')) {
    class CustomJqueryVersionFront
    {
        public $version, $in_footer;
        private static $version_fallback = '2.1.3'; // 2.1.3 or 1.11.2

        public function __construct()
        {
            add_action('init', [$this, 'enqueue_jquery_script']);
        }

        /**
         * Use jQuery Google hosted CDN version instead of WordPress own jQuery version
         */
        public function enqueue_jquery_script()
        {
            $this->version = (isset(get_option('custom_jquery_version_settings')['jquery_hosted_version']) && !empty(get_option('custom_jquery_version_settings')['jquery_hosted_version'])) ? get_option('custom_jquery_version_settings')['jquery_hosted_version'] : self::$version_fallback;
            $this->in_footer = isset(get_option('custom_jquery_version_settings')['custom_jquery_version_in_footer']) ? get_option('custom_jquery_version_settings')['custom_jquery_version_in_footer'] : false;

            if (is_admin() || in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'])) return; // Do not dequeue on back-end or user areas
            wp_deregister_script('jquery');
            // CDN
            wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/' . $this->version . '/jquery.min.js', [], NULL, $this->in_footer);
            wp_enqueue_script('jquery');

        }
    }
}

$custom_jquery_version_front = new CustomJqueryVersionFront();
