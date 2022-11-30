<?php

/**
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('BrBlog')) {

    class BrBlog
    {
        /**
         * -------------------------------------------------------------------------------------------------------------------------------
         * @param int|string $category_id
         */
        function loop($category_id = '')
        {
            $args = array(
                'posts_per_page' => -1,
                'offset'         => 0,
                'orderby'        => 'post_date',
                'order'          => 'DESC',
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'category__in'   => $category_id
            );

            $query = new WP_Query($args);

            if (have_posts($query)) {
                while ($query->have_posts()) : $query->the_post();

                    $args1 = array(
                        'title'    => $query->post->post_name,
                        'date'     => $query->post->post_date,
                        'excerpt'  => wp_trim_words($query->post->post_content, 30),
                        'link'     => get_permalink(),
                        'image_id' => get_post_thumbnail_id($query->post->ID)
                    );

                    get_template_part('template-parts/blog/card', '', $args1);

                endwhile;
            }

            wp_reset_postdata();
        }
    }
} //class_exist check