<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BrThemeSetup')) {

    class BrThemeSetup
    {
        /**
         * Theme settings
         * @var array
         */
        protected $settings;

        /**
         * Default settings
         * @var array
         */
        protected $defaults = array(
            'menu'          => array(),
            'post_formats'  => array(),
            'image_size'    => array(),
            'logo'          => array(
                'height'      => 200,
                'width'       => 200,
                'flex-height' => true,
                'flex-width'  => true,
            ),
            'jQuery'        => false,
            'session'       => false,
            'default_post'  => false,
            'css_path'      => '/assets/dist/css/app.css'
        );


        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Constructor
         */
        function __construct($args = array())
        {
            if (empty($args)) {
                return;
            }

            //Merge default settings with arguments
            $this->settings = wp_parse_args($args, $this->defaults);
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Hooks
         */
        function hooks()
        {
            add_action('after_setup_theme', [$this, 'setup']);

            add_action('wp_enqueue_scripts', [$this, 'styles']);

            add_action('acf/init', [$this, 'options_page']);

            add_filter('upload_mimes', [$this, 'svg_mime_type']);

            add_filter('admin_footer_text', [$this, 'footer_admin']);

            add_filter('nav_menu_css_class', [$this, 'nav_li_class'], 1, 3);

            add_filter('woocommerce_enqueue_styles', '__return_empty_array');

            add_filter('max_srcset_image_width', [$this, 'custom_max_srcset_image_width'], 10, 2);
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         */
        function custom_max_srcset_image_width($max_width, $size_array)
        {
            $width = $size_array[0];

            if ($width > 800) {
                $max_width = 2048;
            }

            return $max_width;
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * After_theme_setup hook
         */
        function setup()
        {
            load_theme_textdomain(BR_THEME_TEXT_DOMAIN, get_template_directory() . '/languages');

            //Register menus
            register_nav_menus($this->settings['menu']);

            //Support post-formats
            add_theme_support(
                'post-formats',
                $this->settings['post_formats']
            );

            //Add image sizes
            foreach ($this->settings['image_size'] as $size => $values) {
                $values_array = explode(',', $values);

                add_image_size($size, $values_array[0], $values_array[1]);
            }

            //Add custom logo, and skip cropping feature
            remove_theme_support('custom-logo');
            add_theme_support('custom-logo', $this->settings['logo']);

            add_theme_support('title-tag');

            // add_theme_support('woocommerce');
            // remove_theme_support('wc-product-gallery-lightbox');
            // remove_theme_support('wc-product-gallery-zoom');
        }


        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Enqueue CSS
         * JS is enqueued in BrAjaxHandler class
         */
        function styles()
        {
            //Theme CSS
            wp_register_style('app', get_template_directory_uri() . $this->settings['css_path'], [], BR_THEME_VERSION, 'all');
            wp_enqueue_style('app');

            // wp_dequeue_style('wc-blocks-style');

            //remove jQuery
            if (!$this->settings['jQuery']) {
                wp_deregister_script('jquery');
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Add SVG support
         */
        function svg_mime_type($mimes = array())
        {
            $mimes['svg']  = 'image/svg+xml';
            $mimes['svgz'] = 'image/svg+xml';
            return $mimes;
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Add a class to nav menu list item 
         */
        function nav_li_class($classes, $item, $args)
        {
            if (isset($args->add_li_class)) {
                $classes[] = $args->add_li_class;
            }
            return $classes;
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Add signiture to admin footer
         */
        function footer_admin()
        {

            echo '<span id="footer-thankyou">' . __('Developed by ', BR_THEME_TEXT_DOMAIN) . '<a href="https://www.brandsite.lv" target="_blank" rel="nofollow">Brandsite.lv</a></span>';
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Add options pages useing ACF API
         */
        function options_page()
        {
            // if (function_exists('acf_add_options_page')) {

            //     $option_page = acf_add_options_page(array(
            //         'page_title'    => __('Tēmas Iestatījumi', BR_THEME_TEXT_DOMAIN),
            //         'menu_title'    => __('Tēmas iestatījumi', BR_THEME_TEXT_DOMAIN),
            //         'menu_slug'     => 'theme-settings',
            //         'capability'    => 'edit_posts',
            //         'redirect'      => false
            //     ));

            //     $footer = acf_add_options_sub_page(array(
            //         'page_title'  => __('Kājene', BR_THEME_TEXT_DOMAIN),
            //         'menu_title'  => __('Kājene', BR_THEME_TEXT_DOMAIN),
            //         'parent_slug' => $option_page['menu_slug'],
            //     ));
            // }
        }
    } //BrThemeSetup


    $hispana_theme = new BrThemeSetup(array(
        'menu' => array(
            'menu_1' => 'Header menu',
            'menu_2' => 'Footer menu 1',
            'menu_3' => 'Footer menu 2',
            'menu_4' => 'Footer menu 3'
        ),
        'post_formats' => array(
            'link',
            'aside',
            'gallery',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat',
        ),
        'image_size' => array(
            'thumb'           => '300, 300',
            'thumb-big'       => '500, 600',
            'thumb-small'     => '100, 100',
        ),
        'jQuery' => true,
    ));

    $hispana_theme->hooks();
}