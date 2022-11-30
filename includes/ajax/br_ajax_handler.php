<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BrAjaxhandler')) {

    class BrAjaxhandler
    {
        /**
         * Action argument used by the nonce validating the AJAX request
         * @var string
         */
        const NONCE   = 'wp_rest';
        const NS_BR_THEME = 'br-theme/v1';

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Register the AJAX handler class 
         */
        static function register()
        {
            $handler = new self();

            add_action('wp_enqueue_scripts', [$handler, 'register_script']);
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Register JavaScript files compiled by Webpack
         */
        function register_script()
        {

            if (is_front_page()) {
                wp_register_script('front', get_stylesheet_directory_uri() . '/assets/dist/js/front.js', array(), BR_THEME_VERSION);
                // wp_localize_script('front', 'wp_ajax', self::get_ajax_data());
                wp_enqueue_script('front');
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Get the AJAX data that WordPress needs to output
         * @return array
         */
        function get_ajax_data()
        {
            return array(
                'restNonce'   => wp_create_nonce(self::NONCE),
                'restUrl'     => esc_url_raw(rest_url()),
            );
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Make sure there is a valid AJAX request
         * @return bool
         */
        function nonce($data)
        {
            $headers = $data->get_headers();
            $nonce   = $headers['x_wp_nonce'][0];

            if (!wp_verify_nonce($nonce, 'wp_rest')) {
                die('Busted!');
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Pagination
         */
        function pagination($loop, $paged)
        {
            echo '<div class="pagination">';
            $big = 999999999;
            echo paginate_links(array(
                'base'        => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format'      => '?paged=%#%',
                'current'     => max(1, $paged),
                'total'       => $loop->max_num_pages,
                'prev_text'   => '',
                'next_text'   => '',
            ));
            echo '</div>';
        }
    }

    BrAjaxhandler::register();
} //class_exist check