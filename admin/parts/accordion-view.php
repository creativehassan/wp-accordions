<?php 
global $wpdb;
$lists = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "accordions WHERE post_id = " . $post->ID . " ORDER BY post_order ASC" );

?>
<style type="text/css">
.check-column{
	padding: 8px 10px !important;
}
</style>
<!-- Now we can render the completed list table -->
<table class="widefat fixed wp_accorion_tabled" cellspacing="0" style="padding: 20px;">
	<thead>
	<tr>
		<th style="width:80%;"  id="columnname" class="manage-column column-columnname" scope="col"><?php echo __( 'Title', 'wp-accordions' ); ?></th>
		<th id="columnname" class="manage-column column-columnname" scope="col"><?php echo __( 'Action', 'wp-accordions' ); ?></th>
	</tr>
	</thead>

	<tfoot>
	<tr>
		<th style="width:80%;" id="columnname" class="manage-column column-columnname" scope="col"><?php echo __( 'Title', 'wp-accordions' ); ?></th>
		<th id="columnname" class="manage-column column-columnname" scope="col"><?php echo __( 'Action', 'wp-accordions' ); ?></th>
	</tr>
	</tfoot>

	<tbody>
	<?php
	if(!empty($lists)){
		foreach($lists as $key => $list){ ?>
			<tr class="alternate aid-<?php echo $list->aid; ?>" id="aid-<?php echo $list->aid; ?>" data-aid="<?php echo $list->aid; ?>">
				<td style="width:80%;" class="check-column" scope="row"> <span class="accordion-title"><?php echo $list->acc_title; ?></span><span class="accordion-description" style="display:none;"><?php echo $list->acc_text; ?> </span>
				</td>
				<td class="column-columnname">
					<span><a href="" class="edit-accordion-it edit-accordion-it-<?php echo $list->aid; ?>" data-aid="<?php echo $list->aid; ?>" title="Update Button"><?php echo __( 'Edit', 'wp-accordions' ); ?> </a></span> |
					<span><a href="#" class="remove-accordion-it" data-aid="<?php echo $list->aid; ?>" ><?php echo __( 'Remove', 'wp-accordions' ); ?> </a></span>
					<div class="spinner"></div>
				</td>
			</tr>
			<?php
		}
	} else {
		echo '<tr class="no-items"><td class="colspanchange" colspan="2">'. __('No Record found.', 'wp-accordions') .'</td></tr>';
	}
	?>
	</tbody>
</table>