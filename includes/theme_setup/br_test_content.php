<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BrTestContent')) {

    class BrTestContent
    {
        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Hooks
         */
        static function register()
        {
            add_action('after_switch_theme', [new self(), 'init']);
        }


        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         */
        function init()
        {
            if (!get_option('wp_tests_activated')) {

                $this->remove_content();

                $this->create_page('Blogs');

                $this->create_post('Posta nosaukums', $this->upload_image(get_template_directory_uri() . '/assets/images/blog/blog-mushrooms.jpg'));
                $this->create_post('Posta nosaukums1', $this->upload_image(get_template_directory_uri() . '/assets/images/blog/blog-jellyfish.jpg'));
                $this->create_post('Posta nosaukums2', $this->upload_image(get_template_directory_uri() . '/assets/images/blog/blog-city.jpg'));
                $this->create_post('Posta nosaukums3', $this->upload_image(get_template_directory_uri() . '/assets/images/blog/blog-spruce.jpg'));

                $this->create_nav_menu();

                set_theme_mod('custom_logo', $this->upload_image(get_template_directory_uri() . '/assets/dist/css/images/brandsite_logo.svg'));


                add_option('wp_tests_activated', true);
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * @param string $image_url
         * @return int image id
         */
        function upload_image($image_url)
        {
            $upload_dir = wp_upload_dir();

            $image_data = file_get_contents($image_url);

            $filename = basename($image_url);

            if (wp_mkdir_p($upload_dir['path'])) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }

            file_put_contents($file, $image_data);

            $wp_filetype = wp_check_filetype($filename, null);

            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $file);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);

            return $attach_id;
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Create an populate nav menu with all the published pages
         * @param string $title
         */
        function create_nav_menu()
        {
            $menu_exists = wp_get_nav_menu_object('Header menu');

            $pages = new WP_Query(array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_status'    => 'publish'
            ));

            if ($pages->have_posts() && !$menu_exists) {

                $menu_id = wp_create_nav_menu('Header menu');

                while ($pages->have_posts()) : $pages->the_post();

                    // Set up default BuddyPress links and add them to the menu.
                    wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  $pages->post->post_title,
                        'menu-item-url' => get_permalink($pages->post->ID),
                        'menu-item-status' => 'publish'
                    ));

                endwhile;
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Create page
         * @param string $title
         */
        function create_page($title)
        {
            $page_exist = get_page_by_title($title, 'OBJECT', 'page');

            // Check if the page already exists
            if (empty($page_exist)) {
                wp_insert_post(
                    array(
                        'comment_status' => 'close',
                        'ping_status'    => 'close',
                        'post_author'    => 1,
                        'post_title'     => ucwords($title),
                        'post_name'      => strtolower(str_replace(' ', '-', trim($title))),
                        'post_status'    => 'publish',
                        'post_content'   => '',
                        'post_type'      => 'page',
                    )
                );
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Create post
         * @param string $title 
         * @param int|string $image_id feateured image id
         */
        function create_post($title, $image_id)
        {
            require_once(ABSPATH . 'wp-admin/includes/post.php');
            $post_exist = post_exists($title);

            // Check if the page already exists
            if (empty($post_exist)) {

                $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sodales mollis orci. Mauris vitae nibh ac leo aliquet vehicula. Aenean tristique elit nulla, ut vestibulum arcu tincidunt eu. Praesent a massa lectus. Vivamus condimentum mi nec risus consectetur maximus. Vestibulum pulvinar pellentesque tellus, ut scelerisque justo aliquet vel. Sed at ex fringilla, pulvinar nibh ac, pharetra felis. Quisque turpis nibh, elementum vel tristique eget, blandit quis ipsum. Proin vitae dolor blandit leo laoreet ornare ac sit amet enim. Duis a nisl commodo, pulvinar massa eget, tristique velit. In tristique commodo lectus nec tempus. Mauris id dolor quis nisi luctus sollicitudin sit amet vel lorem.
                Curabitur et mauris in dui aliquet ultrices. Mauris dapibus eros iaculis ante porttitor varius. Mauris lorem leo, molestie sed iaculis sit amet, rhoncus quis orci. Duis posuere mauris urna, et molestie dui volutpat id. Maecenas sagittis faucibus augue quis congue. Integer semper est vitae dolor accumsan, ut dignissim orci imperdiet. Ut at feugiat est, sed gravida eros. Phasellus in nunc finibus, convallis orci sed, scelerisque mi. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut sed rutrum ipsum. Etiam consequat eu diam ac luctus. Maecenas accumsan, sapien eu mollis accumsan, nisi sapien elementum dui, et iaculis nisi nisl ac est. Aenean a sodales velit.';

                $post_id = wp_insert_post(
                    array(
                        'comment_status' => 'close',
                        'ping_status'    => 'close',
                        'post_author'    => 1,
                        'post_title'     => ucwords($title),
                        'post_name'      => strtolower(str_replace(' ', '-', trim($title))),
                        'post_status'    => 'publish',
                        'post_content'   => $content,
                        'post_type'      => 'post',
                    )
                );

                set_post_thumbnail($post_id, $image_id);
            }
        }

        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * Remove all content on first theme activization
         */
        function remove_content()
        {
            //move pages to trash
            $pages = new WP_Query(array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_status'    => array('publish', 'trash')
            ));

            if ($pages->have_posts()) {
                while ($pages->have_posts()) : $pages->the_post();
                    wp_delete_post($pages->post->ID, true);
                endwhile;
            }


            //move posts to trash
            $posts = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'post_status'    => array('publish', 'trash')
            ));

            if ($posts->have_posts()) {
                while ($posts->have_posts()) : $posts->the_post();
                    wp_delete_post($posts->post->ID, true);
                endwhile;
            }
        }
    }
    BrTestContent::register();
}