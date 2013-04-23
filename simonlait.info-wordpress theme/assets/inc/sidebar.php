
			
			
			<?php $count = 0; ?>
			<?php $post_id = get_the_ID() ?>
			<?php query_posts(array('post_per_page' => 5, 'post_type' => 'post', 'post__not_in' => array($post_id))) ?>
			<?php if ( have_posts() ) : ?>
            
            <div class="box-shadow news-right">
                <div class="news">
                    <div class="inner">
                    
                    	 <h2 class="font">More Events &amp; Trade Shows</h2>
                         
                         <?php while ( have_posts() ) : the_post(); ?>

                            <!-- post list -->
                            <?php if ($count == 0) : ?>
                                <?php if(get_field('thumb_image') != "") : ?>
									<?php $image = wp_get_attachment_image_src(get_field('thumb_image'), 'preview-image');
                                    $bgimg = $image[0];
                                    ?>
                                    <div class="news-image">
                                    <img src="<?php echo $bgimg ?>" alt="<?php the_title() ?>" title="<?php the_title() ?>" />
                                    </div>
                                <?php else: ?>
                                <?php endif; ?>
                            <?php endif; ?>
                           
                            <div class="news-header">
                                <h3 class="font"><a href="<?php the_permalink(); ?>" class="font"><?php the_title(); ?></a></h3>
                                <h4 class="date font"><?php (get_field('event_date') ? the_field('event_date')  : '') ?></h4>
                            </div>
                            <div class="news-text">
                               <?php global $more; $more = 0;
								the_content('',FALSE,''); ?>			
                            </div>
                            <div class="news-link" style="margin-top:-10px">
                                <a href="<?php the_permalink(); ?>" class="font">read more...</a>
                            </div>
                
                            <div class="clear"></div>
                            <?php $count++; ?>
                            <?php endwhile ?>
                
                       
                    </div>
                </div>
            </div>
			<?php else: ?>
			<!-- no posts found -->
			<?php endif; ?>

			<?php wp_reset_query(); ?>
