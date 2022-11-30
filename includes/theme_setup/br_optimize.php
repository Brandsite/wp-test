<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BrOptimizeTheme')) {

    class BrOptimizeTheme
    {
        /**
         * Optimization settings
         * @var array
         */
        protected $settings;

        /**
         * Default settings
         * @var array
         */
        protected $defaults = array(
            'emoji'                 => false,
            'oembed'                => false,
            'jQuery_migrate'        => false,
            'new_content_admin_bar' => false,
            'archive_admin_bar'     => false,
            'editor_page'           => false,
            'comments_admin_menu'   => false,
            'comments_admin_bar'    => false,
            'comment_support_page'  => false
        );

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Merge default settings with arguments
         */
        function __construct($args = array())
        {

            $this->settings = wp_parse_args($args, $this->defaults);
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Hooks
         */
        function hooks()
        {
            add_action('init', [$this, 'remove_oembed'], 9999);

            add_action('wp_default_scripts', [$this, 'dequeue_jquery_migrate']);

            add_action('admin_menu', [$this, 'remove_coments_from_admin_menu']);

            add_action('init', [$this, 'remove_comment_support']);

            add_action('wp_before_admin_bar_render', [$this, 'remove_stuff_from_admin_bar']);

            add_action('init', [$this, 'remove_editor_from_page']);

            add_action('wp_enqueue_scripts', [$this, 'remove_gutenberg_css']);

            add_filter('wp_headers', [$this, 'disable_x_pingback']);

            add_filter('clean_url', [$this, 'defer_javascript'], 11, 1);

            add_filter('oembed_result', [$this, 'defer_video_src_to_data'], 99, 3);

            add_filter('embed_oembed_html', [$this, 'defer_video_src_to_data'], 99, 3);

            $this->remove_wp_emoji();

            $this->remove_gutenberg();

            $this->remove_unwanted_stuff();
        }


        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Defer loading of videos
         */
        function defer_video_src_to_data($data, $url, $args)
        {
            $data = preg_replace('/(src="([^\"\']+)")/', 'src="" data-src-defer="$2"', $data);
            return $data;
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove WordPress emoji
         */
        function remove_wp_emoji()
        {
            if ($this->settings['emoji'] === false) {
                remove_action('wp_head', 'print_emoji_detection_script', 7);
                remove_action('wp_print_styles', 'print_emoji_styles');

                remove_action('admin_print_scripts', 'print_emoji_detection_script');
                remove_action('admin_print_styles', 'print_emoji_styles');
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove unwanted stuff
         */
        private function remove_unwanted_stuff()
        {
            add_filter('xmlrpc_enabled', '__return_false');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'rsd_link');
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Defer JS
         */
        function disable_x_pingback($headers)
        {
            unset($headers['X-Pingback']);

            return $headers;
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove oembed
         */
        function remove_oembed()
        {
            if ($this->settings['oembed'] === false) {

                // Remove the REST API endpoint.
                remove_action('rest_api_init', 'wp_oembed_register_route');

                // Turn off oEmbed auto discovery.
                add_filter('embed_oembed_discover', '__return_false');

                // Don't filter oEmbed results.
                remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

                // Remove oEmbed discovery links.
                remove_action('wp_head', 'wp_oembed_add_discovery_links');

                // Remove oEmbed-specific JavaScript from the front-end and back-end.
                remove_action('wp_head', 'wp_oembed_add_host_js');
                add_filter('tiny_mce_plugins', [$this, 'disable_embeds_tiny_mce_plugin']);

                // Remove all embeds rewrite rules.
                add_filter('rewrite_rules_array', [$this, 'disable_embeds_rewrites']);

                // Remove filter of the oEmbed result before any HTTP requests are made.
                remove_filter('pre_oembed_result', 'wp_filter_pre_oembed_result', 10);
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Disable embed tinyMCE
         */
        function disable_embeds_tiny_mce_plugin($plugins)
        {
            return array_diff($plugins, array('wpembed'));
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Disable embed rewrites
         */
        function disable_embeds_rewrites($rules)
        {
            foreach ($rules as $rule => $rewrite) {
                if (false !== strpos($rewrite, 'embed=true')) {
                    unset($rules[$rule]);
                }
            }
            return $rules;
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove jQuery-migrate from frontend
         */
        function dequeue_jquery_migrate($scripts)
        {
            if ($this->settings['jQuery_migrate'] === false) {

                if (!is_admin() && !empty($scripts->registered['jquery'])) {
                    $scripts->registered['jquery']->deps = array_diff(
                        $scripts->registered['jquery']->deps,
                        ['jquery-migrate']
                    );
                }
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove comments from admin menu
         */
        function remove_coments_from_admin_menu()
        {
            if ($this->settings['comments_admin_menu'] === false) {

                remove_menu_page('edit-comments.php');
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove comments from post and pages 
         */
        function remove_comment_support()
        {
            if ($this->settings['comment_support_post'] === false) {
                remove_post_type_support('post', 'comments');
            }

            if ($this->settings['comment_support_page'] === false) {
                remove_post_type_support('page', 'comments');
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove stuff from admin bar
         */
        function remove_stuff_from_admin_bar()
        {
            global $wp_admin_bar;
            if ($this->settings['comments_admin_bar'] === false) {
                $wp_admin_bar->remove_menu('comments');
            }

            if ($this->settings['new_content_admin_bar'] == false) {
                $wp_admin_bar->remove_menu('new-content');
            }

            if ($this->settings['archive_admin_bar'] === false) {
                $wp_admin_bar->remove_menu('archive');
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove editor from pages
         * */
        function remove_editor_from_page()
        {
            if ($this->settings['editor_page'] === false) {
                remove_post_type_support('page', 'editor');

                remove_action('shutdown', 'wp_ob_end_flush_all', 1);
                add_action('shutdown', function () {
                    while (@ob_end_flush());
                });
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove Gutenberg
         */
        private function remove_gutenberg()
        {
            add_filter('use_block_editor_for_post', '__return_false', 10);
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove Gutenbrg CSS
         */
        function remove_gutenberg_css()
        {
            wp_dequeue_style('wp-block-library');
            wp_dequeue_style('wp-block-library-theme');
            // wp_dequeue_style('wc-block-style'); // REMOVE WOOCOMMERCE BLOCK CSS
            wp_dequeue_style('global-styles'); // REMOVE THEME.JSON
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Defer JS
         */
        function defer_javascript($url)
        {
            if (
                is_admin() === true
                // || is_checkout() 
                // || is_cart()
                //  || is_single('davanu-karte')
            ) return $url;
            if (FALSE === strpos($url, '.js')) return $url;
            if (strpos($url, 'jquery.min.js')) return $url;
            if (strpos($url, 'cdn-cookieyes')) return $url;
            // if (strpos($url, 'woocommerce-ultimate-gift-card-product-single.js')) return $url;
            return "$url' defer ";
        }
    } //BrOptimizeTheme

    $optimize = new BrOptimizeTheme(array(
        'comment_support_post' => false,
    ));

    $optimize->hooks();
}