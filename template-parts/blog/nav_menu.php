<ul class="category-menu">
    <li>
        <a href="<?= get_site_url() . '/blogs' ?>"
            class="<?php if (is_page('blogs')) echo 'underline' ?>"><?= __('Viss', BR_THEME_TEXT_DOMAIN) ?></a>
    </li>

    <?php
    $categories = get_categories(array(
        'orderby' => 'name',
        'order'   => 'ASC',
    ));

    $current_category = get_category(get_query_var('cat'));

    foreach ($categories as $category) : ?>
    <li>
        <a href="<?= esc_url(get_category_link($category->term_id)) ?>"
            class="<?php if ($current_category->name === $category->name) echo 'underline' ?>"><?= $category->name ?>
        </a>
    </li>
    <?php endforeach ?>
</ul>