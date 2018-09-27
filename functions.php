<?php
/**
 * Created by PhpStorm.
 * User: игорь
 * Date: 20.09.2018
 * Time: 21:42
 */

function footer_script()
{
    ?>
    <script>


                function galery_run() {
                    //клик по ссылкам верхнего уровня
                    $('.slideshow_pic').on('click', function (e) {
                        // запрещает дефолдное действие эл. переход по ссылке
                        e.preventDefault();
                        // сохраняем переменные
                        var $this = $(this),
                            //сохраняем li по которой кликнули
                            item = $this.closest('.slideshow_item'),
                            //сохраняем контент со слайдером
                            container = $this.closest('.slideshow'),
                            //сохраняем блок отображения вида
                            display = container.find('.slideshow_display'),
                            //принцип работы слайдера берем src у img  и вставляем его в блок slideshow_display
                            paht = item.find('img').attr('src'),
                            // время анимации
                            duration = 300;
                        if (!item.hasClass('active')) {
                            //добавили клас у актива, чтоб не нажимался анимация на одином и тодже слайде, а у остальных его убираем
                            item.addClass('active').siblings().removeClass('active');
                            display.find('img').fadeOut(duration, function () {
                                $(this).attr('src', paht).fadeIn(duration);
                            })
                        }
                    });
                }



    </script>
    <?php
}
add_action('wp_footer', 'footer_script',100);

// стили просто так не подключаются на странице поиска
function header_theme(){
    if(is_search() || is_singular( 'portfolio' ) ){
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


// contact form 7 прикрепление записи с кнопки обратная связь [feedback-button-click]
function feedback_form() {
    if(isset($_REQUEST['add'])){
        $thumbnail_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($_REQUEST['add']), 'medium' );
        return '<a href="'.get_permalink($_REQUEST['add']).'"><div class="feedback-post"><p>'.get_the_title($_REQUEST['add']).'</p><img  src ="'.$thumbnail_attributes[0].'"></div></a>';
    }
    else {
        return "";
    }
}
wpcf7_add_form_tag('feedback', 'feedback_form');


function feedback_form_send() {
    return get_permalink($_REQUEST['add']);
}
wpcf7_add_form_tag('feedback_send', 'feedback_form_send');
add_shortcode('feedback_send', 'feedback_form_send');

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
        'singular_name'         => 'Каталог',
        'add_new'               => 'Добавить услугу',
        'add_new_item'          => 'Добавить услугу',
        'edit_item'             => 'Редактировать услугу',
        'new_item'              => 'Новая услуга',
        'view_item'             => 'Просмотреть услугу',
        'search_items'          => 'Поиск услуг',
        'not_found'             => 'Услуги не найдены.',
        'not_found_in_trash'    => 'Услуги в корзине не найдены.',
        'parent_item_colon'     => '',
        'all_items'             => 'Все услуги',
        'archives'              => 'Архивы услуг',
        'insert_into_item'      => 'Вставить в услугу',
        'uploaded_to_this_item' => 'Загруженные для этой услуги',
        'featured_image'        => 'Миниатюра услуги',
        'filter_items_list'     => 'Фильтровать список услуг',
        'items_list_navigation' => 'Навигация по списку услуг',
        'items_list'            => 'Список услуг',
        'menu_name'             => 'Услуги',
        'name_admin_bar'        => 'Услуга', // пункте "добавить"
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

    function archi_breadcrumbs() {
        $text['home']     = "Главная"; // text for the 'Home' link
        $text['category'] = '%s'; // text for a category page
        $text['tax']      = '%s'; // text for a taxonomy page
        $text['search']   = '%s'; // text for a search results page
        $text['tag']      = '%s'; // text for a tag page
        $text['author']   = '%s'; // text for an author page
        $text['404']      = '404'; // text for the 404 page
        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter   = ' <b>/</b> '; // delimiter between crumbs
        $before      = '<li class="active">'; // tag before the current crumb
        $after       = '</li>'; // tag after the current crumb

        global $post;
        $homeLink = esc_url(home_url('/')) . '';
        $linkBefore = '<li>';
        $linkAfter = '</li>';
        $linkAttr = ' rel="v:url" property="v:title"';
        $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

        if (is_home() || is_front_page()) {

            if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

        } else {

            echo '<ul class="crumb">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

            if ( is_category() ) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo htmlspecialchars_decode( $cats );
                }
                echo htmlspecialchars_decode( $before ) . sprintf($text['category'], single_cat_title('', false)) . htmlspecialchars_decode( $after );

            } elseif( is_tax() ){
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo htmlspecialchars_decode( $cats );
                }
                echo htmlspecialchars_decode( $before ) . sprintf($text['tax'], single_cat_title('', false)) . htmlspecialchars_decode( $after );

            }elseif ( is_search() ) {
                echo htmlspecialchars_decode( $before ) . sprintf($text['search'], get_search_query()) . htmlspecialchars_decode( $after );

            } elseif ( is_day() ) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
                echo htmlspecialchars_decode( $before ) . get_the_time('d') . htmlspecialchars_decode( $after );

            } elseif ( is_month() ) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo htmlspecialchars_decode( $before ) . get_the_time('F') . htmlspecialchars_decode( $after );

            } elseif ( is_year() ) {
                echo htmlspecialchars_decode( $before ) . get_the_time('Y') . htmlspecialchars_decode( $after );

            } elseif ( is_single() && !is_attachment() ) {
                if ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    printf($link, $homeLink . '' . $slug['slug'] . '/', $post_type->labels->singular_name);
                    if ($showCurrent == 1) echo htmlspecialchars_decode( $delimiter ) . $before . get_the_title() . $after;
                } else {
                    $cat = get_the_category(); $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo htmlspecialchars_decode( $cats );
                    if ($showCurrent == 1) echo htmlspecialchars_decode( $before ) . get_the_title() . $after;
                }

            } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {

                $post_type = get_post_type_object(get_post_type());
                echo htmlspecialchars_decode( $before ) . $post_type->labels->singular_name . htmlspecialchars_decode( $after );

            } elseif ( is_attachment() ) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo htmlspecialchars_decode( $cats );
                printf($link, get_permalink($parent), $parent->post_title);
                if ($showCurrent == 1) echo htmlspecialchars_decode( $delimiter ) . $before . get_the_title() . $after;

            } elseif ( is_page() && !$post->post_parent ) {
                if ($showCurrent == 1) echo htmlspecialchars_decode( $before ) . get_the_title() . $after;

            } elseif ( is_page() && $post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo htmlspecialchars_decode( $breadcrumbs[$i] );
                    if ($i != count($breadcrumbs)-1) echo htmlspecialchars_decode( $delimiter );
                }
                if ($showCurrent == 1) echo htmlspecialchars_decode( $delimiter ) . $before . get_the_title() . $after;

            } elseif ( is_tag() ) {
                echo htmlspecialchars_decode( $before ) . sprintf($text['tag'], single_tag_title('', false)) . $after;

            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata($author);
                echo htmlspecialchars_decode( $before ) . sprintf($text['author'], $userdata->display_name) . $after;

            } elseif ( is_404() ) {
                echo htmlspecialchars_decode( $before ) . $text['404'] . $after;
            }

            if ( get_query_var('paged') ) {
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() );
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
            }

            echo '</ul>';

        }
    }