<div id="mobile-menu" class="h-[100vh] w-[90%] fixed top-0 right-0 bg-white z-[998] max-w-[400px] pt-10 p-5 hidden">

    <?php
    wp_nav_menu(array(
        'menu'         => 'Mobile menu',
        'menu_class'   => 'uppercase flex flex-col',
        'add_li_class' => 'p-1 ',
    )) ?>

</div>