<?php 
global $post;
$accordion_type = get_post_meta( $post->ID, 'accordion_type', true );
$accordion_open_one = get_post_meta( $post->ID, 'accordion_open_one', true );
$accordion_open_one = (($accordion_open_one) ? 'checked="checked"' : '');
$list_accordion = array(
	"simple" => 'Simple Accordion (JS)',
	"basic" => 'Basic Accordion (CSS)',
	"animated" => 'Animated Accordion (JS)',
	"slide" => 'Slide Accordion (CSS)',
);
$list_accordion = apply_filters( 'wp_list_accordion', $list_accordion );
?>

<!--<div class="wp-accordion-type">
	<label for="wp_accordions_type"><?php echo __("Accordion Type", 'wp-accordions'); ?></label><br />
	<select name="accordion_type" id="wp_accordions_type">
		<option value=""><?php echo __("Select Accordion Type", 'wp-accordions'); ?></option>
		<?php if( !empty($list_accordion) ){ ?>
			<?php foreach($list_accordion as $key => $value){ ?>
				<option value="<?php echo $key; ?>" <?php echo (($accordion_type == $key) ? 'selected="selected"' : ''); ?>><?php echo $value; ?></option>
			<?php } ?>
		<?php } ?>
	</select>
	<div style="clear:both;"></div>
</div>-->
<div class="wp-accordion-type">
	<input type="checkbox" id="wp_accordion_open_one" name="accordion_open_one" value="1" <?php echo $accordion_open_one; ?>><label for="wp_accordion_open_one"><?php echo __("Open one accordion at a time", 'wp-accordions'); ?></label><br />
	<div style="clear:both;"></div>
</div>