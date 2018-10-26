<?php 
/* Basic Style Sheet */
wp_enqueue_style( 'accordion-load-fa' );
wp_enqueue_style( 'wp-accordion-slide' );

global $wpdb;
$accordion_id = $atts['accordion_id'];
$accordion_class = $atts['accordion_class'];
if($accordion_id){
	/* $random_key = wp_generate_password( 8, false );
	$unique_key = md5("accordion_".$accordion_id . $random_key); */
	$unique_key = md5("accordion_".$accordion_id );
	$accordion_post  = get_post($accordion_id);
	if(!empty($accordion_post)){
		$acc_id  = $accordion_post->ID;
		$heading_color = get_post_meta( $acc_id, 'heading_color', true );
		$heading_bgcolor = get_post_meta( $acc_id, 'heading_bgcolor', true );
		$content_color = get_post_meta( $acc_id, 'content_color', true );
		$content_bgcolor = get_post_meta( $acc_id, 'content_bgcolor', true );
		$acc_lists = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "accordions WHERE post_id = " . $acc_id ." ORDER BY post_order ASC" );
		if(!empty($acc_lists)){ ?>
			<ul class="slide-accordion" id="acc_<?php echo $unique_key; ?>" role="tablist">
			<?php foreach($acc_lists as $key => $list){ ?>
					<li>
					   <input type="checkbox" name="acc" id="acc-<?php echo $unique_key; ?>-<?php echo $key; ?>" checked="checked" />
					   <i></i>
					   <h2 style="<?php echo (($heading_color) ? 'color:'.$heading_color.';' : '' ); ?> <?php echo (($heading_bgcolor) ? 'background-color:'.$heading_bgcolor.';' : '' ); ?>"><?php echo $list->acc_title; ?></h2>
					   <div class="acc-description" style="<?php echo (($content_color) ? 'color:'.$content_color.';' : '' ); ?> <?php echo (($content_bgcolor) ? 'background-color:'.$content_bgcolor.';' : '' ); ?>">
							<?php
								$acc_text = $list->acc_text;
								$acc_text = wp_specialchars_decode($acc_text);
								echo  do_shortcode( $acc_text ); 
							?>
					   </div>
					</li>
				<?php
			} ?> 
			</ul>
			<?php
		} else {
			echo '<div class="slide-accordion">'. __('No Accordion found.', 'wp-accordions') .'</div>';
		}
	}
}


?>