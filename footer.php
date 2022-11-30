<footer class="w-full flex flex-col between">


    <div class="w-full ">
        <?php
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

        if (has_custom_logo()) : ?>

        <a href="<?= get_site_url() ?>">
            <img src="<?= esc_url($logo[0]) ?>" class="mr-10 w-auto h-[60px] sm:h-[90px] "
                alt="<?= get_bloginfo('name') ?>">
        </a>

        <?php else : ?>

        <a href="<?php get_site_url() ?>">
            <h1><?= get_bloginfo('name') ?></h1>
        </a>

        <?php endif ?>
    </div>

    </section>


    <section class="w-full ">
    </section>


</footer>

<?php wp_footer(); ?>
<!-- GSAP ScrollSmoother plugin wrapper -->
<!-- </div> -->
<!-- </div> -->

</body>

<svg id="to-top" width="47" height="78" viewBox="0 0 47 78" fill="none"
    class="fixed right-5  bottom-5 w-[50px] h-[50px] z-[999] cursor-pointer invisible overflow-hidden">
    <path class="head" d="M25.0625 10.1263L34.2558 20.4697L15.8692 20.4697L25.0625 10.1263Z" fill="#212529"
        stroke="#212529" stroke-width="0.5" />
    <path d="M25.0625 17.0723L25.0625 67.041" stroke="#222222" stroke-width="0.5" />
    <rect x="0.9375" y="0.25" width="45.8125" height="77.5" stroke="#212529" stroke-width="0.5" />
</svg>


</html>