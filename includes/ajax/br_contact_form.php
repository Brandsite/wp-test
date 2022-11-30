<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}


if (!class_exists('BrContactForm')) {

    class BrContactForm extends BrAjaxHandler
    {

        /**
         * Action hook used by the AJAX class
         * @var string
         */
        const ENDPOINT = 'br-contact-form';

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Register the AJAX handler class 
         */
        static function register()
        {
            $handler = new self();

            add_action('rest_api_init', array($handler, 'register_rest_api'));
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         */
        function register_rest_api()
        {

            $args = array(
                'methods'             => 'POST',
                'callback'            => array(new self(), 'handle'),
                'permission_callback' => '__return_true', //make it public
            );

            register_rest_route(self::NS_BR_THEME,  self::ENDPOINT, $args);
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Handle data from from form
         */
        function handle($data)
        {
            // make sure there is a valid AJAX request
            $this->nonce($data);

            $params = $data->get_params();

            error_log('Success!');
            //sender email
            $admin_email = get_option('admin_email');

            $send_to = get_option('admin_email');

            //email headers
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From' . $admin_email;
            $headers[] = 'Reply-to:' . $params['email'];


            //subject
            $subject = 'Sent from Hell';

            //message
            $message = '';

            //send mail
            try {
                if (wp_mail($send_to, $subject, $message, $headers)) {
                    wp_send_json_success('Success!');
                } else {
                    wp_send_json_error('Email error');
                }
            } catch (Exception $e) {
                wp_send_json_error($e->getMessage());
            }

            die();
        }
    }

    BrContactForm::register();
} //class_exist check