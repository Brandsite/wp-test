<?php get_header();
$blog = new BrBlog();
?>

<section>

    <h1><?= __('Blogs', BR_THEME_TEXT_DOMAIN) ?></h1>

    <?php get_template_part('template-parts/blog/nav_menu') ?>

    <ul>
        <?php $blog->loop() ?>
    </ul>

</section>

<?php get_footer() ?>