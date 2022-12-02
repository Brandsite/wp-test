<li class="blog-card">

    <a href="<?= $args['link'] ?>">
        <img src="<?= wp_get_attachment_image_src($args['image_id'], "full")[0] ?>"
            alt="<?= get_post_meta($args['image_id'], '_wp_attachment_image_alt', TRUE) ?>">

        <div>
            <p><?= date_i18n('F  j Y', $args['date']) ?></p>
            <h2><?= ucfirst($args['title']) ?></h2>
            <p><?= $args['excerpt'] ?></p>
            <p><?= __('Turpināt lasīt', BR_THEME_TEXT_DOMAIN) ?>
            </p>
        </div>
    </a>


</li>