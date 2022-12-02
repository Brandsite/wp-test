<?php

/**
 * Exit if accessed directly----------------------------------------------------------------------------------
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * -----------------------------------------------------------------------------------------------------------
 * Define theme version
 */
define('BR_THEME_VERSION', '1.0.0');

/**
 * -----------------------------------------------------------------------------------------------------------
 * Theme text domain
 */
define('BR_THEME_TEXT_DOMAIN', wp_get_theme()->get('TextDomain'));

/**
 * -----------------------------------------------------------------------------------------------------------
 * Helpers
 */
require_once get_template_directory() . '/includes/helpers.php';

/**
 * -----------------------------------------------------------------------------------------------------------
 * Theme setup
 */
require_once get_template_directory() . '/includes/theme_setup/br_theme_setup.php';

/**
 * -----------------------------------------------------------------------------------------------------------
 * Create content for tests
 */
require_once get_template_directory() . '/includes/theme_setup/br_test_content.php';

/**
 * -----------------------------------------------------------------------------------------------------------
 * Removal of the unwanted default stuff 
 */
require_once get_template_directory() . '/includes/theme_setup/br_optimize.php';

/**
 * ----------------------------------------------------------------------------------------------------------- 
 * Blog
 */
require_once get_template_directory() . '/includes/blog/br_blog.php';

/** 
 * -----------------------------------------------------------------------------------------------------------
 * Ajax handler
 */
require_once get_template_directory() . '/includes/ajax/br_ajax_handler.php';

/**
 * ----------------------------------------------------------------------------------------------------------- 
 * Ajax contact forms
 */
require_once get_template_directory() . '/includes/ajax/br_contact_form.php';