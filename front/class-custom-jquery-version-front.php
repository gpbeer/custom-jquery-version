<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}
if (!class_exists(' CustomJqueryVersionFront')) {
    class CustomJqueryVersionFront
    {
        protected static $version, $in_footer;

        public function __construct()
        {
            add_action('init', [$this, 'enqueue_jquery_script']);
            self::$version = CustomJqueryVersionAdmin::getVersion();
            self::$in_footer = isset(get_option('custom_jquery_version_settings')['custom_jquery_version_in_footer']) ? get_option('custom_jquery_version_settings')['custom_jquery_version_in_footer'] : false;
        }

        /**
         * Use jQuery Google hosted CDN version instead of WordPress own jQuery version
         */
        public function enqueue_jquery_script()
        {

            if (is_admin() || in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'])) return; // Do not dequeue on back-end or user areas
            wp_deregister_script('jquery');
            // CDN
            wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/' . CustomJqueryVersionAdmin::getVersion() . '/jquery.min.js', [], NULL, $this->in_footer);
            wp_enqueue_script('jquery');

        }
    }
}

$custom_jquery_version_front = new CustomJqueryVersionFront();
