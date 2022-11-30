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
        <div class="pl-5 w-fit flex items-center pt-2.5">
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
                'menu_class'   => 'uppercase hidden header:flex',
                'add_li_class' => 'p-1 m-2.5',
            )) ?>

            <svg id="nav-burger" class="flex header:hidden w-[45px] z-[999] cursor-pointer" x="0px" y="0px"
                viewBox="-280 396 50 12.1" xml:space="preserve" class="w-[45px] cursor-pointer h-img">
                <line style="fill: none; stroke: #000" class="st0" x1="-230.3" y1="396.5" x2="-279.7" y2="396.5" />
                <line style="fill: none; stroke: #000" class="st0" x1="-230.3" y1="407.5" x2="-279.7" y2="407.5" />
            </svg>

            <?php get_template_part('template-parts/global/mobile_menu') ?>
        </div>

        </div>

    </header>