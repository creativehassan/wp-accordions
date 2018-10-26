<?php 
/* Basic Style Sheet */
wp_enqueue_style( 'accordion-load-fa' );
wp_enqueue_style( 'wp-accordion-animated' );

wp_enqueue_script( 'wp-accordion-animated' );
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
			<div class="animated-accordion" role="tablist">
				<dl>
				<?php foreach($acc_lists as $key => $list){ ?>
						<dt>
							<a href="#acc-<?php echo $unique_key; ?>-<?php echo $key; ?>" aria-expanded="false" aria-controls="acc-<?php echo $unique_key; ?>-<?php echo $key; ?>" class="animated-accordion-title animated-accordionTitle js-animated-accordionTrigger" style="<?php echo (($heading_color) ? 'color:'.$heading_color.';' : '' ); ?> <?php echo (($heading_bgcolor) ? 'background-color:'.$heading_bgcolor.';' : '' ); ?>">
								<?php echo $list->acc_title; ?>
							</a>
						</dt>
						<dd class="animated-accordion-content animated-accordionItem is-collapsed" id="acc-<?php echo $unique_key; ?>-<?php echo $key; ?>" aria-hidden="true" style="<?php echo (($content_color) ? 'color:'.$content_color.';' : '' ); ?> <?php echo (($content_bgcolor) ? 'background-color:'.$content_bgcolor.';' : '' ); ?>">
							<?php
								$acc_text = $list->acc_text;
								$acc_text = wp_specialchars_decode($acc_text);
								echo  do_shortcode( $acc_text ); 
							?>
						</dd>
					<?php
				} ?> 
				</dl>
			</div>
			<?php
		} else {
			echo '<div class="animated-accordion">'. __('No Accordion found.', 'wp-accordions') .'</div>';
		}
	}
}


?>