<?php get_header(); ?>
<?php global $archi_option;
global $archi_option;
$showall = (!empty($archi_option['portfolio_text_all'])) ? $archi_option['portfolio_text_all'] : 'All Project';
$numbershow = (!empty($archi_option['portfolio_show'])) ? $archi_option['portfolio_show'] : 8;
$gap = (!empty($archi_option['projects_item_gap']) ? $archi_option['projects_item_gap'].'px' : '0px');
$imgwidth = (!empty($archi_option['project_image_width'])) ? $archi_option['project_image_width'] : 700;
$imgheight = (!empty($archi_option['project_image_height'])) ? $archi_option['project_image_height'] : 466;
?>
<?php if($archi_option['subpage-switch']!=false){ ?>

    <!-- subheader begin -->
    <section id="subheader" data-speed="8" data-type="background" class="padding-top-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if(function_exists('archi_breadcrumbs')): 
                            archi_breadcrumbs();
                        endif;
                    ?> 
                </div>
            </div>
        </div>
    </section>
    <!-- subheader close -->

<?php }else{ ?>
    <section class="no-subpage"></section>
<?php } ?>

<!-- content begin -->
<div id="content" class="padtop0">
    <div class="container">
        <div class="row">
            <?php get_search_form(); ?>
            <?php if(isset($archi_option['blog-layout']) and $archi_option['blog-layout'] == 2 ){ ?>
                <div class="<?php echo 'col-md-'.esc_attr($archi_option['blog_col_right']); ?>">
                  <?php get_sidebar();?>
                </div>
            <?php } ?>
        </div>
    </div>
                <?php if(have_posts()) : ?>
    <!-- content begin -->
    <?php if(isset($archi_option['archive_service_style']) and $archi_option['archive_service_style']!="slist"){ ?>
    <div id="content">
        <div class="container">
            <div id="services-masonry" class="row">
                <?php }else{ ?>
                <div id="content" class="no-padding">
                    <?php } ?>
                    <?php
                        if ( get_query_var('paged') ){
                            $paged = get_query_var('paged');
                        }elseif ( get_query_var('page') ){
                            $paged = get_query_var('page');
                        }else{
                            $paged = 1;
                        }
                        while( have_posts() ) : the_post();
                            $cates = get_the_terms(get_the_ID(),'categories');
                            $cate_name ='';
                            $cate_slug = '';
                            foreach((array)$cates as $cate){
                                if(count($cates)>0){
                                    $cate_name .= $cate->name.'<span>, </span> ' ;
                                    $cate_slug .= $cate->slug .' ';
                                }
                            }
                            ?>
                            <!-- gallery item -->
                            <div class="<?php echo esc_attr($service_col); ?> item-service item">

                                <?php if(isset($archi_option['service_img']) and $archi_option['service_img']=="imgabove"){ ?>
                                    <a href="<?php the_permalink(); ?>" class="simple-ajax-popup-align-top">
                                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumb-service', array( 'class' => 'img-responsive' ) ); } ?>
                                    </a>
                                    <div class="spacer-single"></div>
                                <?php } ?>

                                <h3><?php the_title(); ?></h3>
                                <?php the_excerpt(); ?>

                                <?php if(isset($archi_option['service_img']) and $archi_option['service_img']=="imgbelow"){ ?>
                                    <div class="spacer-single-10"></div>
                                    <a href="<?php the_permalink(); ?>" class="simple-ajax-popup-align-top">
                                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumb-service', array( 'class' => 'img-responsive' ) ); } ?>
                                    </a>
                                <?php } ?>

                                <div class="spacer-single"></div>
                                <a href="<?php the_permalink(); ?>" class=" simple-ajax-popup-align-top btn-line btn-fullwidth"><?php echo htmlspecialchars_decode( do_shortcode( $archi_option['archive_service_read'] ) ); ?></a>

                            </div>
                            <!-- close gallery item -->
                        <?php endwhile; ?>
                    </div>
                <?php if(isset($archi_option['archive_service_style']) and $archi_option['archive_service_style']!="slist"){ ?>
            </div>
        </div>
        <?php } ?>
                <?php else: ?>
                    <h1><?php esc_html_e('Ничего не найдено!', 'archi'); ?></h1>
                <?php endif; ?>

                <div class="text-center">
                    <ul class="pagination">
                        <?php echo archi_pagination(); ?>
                    </ul>
                </div>
            <?php if(isset($archi_option['blog-layout']) and $archi_option['blog-layout'] == 3 ){ ?>
                <div class="<?php echo 'col-md-'.esc_attr($archi_option['blog_col_right']); ?>">
                  <?php get_sidebar();?>
                </div>
            <?php } ?>
</div>
<!-- content close -->
<?php get_footer();
?>


