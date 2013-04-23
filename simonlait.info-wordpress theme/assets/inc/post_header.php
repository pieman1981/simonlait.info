<?php if(get_field('thumb_image') != "") : ?>
	<?php $image = wp_get_attachment_image_src(get_field('thumb_image'), 'full-image');
    $img = $image[0];
    $alt = get_post_meta(get_field('thumb_image'), '_wp_attachment_image_alt', true);
    ?>
    
    <div class="teaser-image-post">
        <img src="<?php echo $img ?>" alt="<?php echo $alt ?>" title="<?php echo $alt ?>" />
        <div class="opac"></div>
        <div class="alt font"><?php echo (get_field('image_caption') ? get_field('image_caption') : 'Aspect Support - Committed to delivering technical excellence') ?></div>
    </div>
<?php else: ?>
	<div class="teaser-image-post">
        <img src="<?php bloginfo('template_directory');?>/assets/img/teaser-default.jpg" alt="Aspects Support - Committed to delivering technical excellence" title="Aspects Support - Committed to delivering technical excellence" />
        <div class="opac small"></div>
        <div class="alt font"><?php echo (get_field('image_caption') ? get_field('image_caption') : 'Aspect Support - Committed to delivering technical excellence'  ) ?></div>
    </div>
<?php endif; ?>