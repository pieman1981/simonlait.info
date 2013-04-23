<?php require_once('assets/inc/header.php'); ?>

		<?php get_sidebar(); ?>

		<div class="content">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<!-- post -->


			<section>

				<div class="row">

					<div class="island col2 text">
						<div class="story">
							<h1><?php the_title() ?></h1>
							<div class="theContent">
								<?php if(get_field('thumb_image') != "") : ?>
								<?php $image = wp_get_attachment_image_src(get_field('thumb_image'), 'full-image');
								$img = $image[0];
								$alt = get_post_meta(get_field('thumb_image'), '_wp_attachment_image_alt', true);
								?>
								
								<div class="teaser-image-post">
									<img style="max-width:350px;" src="<?php echo $img ?>" alt="<?php echo $alt ?>" title="<?php echo $alt ?>" />
								</div>
								<?php endif ?>
								<?php the_content(); ?>

								<?php
									$categories = get_the_category();
									$separator = ', ';
									$output = '<div class="small">Skills: ';
									if($categories){
										foreach($categories as $category) {
											$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
										}
									$output .= '</div>';
									echo trim($output, $separator);
									}
								?>

								<div class="clear"></div>
							</div>
							
						</div> <!-- end text -->
						
					</div>	

					

				</div> <!-- end row -->

			</section>

			<?php endwhile; ?>
			<!-- post navigation -->
			<?php else: ?>
			<!-- no posts found -->
			<?php endif; ?>
		</div>

		<div class="clear"></div>

<?php require_once('assets/inc/footer.php'); ?>