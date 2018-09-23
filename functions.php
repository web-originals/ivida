<?php
/**
 * Created by PhpStorm.
 * User: игорь
 * Date: 20.09.2018
 * Time: 21:42
 */
// todo: хлебные крошки переименовать на русский

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
    global $submenu;
    // https://bloggood.ru/wordpress/kak-pereimenovat-punkty-menyu-v-admin-panele-wordpress.html/
    $replace_sub_menu = [
        'edit.php?post_type=portfolio'=>[15=>"Категории",16=>"Тэги"],
        'edit.php?post_type=process'=>[15=>"Категории"],
        'edit.php?post_type=service'=>[15=>"Категории"],
        'edit.php?post_type=testimonial'=>[15=>"Категории"],
    ];
    foreach ($submenu as $key=>$item){
        if( array_key_exists($key,$replace_sub_menu)){
            foreach ($replace_sub_menu[$key] as $subkey=>$subitem){
                $submenu[$key][$subkey][0] = $subitem;
            }
        }
    }
}
add_action( 'admin_menu', 'edit_admin_menus' );


## заменим слово "записи" на "посты" для типа записей 'post'
//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_portfolio', 'rename_portfolio_labels');
function rename_portfolio_labels( $labels ){
    // заменять автоматически нельзя: Запись = Статья, а в тексте получим "Просмотреть статья"

    $new = array(
        'name'                  => 'Товары',
        'singular_name'         => 'Товар',
        'add_new'               => 'Добавить товар',
        'add_new_item'          => 'Добавить товар',
        'edit_item'             => 'Редактировать товар',
        'new_item'              => 'Новый товар',
        'view_item'             => 'Просмотреть товар',
        'search_items'          => 'Поиск товаров',
        'not_found'             => 'Товары не найдены.',
        'not_found_in_trash'    => 'Товары в корзине не найдены.',
        'parent_item_colon'     => '',
        'all_items'             => 'Все товары',
        'archives'              => 'Архивы товаров',
        'insert_into_item'      => 'Вставить в товар',
        'uploaded_to_this_item' => 'Загруженные для этого товара',
        'featured_image'        => 'Миниатюра товара',
        'filter_items_list'     => 'Фильтровать список товароа',
        'items_list_navigation' => 'Навигация по списку товаров',
        'items_list'            => 'Список тоароа',
        'menu_name'             => 'Товары',
        'name_admin_bar'        => 'Товар', // пункте "добавить"
    );

    return (object) array_merge( (array) $labels, $new );
}

add_filter('post_type_labels_process', 'rename_process_labels');
function rename_process_labels( $labels ){
    // заменять автоматически нельзя: Запись = Статья, а в тексте получим "Просмотреть статья"

    $new = array(
        'name'                  => 'Процессы',
        'singular_name'         => 'Процесс',
        'add_new'               => 'Добавить процесс',
        'add_new_item'          => 'Добавить процесс',
        'edit_item'             => 'Редактировать процесс',
        'new_item'              => 'Новый процесс',
        'view_item'             => 'Просмотреть процесс',
        'search_items'          => 'Поиск процессов',
        'not_found'             => 'Процессы не найдены.',
        'not_found_in_trash'    => 'Процессы в корзине не найдены.',
        'parent_item_colon'     => '',
        'all_items'             => 'Все процессы',
        'archives'              => 'Архивы процессов',
        'insert_into_item'      => 'Вставить в процесс',
        'uploaded_to_this_item' => 'Загруженные для этого процесса',
        'featured_image'        => 'Миниатюра процесса',
        'filter_items_list'     => 'Фильтровать список процессов',
        'items_list_navigation' => 'Навигация по списку процессов',
        'items_list'            => 'Список процессов',
        'menu_name'             => 'Процессы',
        'name_admin_bar'        => 'Процесс', // пункте "добавить"
    );

    return (object) array_merge( (array) $labels, $new );
}


add_filter('post_type_labels_service', 'rename_service_labels');
function rename_service_labels( $labels ){
    // заменять автоматически нельзя: Запись = Статья, а в тексте получим "Просмотреть статья"

    $new = array(
        'name'                  => 'Каталог',
        'singular_name'         => 'Тип',
        'add_new'               => 'Добавить тип',
        'add_new_item'          => 'Добавить тип',
        'edit_item'             => 'Редактировать тип',
        'new_item'              => 'Новый тип',
        'view_item'             => 'Просмотреть тип',
        'search_items'          => 'Поиск типов',
        'not_found'             => 'Типы не найдены.',
        'not_found_in_trash'    => 'Типы в корзине не найдены.',
        'parent_item_colon'     => '',
        'all_items'             => 'Все типы',
        'archives'              => 'Архивы типов',
        'insert_into_item'      => 'Вставить в тип',
        'uploaded_to_this_item' => 'Загруженные для этого типа',
        'featured_image'        => 'Миниатюра типа',
        'filter_items_list'     => 'Фильтровать список типов',
        'items_list_navigation' => 'Навигация по списку типов',
        'items_list'            => 'Список типов',
        'menu_name'             => 'Типы',
        'name_admin_bar'        => 'Тип', // пункте "добавить"
    );

    return (object) array_merge( (array) $labels, $new );
}

add_filter('post_type_labels_testimonial', 'rename_testimonials_labels');
function rename_testimonials_labels( $labels ){
    // заменять автоматически нельзя: Запись = Статья, а в тексте получим "Просмотреть статья"

    $new = array(
        'name'                  => 'Отзывы',
        'singular_name'         => 'Отзыв',
        'add_new'               => 'Добавить отзыв',
        'add_new_item'          => 'Добавить отзыв',
        'edit_item'             => 'Редактировать отзыв',
        'new_item'              => 'Новый отзыв',
        'view_item'             => 'Просмотреть отзыв',
        'search_items'          => 'Поиск отзывов',
        'not_found'             => 'Отзывы не найдены.',
        'not_found_in_trash'    => 'Отзывы в корзине не найдены.',
        'parent_item_colon'     => '',
        'all_items'             => 'Все отзывы',
        'archives'              => 'Архивы отзывов',
        'insert_into_item'      => 'Вставить в отзыв',
        'uploaded_to_this_item' => 'Загруженные для этого отзыва',
        'featured_image'        => 'Миниатюра отзыва',
        'filter_items_list'     => 'Фильтровать список отзывов',
        'items_list_navigation' => 'Навигация по списку отзывов',
        'items_list'            => 'Список отзывов',
        'menu_name'             => 'Отзывы',
        'name_admin_bar'        => 'Отзыв', // пункте "добавить"
    );

    return (object) array_merge( (array) $labels, $new );
}


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