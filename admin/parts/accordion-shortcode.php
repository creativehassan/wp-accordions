<?php 
	/* Accordion Shortcode Placeholder Render*/
	include_once('accordion-placeholder.php'); 	
?>
<div id="wp-accordion-div-shortcode" style="display:none;">
	<div class="wrap wp_doin_shortcode accordion_div_container">
		<form class="shortcode-accordion-form">
			<div style="padding:15px 15px 0 15px;">
				<h3 class="popup_heading dashicons-before dashicons-editor-justify dashicons-accordion-heading"><?php echo __( 'Accordion', $this->plugin_name ) ?> </h3>
				<p class="popup_desc"><?php echo __( 'You can choose accordion from dropdown.', $this->plugin_name ) ?></p>
				<hr />
				<div class="field-container">
					<div class="label-desc">
						<label for="wp_doin_type"><?php echo __( 'Accordion', $this->plugin_name ) ?></label>
					</div>
					<div class="content">
						<select name="ed-accordion-type" id="ed-accordion-type" class="ed-accordion-type">
						<?php
							$wp_accordions = get_posts([
							  'post_type' => 'wp-accordions',
							  'post_status' => 'publish',
							  'numberposts' => -1,
							  'order'    => 'DESC'
							]);
							
							if(!empty($wp_accordions)){
								foreach($wp_accordions as $accordion){ ?>
									<option value="<?php echo $accordion->ID ?>"><?php echo $accordion->post_title ?></option>
								<?php }
							} else { ?> 
								<option value=""><?php echo __( 'Please Create Accordion', $this->plugin_name ) ?></option>
							<?php }
						?>
						</select>
					</div>
				</div>
				<div class="field-container">
					<div class="label-desc">
						<label for="wp_doin_type"><?php echo __( 'CSS Class', $this->plugin_name ) ?></label>
					</div>
					<div class="content">
						<input name="ed-accordion-class" id="ed-accordion-class" class="ed-accordion-class cards-text" type="text" />
						<p> Example : white-accordion</p>
					</div>
				</div>
				<hr />
				<div class="field-container">
					<div class="label-desc">
						<label for="basic_doin_divider"></label>
					</div>
					<div class="content">
						<div style="padding:15px;">
							<input type="button" class="button-primary ed-insert-accordion-shortcode" id="button-primary-add" value="Insert Shortcode" />&nbsp;&nbsp;&nbsp;
							<a class="button close_accordion_popup" href="#">Cancel</a>
							<input type="reset" style="display:none;"/>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>