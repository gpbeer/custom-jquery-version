<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}
if (!class_exists(' CustomJqueryVersionFront')) {
    class CustomJqueryVersionFront
    {
        public function __construct()
        {
            add_action('init', [$this, 'enqueue_jquery_script']);
        }

        /**
         * Use jQuery Google hosted CDN version instead of WordPress own jQuery version
         */
        public function enqueue_jquery_script()
        {
            if (is_admin() || in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'])) return; // Do not dequeue on back-end or user areas
            wp_deregister_script('jquery');
            // CDN
            wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/' . CustomJqueryVersionAdmin::getVersion() . '/jquery.min.js', [], NULL, CustomJqueryVersionAdmin::inFooter());
            wp_enqueue_script('jquery');

        }
    }
}

$custom_jquery_version_front = new CustomJqueryVersionFront();
