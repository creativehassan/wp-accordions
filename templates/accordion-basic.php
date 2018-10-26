<?php 
global $wpdb;
/* Basic Style Sheet */
wp_enqueue_style( 'accordion-load-fa' );
wp_enqueue_style( 'wp-accordion-basic' );

$accordion_id = $atts['accordion_id'];
$accordion_class = $atts['accordion_class'];
if($accordion_id){
	$unique_key = md5("accordion_".$accordion_id );
	$accordion_post  = get_post($accordion_id);
	if(!empty($accordion_post)){
		$acc_id  = $accordion_post->ID;
		$accordion_meta_id = get_post_meta( $acc_id, 'accordion_meta_id', true );
		$heading_color = get_post_meta( $acc_id, 'heading_color', true );
		$heading_bgcolor = get_post_meta( $acc_id, 'heading_bgcolor', true );
		$content_color = get_post_meta( $acc_id, 'content_color', true );
		$content_bgcolor = get_post_meta( $acc_id, 'content_bgcolor', true );
		$accordion_open_one = get_post_meta( $acc_id, 'accordion_open_one', true );
		$accordion_open_one = (($accordion_open_one) ? 'radio' : 'checkbox');
        if ( !empty($accordion_meta_id) ){ ?>
			<div class="basic-accordion <?php echo $accordion_class; ?>" id="acc_<?php echo $unique_key; ?>" role="tablist">
		<?php	$i = 1;
			foreach($accordion_meta_id as $key => $value ){
				$checked = (($value['open_default']['value']) ? 'checked' : '');
			?>
				<div class="accordion_meta">
				   <input type="<?php echo $accordion_open_one; ?>" name="acc" id="acc-<?php echo $unique_key; ?>-<?php echo $key; ?>" <?php echo $checked; ?>>
				   <label style="<?php echo (($heading_color) ? 'color:'.$heading_color.';' : '' ); ?> <?php echo (($heading_bgcolor) ? 'background-color:'.$heading_bgcolor.';' : '' ); ?>" for="acc-<?php echo $unique_key; ?>-<?php echo $key; ?>"><?php echo $value['block_main_name_top']; ?></label>
				   <div class="acc-body" style="<?php echo (($content_color) ? 'color:'.$content_color.';' : '' ); ?> <?php echo (($content_bgcolor) ? 'background-color:'.$content_bgcolor.';' : '' ); ?>">
					  <?php
							$acc_text = $value['content']['value'];
							$acc_text = wp_specialchars_decode($acc_text);
							echo  do_shortcode( wpautop($acc_text) ); 
						?>
				   </div>
				</div>
		<?php
				$i++; 
			}
		?>
		</div>
		<?php
		} else {
			echo '<div class="basic-accordion">'. __('No Accordion found.', 'wp-accordions') .'</div>';
		}
	}
}


?>