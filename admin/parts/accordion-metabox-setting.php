<?php 
global $post;
$heading_color = get_post_meta( $post->ID, 'heading_color', true );
$heading_bgcolor = get_post_meta( $post->ID, 'heading_bgcolor', true );
$content_color = get_post_meta( $post->ID, 'content_color', true );
$content_bgcolor = get_post_meta( $post->ID, 'content_bgcolor', true );
?>

<div class="wp-accordion-settings">
	<!--<label for="wp_accordions_type"><?php echo __("Accordion Type", 'wp-accordions'); ?></label><br /><br />
	<input type="text" name="wp_accordions_type" class="regular-text wp_accordions_type" placeholder="#000000" /><br /><br />-->
	
	<label for="heading_color"><strong><?php echo __("Heading Color", 'wp-accordions'); ?></strong></label>
	<input type="text" name="heading_color" class="regular-text heading_color color-picker" placeholder="#000000" value="<?php echo $heading_color; ?>" />
	<label for="heading_bgcolor"><strong><?php echo __("Heading Background Color", 'wp-accordions'); ?></strong></label>
	<input type="text" name="heading_bgcolor" class="regular-text heading_bgcolor color-picker" placeholder="#000000" value="<?php echo $heading_bgcolor; ?>"/>
	
	<label for="content_color"><strong><?php echo __("Content Color", 'wp-accordions'); ?></strong></label>
	<input type="text" name="content_color" class="regular-text content_color color-picker" placeholder="#000000" value="<?php echo $content_color; ?>" />
	<label for="content_bgcolor"><strong><?php echo __("Content Background Color", 'wp-accordions'); ?></strong></label>
	<input type="text" name="content_bgcolor" class="regular-text content_bgcolor color-picker" placeholder="#000000" value="<?php echo $content_bgcolor; ?>"/>
	
	<div style="clear:both;"></div>
</div>