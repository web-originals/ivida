<?php global $archi_option; ?>
<?php if($archi_option['ajax_work']!=false){ ?>
	<div class="container project-view">
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
            $(document).ready(function () {
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
                        duration =  300;
                    if (!item.hasClass('active')){
                        //добавили клас у актива, чтоб не нажимался анимация на одином и тодже слайде, а у остальных его убираем
                        item.addClass('active').siblings().removeClass('active');
                        display.find('img').fadeOut(duration, function () {
                            $(this).attr('src',paht).fadeIn(duration);
                        })
                    }
                });
            });
        </script>
		<?php while (have_posts()) : the_post()?>
            <?php
            //todo: а также обратную связь сделать с прикреплением текущей записи
            //todo: добавить поле для ютуб видео и ставлять шорткодами
            //todo: сдлеать дизайн сингловых страниц ибо отдается не то что нужно
            $allimages = '';
            $first_image = '';
            foreach (explode(',',get_field( "images" )) as $key=>$item) {
                if($key == 0){
                    $first_image = wp_get_attachment_image_src($item,'full')[0];
                    $temp = 'active';
                }else{
                    $temp = '';
                }
                $allimages .='<li class="slideshow_item '. $temp .'"><a href="#" class="slideshow_pic"><img src="'.wp_get_attachment_image_src($item,'full')[0].'" alt=""></a></li>';
//                $allimages .= '[vc_single_image image="'.$item.'" img_size="full" css=".vc_custom_'.mt_rand(10000000,  mt_getrandmax()).'{margin-bottom: 60px !important;}"]';
            }
            $content = '[vc_row][vc_column width="2/3"]'.'
<div class="wrapper col-lg-10">
         <div class="">
             <div class="slideshow">
                 <div class="slideshow_display">
                     <img src="'.$first_image.'" alt="">
                 </div>
                 <ul class="slideshow_list">
                 '.$allimages.'
                 </ul>
             </div>
         </div>
     </div>
            [/vc_column][vc_column width="1/3"][vc_column_text]<div class="project-info">
                    <h2>'.get_the_title().'</h2>
                    <input class="btn_call-back" type="button"  value="Обратная связь">
                    <div class="details">
                        <div class="info-text"><span class="title">Цена</span><span class="val">'.get_field( "price" ).'</span></div>
                        <div class="info-text"><span class="title">Размер</span><span class="val">'.get_field( "size" ).'</span></div>
                        <div class="info-text"><span class="title">Вес</span><span class="val">'.get_field( "weight" ).'</span></div>
                    </div>'.get_the_content().'
                </div>[/vc_column_text][/vc_column][/vc_row]';
            echo  apply_filters( 'the_content',$content);?>
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
					<?php the_content(); ?>
				<?php endwhile; ?>			
			<?php endif; ?>
			<section class="single-portfolio-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<?php if ($archi_option['project_sharing']!=false) { ?>
								<div class="socials-portfolio socials-rounded">
									<h4><?php esc_html_e('Share:', 'archi'); ?></h4>
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
