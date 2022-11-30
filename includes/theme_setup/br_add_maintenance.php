<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BrMaintenanceMode')) {
    class BrMaintenanceMode
    {
        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Static hooks 
         */
        static function register()
        {
            $handler = new self();

            add_action('admin_init', [$handler, 'maintenance_settings']);

            add_action('init', [$handler, 'wp_under_maintenance']);
        }


        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Add options checkbox to Settings / General 
         */
        function maintenance_settings()
        {
            add_settings_section(
                'my_settings_section', // Section ID 
                'ADDITIONAL SETTINGS', // Section Title
                [$this, 'my_section_options_callback'], // Content Callback
                'general' // Show under "General" settings page
            );

            add_settings_field(
                'maintenance_mode', // Option ID
                'Maintenance mode', // Option Label
                [$this, 'maintenance_mode_callback'], // Callback for Arguments 
                'general', // Show under "General" settings page
                'my_settings_section', // Name of the section
                array( // The $args to pass to the callback
                    'maintenance_mode' // Should match Option ID
                )
            );

            register_setting('general', 'maintenance_mode', 'esc_attr');
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Title
         */
        function my_section_options_callback()
        {
            // Custom Section Callback content
            echo "Custom theme options";
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Checkbox Callback
         */
        function maintenance_mode_callback($args)
        {
            $value = get_option($args[0]);

            $checked = ($value == "on") ? "checked" : "";

            echo "<label>
                  <input type=\"checkbox\" id=\"$args[0]\" name=\"$args[0]\" $checked />
                  <span>Check to activate Maintenance Mode page</span>
              </label>
              <p>A general <i>Under Maintenance</i> page will be shown to non-admin users.</p>";
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Handle Maintenance page
         */
        function wp_under_maintenance()
        {
            $isLoginPage = basename($_SERVER['PHP_SELF']) == 'wp-login.php';
            $isBrMaintenanceModeOn = get_option('maintenance_mode') == "on";

            if (
                $isBrMaintenanceModeOn &&
                !$isLoginPage &&
                !is_user_logged_in() &&
                !is_admin() &&
                !current_user_can("update_plugins")
            ) {
                get_template_part('maintenance');
                exit();
            }
        }
    } //BrMaintenanceMode

    BrMaintenanceMode::register();
}