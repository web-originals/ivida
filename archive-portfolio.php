<?php 
get_header(); 
global $archi_option; 
$showall = (!empty($archi_option['portfolio_text_all'])) ? $archi_option['portfolio_text_all'] : 'All Project';
$numbershow = (!empty($archi_option['portfolio_show'])) ? $archi_option['portfolio_show'] : 8;
$gap = (!empty($archi_option['projects_item_gap']) ? $archi_option['projects_item_gap'].'px' : '0px');
$imgwidth = (!empty($archi_option['project_image_width'])) ? $archi_option['project_image_width'] : 700;
$imgheight = (!empty($archi_option['project_image_height'])) ? $archi_option['project_image_height'] : 466;
?>
<?php if($archi_option['subpage-switch']!=false){ ?>
  <!-- subheader begin -->
  <section id="subheader" data-speed="8" data-type="background" class="padding-top-bottom" <?php if($archi_option['portfolio_thumbnail'] != ''){ ?> style="background-image: url('<?php echo esc_url($archi_option['portfolio_thumbnail']['url']); ?>');" <?php } ?> >
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                <?php if ($archi_option['portfolio_title'] != ''){ echo '<h1 class="page-title">' . esc_attr($archi_option['portfolio_title']) . '</h1>'; }else{ the_archive_title( '<h1 class="page-title">', '</h1>' ); } ?>
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
  
    <?php if($archi_option['archive_portfolio_filter']!=false){ ?>
      <div class="container">
        <!-- portfolio filter begin -->
        <div class="row">
            <div class="col-md-12 text-center">
                <ul id="filters" class="wow fadeInUp" data-wow-delay="0s">
                  <li><a href="#" data-filter="*" class="selected"><?php echo esc_attr($showall); ?></a></li>                    
                    <?php 
                      $categories = get_terms('categories');
                       foreach( (array)$categories as $categorie){
                        $cat_name = $categorie->name;
                        $cat_slug = $categorie->slug;
                        $cat_count = $categorie->count;
                      ?>
                      <li><a href="#" data-filter=".<?php echo htmlspecialchars_decode( $cat_slug ); ?>"><?php echo htmlspecialchars_decode( $cat_name ); ?></a></li>
                    <?php } ?>                    
                </ul>
            </div>
        </div>        
        <!-- portfolio filter close -->
      </div>
    <?php } ?>

    <div id="gallery" class="gallery full-gallery de-gallery pf_full_width <?php if ($archi_option['portfolio_columns'] == 2) {echo 'pf_2_cols'; }elseif ($archi_option['portfolio_columns'] == 3) { echo 'pf_3_cols'; }elseif ($archi_option['portfolio_columns'] == 5) { echo 'pf_5_cols'; }elseif ($archi_option['portfolio_columns'] == 6) { echo 'pf_6_cols'; }else{} ?> wow fadeInUp" data-wow-delay=".3s" style="margin:0px <?php echo esc_attr($gap); ?>" >
    <?php
      if ( get_query_var('paged') ){
				$paged = get_query_var('paged');
			}elseif ( get_query_var('page') ){
				$paged = get_query_var('page');
			}else{
				$paged = 1;
			}
			query_posts(array('post_type' => 'portfolio', 'posts_per_page' => $numbershow, 'paged' => $paged ));
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
          <div class="item <?php echo esc_attr($cate_slug); ?>">
              <div class="picframe-new" style="margin:<?php echo esc_attr($gap); ?>">
                  <a <?php if($archi_option['ajax_work']!=false){ ?>class="simple-ajax-popup-align-top"<?php } ?> href="<?php the_permalink(); ?>">
                    <div class="mask"></div>
                    <div class="pr_text">
                        <div class="project-name"><?php the_title(); ?></div>
                    </div>

                    <?php if ( has_post_thumbnail() ) : ?>
                    <?php
                      if ($archi_option['crop_project_images'] != false) {
                        $thumbnail = get_post( get_post_thumbnail_id() );
                        $image_title = $thumbnail->post_title;
                        $image_caption = $thumbnail->post_excerpt;
                        $image_description = $thumbnail->post_content;
                        $image_alt = get_post_meta( $thumbnail->ID, '_wp_attachment_image_alt', true );
                        // Crop
                        $params = array( 'width' => $imgwidth, 'height' => $imgheight, 'crop' => true );
                        $image = bfi_thumb( wp_get_attachment_url(get_post_thumbnail_id()), $params );
                    ?>
                        <img class="lazyload" data-src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>" title="<?php echo esc_attr($image_title); ?>" />
                    <?php
                      }else{
                        the_post_thumbnail( 'thumb-portfolio' );
                      }
                    ?>
                  <?php endif; ?>
                </a>
              </div>
          </div>
          <!-- close gallery item -->
         <?php endwhile; ?>
      </div>
      <div class="container">
        <div class="col-md-12">
          <div class="text-center" style="width:100%;padding-top: 40px;">                
    				<ul class="pagination">
    					<?php echo archi_pagination(); ?>
    				</ul>
          </div>
        </div>
      </div>
  </div>
  <!-- content close -->

<?php get_footer(); ?>
<script>
    // Dynamically import the LazySizes library
    const script = document.createElement('script');
    script.src =
        'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/4.1.8/lazysizes.min.js';
    document.body.appendChild(script);
</script>