<?php global $archi_option;?>
<?php
$ajax_work = false;
if($archi_option['ajax_work']!=false && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    $ajax_work = true;
}
function get_content_portfolio($ajax_work)
{
    ?>
        <style>
            .slideshow_display{
                position: relative;
                width: auto;
                height: 271px;
                border: solid 1px #cccccc;
                overflow: hidden;
            }
            .slideshow_display img{
                display: block;
                position: absolute;
                 top: 0;
                 left: 0;
                 bottom: 0;
                 right: 0;
                margin: auto;
            }
            .slideshow_item{
                display: inline-block;
            }
            .slideshow_list{
                padding-top: 15px;
                clear: both;
            }
            .slideshow_item{
                float: left;
                margin-left: 23px;
                padding: 3px;
            }
            .slideshow_item:first-child{
                margin-left: 0;
            }
            .slideshow {
                padding: 20px;
                width: 100%;
            }
            .slideshow_display img{
                width: auto;
                height: 250px;
            }
            .slideshow_list .slideshow_item img{
                width: auto;
                max-height: 80px;
            }
            .btn_call-back{
                border: none;
                background-color: red;
                padding: 2% 4%;
                color: black;
            }
            .btn_call-back:hover{
                background-color: #cccccc;
            }
        </style>
    <script>
        <?php if( $ajax_work )
        {
            ?>
            galery_run();
        <?php
        }else{
            ?>
        document.addEventListener("DOMContentLoaded", function(event) {
            galery_run();
        });
            <?php
        }
       ?>
    </script>
<?php
    global $post;
    $allimages = '';
//    $first_image = '';
    foreach (explode(',', get_field("images")) as $key => $item) {
        if ($key == 0) {
//            $first_image = wp_get_attachment_image_src($item, 'full')[0];
            $temp = 'active';
        } else {
            $temp = '';
        }
//        $allimages .= '<li class="slideshow_item ' . $temp . '"><a href="#" class="slideshow_pic"><img src="' . wp_get_attachment_image_src($item, 'full')[0] . '" alt=""></a></li>';
        $allimages .= '<div class="item ' . $temp . '"><img class="d-block w-100" src="' . wp_get_attachment_image_src($item, 'full')[0] . '" alt=""></div>';
    }

    $content = '[vc_row][vc_column width="2/3"]' . '
<div class="wrapper" col-lg-10">
     <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
           '.$allimages.'
        </div>
        <a class="left carousel-control" href="#carouselExampleControls" role="button" data-slide="prev">
           <i class="fa fa-angle-left"></i>
        </a>
        <a class="right carousel-control" href="#carouselExampleControls" role="button" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>
            [/vc_column][vc_column width="1/3"][vc_column_text]<div class="project-info">
                    <h2>' . get_the_title() . '</h2>
                    
                    ';
    if(!empty(get_field("price")) || !empty(get_field("size")) || !empty(get_field("weight"))){
        $content.= '<div class="details">';
        if(!empty(get_field("price")))
            $content.= '<div class="info-text"><span class="title">Цена</span><span class="val">' . get_field("price") . '</span></div>';
        if(!empty(get_field("size")))
            $content.= '<div class="info-text"><span class="title">Размер</span><span class="val">' . get_field("size") . '</span></div>';
        if(!empty(get_field("weight")))
            $content.= '<div class="info-text"><span class="title">Вес</span><span class="val">' . get_field("weight") . '</span></div>';

        $content.=   '</div>';
    }
    $content.= get_the_content() . '
                <a href="' . get_home_url() . '/order/?add=' . $post->ID . '" class ="btn btn-more btn-big" target="_self" >Обратная связь</a>
                </div>[/vc_column_text][/vc_column][/vc_row]';
    return apply_filters('the_content', $content);
}
?>
<?php if( $ajax_work ){ ?>
	<div class="container project-view">
		<?php while (have_posts()) : the_post()?>
            <?php
            echo get_content_portfolio($ajax_work);
        ?>
		<?php endwhile; ?>
	</div>
<?php }else { ?>
	<?php get_header(); ?>
		<?php global $archi_option; ?>
		<?php if($archi_option['subpage-switch']!=false){ ?>
			<section id="subheader" data-speed="8" data-type="background" class="padding-top-bottom"
				<?php if( function_exists( 'rwmb_meta' ) ) { ?>
			        <?php $images = rwmb_meta( '_cmb_portfolio_subheader', "type=image" ); ?>
			        <?php if($images){ foreach ( $images as $image ) { ?>
			        <?php $img =  $image['full_url']; ?>
			          style="background-image: url('<?php echo esc_url($img); ?>');"
			        <?php } } ?>
			    <?php } ?>
			>
			    <div class="container">
			        <div class="row">
			            <div class="col-md-12">
			                <h1><?php the_title(); ?></h1>
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

		<?php if(isset($archi_option['single_navigation']) and $archi_option['single_navigation']=="navontop" ){ ?>
			<div id="portfolio-controls">
		        <div class="left-right-portfolio">
		            <div class="portfolio-icon">
		            	<?php
			            	if ($archi_option['portfolio_navigation'] == 'samecategory') {
								previous_post_link('%link', __('<i class="fa fa-angle-double-left"></i>', 'archi'), TRUE, ' ', 'categories');
			            	}else{
			            		previous_post_link('%link', __('<i class="fa fa-angle-double-left"></i>', 'archi'), $post->max_num_pages );
			            	}
		            	?>
		            </div>
		        </div>
		        <a href="<?php echo esc_url($archi_option['portfolio_link']); ?>">
		            <div class="center-portfolio">
		                <div class="portfolio-icon fa-th"></div>
		            </div>
		        </a>
		        <div class="left-right-portfolio">
		            <div class="portfolio-icon">
		            	<?php
			            	if ($archi_option['portfolio_navigation'] == 'samecategory') {
								next_post_link('%link', __('<i class="fa fa-angle-double-right"></i>', 'archi'), TRUE, ' ', 'categories');
			            	}else{
			            		next_post_link('%link', __('<i class="fa fa-angle-double-right"></i>', 'archi'), $post->max_num_pages );
			            	}
		            	?>
		            </div>
		        </div>
		    </div>
		<?php } ?>

		<div id="content">
			<?php if ( have_posts() ) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php echo get_content_portfolio($ajax_work); ?>
				<?php endwhile; ?>
			<?php endif; ?>
			<section class="single-portfolio-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<?php if ($archi_option['project_sharing']!=false) { ?>
								<div class="socials-portfolio socials-rounded">
									<h4>Поделиться:</h4>
									<div class="socials-sharing">
										<a class="socials-item" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" title="Facebook"><i class="fa fa-facebook"></i></a>
										<a class="socials-item" target="_blank" href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>" title="Twitter"><i class="fa fa-twitter"></i></a>
										<a class="socials-item" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" title="Google Plus"><i class="fa fa-google-plus"></i></a>
										<a class="socials-item" target="_blank" href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&description=<?php the_title(); ?>" title="Pinterest"><i class="fa fa-pinterest"></i></a>
										<a class="socials-item" href="http://digg.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i class="fa fa-digg" aria-hidden="true"></i></a>
										<a class="socials-item" target="_blank" href="http://www.tumblr.com/share/link?url=<?php the_permalink(); ?>&name=<?php the_title(); ?>&description=<?php echo get_the_excerpt(); ?>" title="Tumblr"><i class="fa fa-tumblr"></i></a>
										<a class="socials-item" href="http://reddit.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i class="fa fa-reddit-alien" aria-hidden="true"></i></a>
										<a class="socials-item" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=<?php echo get_the_excerpt(); ?>" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
										<a class="socials-item" target="_blank" href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" title="StumbleUpon"><i class="fa fa-stumbleupon"></i></a>
										<a class="socials-item" href="https://delicious.com/save?v=5&provider=<?php bloginfo( 'name' ); ?>&noui&jump=close&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><i class="fa fa-delicious" aria-hidden="true"></i></a>
										<a class="socials-item" href="http://vk.com/share.php?url=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-vk"></i></a>
									</div>
								</div>
							<?php } ?>

							<?php if(isset($archi_option['single_navigation']) and $archi_option['single_navigation']=="navonbottom" ){ ?>
								<div class="double-divider clearfix"></div>
								<div class="portfolio-navigation clearfix">
									<div class="portfolio-btn-prev">
										<?php
							            	if ($archi_option['portfolio_navigation'] == 'samecategory') {
												previous_post_link('%link', __('<i class="fa fa-chevron-left"></i> Prev', 'archi'), TRUE, ' ', 'categories');
							            	}else{
							            		previous_post_link('%link', __('<i class="fa fa-chevron-left"></i> Prev', 'archi'), $post->max_num_pages );
							            	}
						            	?>
									</div>
									<div class="portfolio-btn-next">
										<?php
							            	if ($archi_option['portfolio_navigation'] == 'samecategory') {
												next_post_link('%link', __('Next <i class="fa fa-chevron-right"></i>', 'archi'), TRUE, ' ', 'categories');
							            	}else{
							            		next_post_link('%link', __('Next <i class="fa fa-chevron-right"></i>', 'archi'), $post->max_num_pages );
							            	}
						            	?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</section>
		</div>
	<?php get_footer(); ?>
<?php } ?>
