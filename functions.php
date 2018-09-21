<?php
/**
 * Created by PhpStorm.
 * User: игорь
 * Date: 20.09.2018
 * Time: 21:42
 */


// стили просто так не подключаются на странице поиска
function header_theme(){
    if(is_search()){
        ?>
        <link rel="stylesheet" id="js_composer_front-css" href="<?php echo get_home_url() ?>/wp-content/uploads/js_composer/js_composer_front_custom.css?ver=5.5.2" type="text/css" media="all">
        <?php
    }
}

add_action('wp_head', 'header_theme');

function edit_admin_menus() {
    global $menu;
    global $submenu;
//todo: переделать список чтобы был динамический и доделать перевод на пост тайпах
    // https://bloggood.ru/wordpress/kak-pereimenovat-punkty-menyu-v-admin-panele-wordpress.html/
    $menu[26][0] = 'Товары';
    $submenu["edit.php?post_type=portfolio"][5][0] = "Все товары";
    $submenu["edit.php?post_type=portfolio"][10][0] = "Добавить новый товар";
    $submenu["edit.php?post_type=portfolio"][15][0] = "Категории";
    $submenu["edit.php?post_type=portfolio"][16][0] = "Тэги";
    $menu[27][0] = 'Процесс';
    $submenu["edit.php?post_type=process"][5][0] = "Все процессы";
    $submenu["edit.php?post_type=process"][10][0] = "Добавить новый процесс";
    $submenu["edit.php?post_type=process"][15][0] = "Категории";
    $menu[28][0] = 'Каталог';
    $submenu["edit.php?post_type=service"][5][0] = "Все типы";
    $submenu["edit.php?post_type=service"][10][0] = "Добавить новый тип";
    $submenu["edit.php?post_type=service"][15][0] = "Категории";
    $menu[29][0] = 'Отзывы';
    $submenu["edit.php?post_type=testimonial"][5][0] = "Все отзывы";
    $submenu["edit.php?post_type=testimonial"][10][0] = "Добавить новый отзыв";
    $submenu["edit.php?post_type=testimonial"][15][0] = "Категории";
}
add_action( 'admin_menu', 'edit_admin_menus' );

function search_form_no_filters() {
    // look for local searchform template
    $search_form_template = locate_template( 'searchform.php' );
    if ( '' !== $search_form_template ) {
        // searchform.php exists, remove all filters
        remove_all_filters('get_search_form');
    }
}
add_action('pre_get_search_form', 'search_form_no_filters');

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5ba40a793cd15',
        'title' => 'Товары',
        'fields' => array(
            array(
                'key' => 'field_5ba40a840773c',
                'label' => 'Цена',
                'name' => 'price',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5ba40aa30773d',
                'label' => 'Размер',
                'name' => 'size',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5ba40abe0773e',
                'label' => 'Вес',
                'name' => 'weight',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5ba40c96f989a',
                'label' => 'Изображения',
                'name' => 'images',
                'type' => 'photo_gallery',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'fields[images' => array(
                    'edit_modal' => 'Default',
                ),
                'edit_modal' => 'Default',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'portfolio',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;