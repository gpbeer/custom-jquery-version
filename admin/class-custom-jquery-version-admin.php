<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}

if (!class_exists('CustomJqueryVersionAdmin')) {
    class CustomJqueryVersionAdmin
    {

        public $in_footer;
        protected static $version = '2.1.3';

        /**
         * Plugin initialization
         */
        public function __construct()
        {
            // Add the page to the admin menu
            add_action('admin_menu', [$this, 'add_plugin_page']);
            // Register page options
            add_action('admin_init', [$this, 'admin_page_init']);
            // Add plugin settings link
            add_filter('plugin_action_links', [$this, 'add_settings_link'], 10, 2);
        }

        /**
         * Function that will add the options page under Setting Menu.
         */
        public function add_plugin_page()
        {
            // $page_title, $menu_title, $capability, $menu_slug, $callback_function
            add_options_page(
                __('Jquery version settings'), // page_title
                __('Jquery CDN version'), // menu_title
                'manage_options', // capability
                'custom-jquery-version-options', // menu_slug
                [$this, 'create_admin_page'] // function
            );
        }

        public static function getVersion()
        {
            if (isset(get_option('custom_jquery_version_settings')['jquery_hosted_version']) && !empty(get_option('custom_jquery_version_settings')['jquery_hosted_version'])) {
                self::$version = get_option('custom_jquery_version_settings')['jquery_hosted_version'];
            }

            return self::$version;
        }

        /**
         * Function that will display the options page.
         */
        public function create_admin_page()
        { ?>
            <div class="wrap">
                <h2><?php _e('JQuery version control'); ?></h2>
                <?php //settings_errors();
                ?>

                <form method="post" action="options.php">
                    <?php
                    settings_fields('custom_jquery_version_option_group');
                    do_settings_sections('custom-jquery-version-sections');
                    submit_button();
                    ?>
                </form>
            </div>
        <?php }

        public function admin_page_init()
        {
            // Register Settings
            register_setting(
                'custom_jquery_version_option_group', // option_group
                'custom_jquery_version_settings'
            );

            // Add Section for option fields
            add_settings_section(
                'section_option', // id
                '', // title
                [$this, 'section_option_callback'], // callback
                'custom-jquery-version-sections' // page
            );

            // Add Slug Field
            add_settings_field(
                'jquery_hosted_version', // id
                __('Google Hosted CDN versions'), // title
                [$this, 'jquery_hosted_version_render'], // callback
                'custom-jquery-version-sections', // page
                'section_option' // section
            );

            add_settings_field(
                'custom_jquery_version_in_footer',
                __('Enqueue the script in footer instead of head', 'custom-jquery-version'),
                [$this, 'custom_jquery_version_in_footer_render'],
                'custom-jquery-version-sections',
                'section_option'
            );
        }

        /**
         * Section slug callback
         */
        public function section_option_callback()
        {
            echo "<hr>";
        }

        /**
         * Fields render
         */
        public function jquery_hosted_version_render()
        { ?>
            <select name='custom_jquery_version_settings[jquery_hosted_version]'>
                <?php
                $options = explode(',', $this->getHostedVersions());
                foreach ($options as $option): ?>
                    <option
                        value='<?php echo trim($option); ?>'
                        <?php selected($this->getVersion(), trim($option)); ?>>
                        <?php echo 'jQuery Core ' . $option; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php }

        public function custom_jquery_version_in_footer_render()
        {
            $this->in_footer = isset(get_option('custom_jquery_version_settings')['custom_jquery_version_in_footer']) ? get_option('custom_jquery_version_settings')['custom_jquery_version_in_footer'] : 0;
            ?>
            <input type='checkbox'
                   name='custom_jquery_version_settings[custom_jquery_version_in_footer]' <?php checked($this->in_footer, 'true'); ?>
                   value='true'>
            <?php

        }

        /**
         * Google hosted versions
         */
        public function getHostedVersions()
        {
            return '3.3.1, 3.2.1, 3.2.0, 3.1.1, 3.1.0, 3.0.0, 2.2.4, 2.2.3, 2.2.2, 2.2.1, 2.2.0, 2.1.4, 2.1.3, 2.1.1, 2.1.0, 2.0.3, 2.0.2, 2.0.1, 2.0.0, 1.12.4, 1.12.3, 1.12.2, 1.12.1, 1.12.0, 1.11.3, 1.11.2, 1.11.1, 1.11.0, 1.10.2, 1.10.1, 1.10.0, 1.9.1, 1.9.0, 1.8.3, 1.8.2, 1.8.1, 1.8.0, 1.7.2, 1.7.1, 1.7.0, 1.6.4, 1.6.3, 1.6.2, 1.6.1, 1.6.0, 1.5.2, 1.5.1, 1.5.0, 1.4.4, 1.4.3, 1.4.2, 1.4.1, 1.4.0, 1.3.2, 1.3.1, 1.3.0, 1.2.6, 1.2.3';
        }

        /**
         * Functions that registers settings link on plugin description.
         */
        public function add_settings_link($links, $file)
        {
            $this_plugin = plugin_basename(__FILE__);

            if (is_plugin_active($this_plugin) && $file == $this_plugin) {
                $links[] = '<a href="' . admin_url('options-general.php?page=custom-jquery-version-options') . '">' . __('Settings', 'custom-jquery-version-text-domain') . '</a>';
            }

            return $links;

        } // end add_settings_link

    }
} // !class_exists

if (is_admin())
    $custom_jquery_version_admin = new CustomJqueryVersionAdmin();
