<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

</head>


<body br-data="<?= the_ID() ?>">
    <!-- GSAP ScrollSmoother plugin wrappers -->
    <!-- <div id="smooth-wrapper"> -->
    <!-- <div id="smooth-content"> -->
    <header class="flex">
        <div class="p-1 w-fit flex items-center ">
            <?php

            $custom_logo_id = get_theme_mod('custom_logo');
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

            if (has_custom_logo()) : ?>

            <a href="<?= get_site_url() ?>">
                <img src="<?= esc_url($logo[0]) ?>" class="mr-10 w-auto min-h-[35px] h-[35px] sm:h-[45px] tab:h-[90px]"
                    alt="<?= get_bloginfo('name') ?>">
            </a>

            <?php else : ?>

            <a href="<?php get_site_url() ?>">
                <h1><?= get_bloginfo('name') ?></h1>
            </a>

            <?php endif ?>
        </div>

        <div class="h-menu flex w-fit h-fit items-center py-2.5">
            <?php
            wp_nav_menu(array(
                'menu'         => 'Header menu',
                'menu_class'   => 'uppercase flex',
                'add_li_class' => 'p-1 mx-2.5'
            )) ?>

            <?php get_template_part('template-parts/global/mobile_menu') ?>
        </div>

        </div>

    </header>