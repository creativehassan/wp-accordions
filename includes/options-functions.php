<?php 
/* secure */ 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>
<?php 
	function wp_accordion_get_options_ex($accordion_meta_id,$id,$c_id,$std) {
		if( !empty($accordion_meta_id) AND isset($accordion_meta_id[$c_id][$id]['value']) ){
			$get_value = $accordion_meta_id[$c_id][$id]['value'];
		}
		if( !empty($get_value) ){
			$get_value = $get_value;
		}else{
			$get_value = $std;
		}
		return $get_value;
	}
	function wp_accordion_create_opening_tag() { ?> 
	<?php }
	function wp_accordion_create_closing_tag() { ?> 
	<?php } 
	
	
	// textarea
	function accordion_textarea_option($value,$c_id,$accordion_meta_id,$name) { 
		wp_accordion_create_opening_tag();
		$op_id = $value['id'];    
		$std = $value['std'];    
		$get_value = wp_accordion_get_options_ex($accordion_meta_id,$op_id,$c_id,$std);
		?>
			<div class="row-option">
				<div class="col-1">
					<?php echo $value['name']; ?>
				</div>
				<div class="col-2">
					<input type="hidden" name="<?php echo $name ; ?>[<?php echo $c_id ; ?>][<?php echo $value['id']; ?>][key]" value="<?php echo $value['id']; ?>">
					<?php 
						$content = esc_textarea( $get_value );
						$editor_id = 'accordion_textarea_'.$c_id ;
						$settings =   array(
							'editor_height' => 200,
							'wpautop' => true, // use wpautop?
							'media_buttons' => true, // show insert/upload button(s)
							'textarea_name' => $name . '[' . $c_id . '][' . $value['id'] . '][value]', // set the textarea name to something different, square brackets [] can be used here
							'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
							'tabindex' => '',
							'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
							'editor_class' => '', // add extra class(es) to the editor textarea
							'teeny' => false, // output the minimal editor config used in Press This
							'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
							'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
							'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
						);

						 wp_editor( $content, $editor_id, $settings );
					?>
					<p class="desc"><?php echo $value['desc'];?></p>
				</div>
			</div>
		<?php
		wp_accordion_create_closing_tag();
	}
	
	// checkbox
	function accordion_checkbox_option($value,$c_id,$accordion_meta_id,$name) { 
		wp_accordion_create_opening_tag();
		$op_id = $value['id'];    
		$std = $value['std'];    
		$get_value = wp_accordion_get_options_ex($accordion_meta_id,$op_id,$c_id,$std);
		?>
			<div class="row-option">
				<div class="col-1">
					<?php echo $value['name']; ?>
				</div>
				<div class="col-2">
					<input type="hidden" name="<?php echo $name ; ?>[<?php echo $c_id ; ?>][<?php echo $value['id']; ?>][key]" value="<?php echo $value['id']; ?>">
					<input type="hidden" name="<?php echo $name ; ?>[<?php echo $c_id ; ?>][<?php echo $value['id']; ?>][value]" value="0" />
					<input type="checkbox" name="<?php echo $name ; ?>[<?php echo $c_id ; ?>][<?php echo $value['id']; ?>][value]" value="1" <?php if ( $get_value == '1'){ echo 'checked="checked"'; }?> />
					<p class="desc"><?php echo $value['desc'];?></p>
				</div>
			</div>
		<?php
		wp_accordion_create_closing_tag();
	}
	// main-repeater-function
	function wp_accordion_create_form($options, $c_id, $accordion_meta_id, $name) {
        $viewable_id = 0;
		foreach ($options as $value) {
			switch ( $value['type'] ) {
				case "textarea";
					accordion_textarea_option($value,$c_id,$accordion_meta_id,$name);
					break;
				case "checkbox";
					accordion_checkbox_option($value,$c_id,$accordion_meta_id,$name);
					break;
			}
		}
    }  
?>