<li class="blog-card w-full sm:w-blog-card relative">

    <a href="<?= $args['link'] ?>" class="w-full h-fit flex flex-col">
        <img src="<?= wp_get_attachment_image_src($args['image_id'], "full")[0] ?>"
            alt="<?= get_post_meta($args['image_id'], '_wp_attachment_image_alt', TRUE) ?>"
            class="w-full h-full object-cover relative">

        <div class="flex w-full flex-col">
            <p class="capitalize"><?= date_i18n('F  j Y', $args['date']) ?></p>
            <h2 class="text-xl"><?= ucfirst($args['title']) ?></h2>
            <p class="py-2.5 sm:py-5"><?= $args['excerpt'] ?></p>
            <p class="font-bold uppercase underline hidden sm:block"><?= __('Turpināt lasīt', BR_THEME_TEXT_DOMAIN) ?>
            </p>
        </div>
    </a>


</li>