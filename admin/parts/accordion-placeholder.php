<style type="text/css">
	.TB_modal { width : 100% !important; }
</style>
<script type="text/javascript">
	jQuery(function ($) {
		if (typeof tinymce !== 'undefined') {
			
			jQuery( document ).on( 'tinymce-editor-init', function( event, editor ) {
				if(tinymce.activeEditor !== 'undefined'){
					var content = editor.getContent();
					content = replaceAccordionShortcodes( content );
					editor.setContent(content);
					tinymce.activeEditor.on('GetContent', function(event){
						event.content = restoreAccordionShortcodes(event.content);
					});
					tinymce.activeEditor.on('BeforeSetcontent', function(event){
						event.content = replaceAccordionShortcodes( event.content );
					});
					tinymce.activeEditor.on('Setcontent', function(event){
						event.content = replaceAccordionShortcodes( event.content );
					});
					tinymce.activeEditor.on('DblClick',function(e) {
						var cls  = e.target.className.indexOf('ed_accordion_panel');
						if ( e.target.nodeName == 'IMG' && e.target.className.indexOf('ed_accordion_panel') > -1 ) {
							var all_attr = e.target.attributes['data-sh-attr'].value;
							all_attr = window.decodeURIComponent(all_attr);
							// console.log(all_attr);
						
							var accordion_id = getAccordionAttr(all_attr,'accordion_id');
							var accordion_class = getAccordionAttr(all_attr,'accordion_class');
	
							if($(".accordion_div_container .ed-accordion-type").length){
								$(".accordion_div_container .ed-accordion-type").val(accordion_id);
							}
							if($(".accordion_div_container .ed-accordion-class").length){
								$(".accordion_div_container .ed-accordion-class").val(accordion_class);
							}
							tb_show("HAI","##TB_inline?height=600&inlineId=wp-accordion-div-shortcode&amp;modal=true",null);
						}
					});
					// clearInterval(myInterval);
				}
			});
			
			
			$( document ).on( 'click', '.ed-insert-accordion-shortcode', function( event ) {
				event.preventDefault();
				// add to editor
				var accordion_id = accordion_class = "";
				if($(".accordion_div_container .ed-accordion-type").length){
					accordion_id = $(".accordion_div_container .ed-accordion-type").val();
				}
				if($(".accordion_div_container .ed-accordion-class").length){
					accordion_class = $(".accordion_div_container .ed-accordion-class").val();
				}
				
				
				var all_data = 'accordion_id="'+accordion_id+'" accordion_class="'+accordion_class+'"';
				window.send_to_editor('[wp_accordions '+ all_data +'][/wp_accordions]');
				$('.shortcode-accordion-form').trigger("reset");
			});
			$( document ).on( 'click', '.close_accordion_popup', function( event ) {
				event.preventDefault();
				$('.shortcode-accordion-form').trigger("reset");
				tb_remove();
			});
		}
	});
	function getAccordionAttr(s, n) {
		n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
		return n ?  window.decodeURIComponent(n[1]) : '';
	};
	function htmlAccordion( cls, data ,con) {
		var images_path = '<?php echo plugin_dir_url( __FILE__ ) . '../../assets/images/accordion.png'; ?>';
		data = window.encodeURIComponent( data );
		content = window.encodeURIComponent( con );

		return '<img src="' + images_path + '" class="mceItem ' + cls + '" ' + 'data-sh-attr="' + data + '" data-sh-content="'+ con+'" data-mce-resize="false" data-mce-placeholder="1" />';
	}

	function replaceAccordionShortcodes( content ) {
		return content.replace( /\[wp_accordions([^\]]*)\]([^\]]*)\[\/wp_accordions\]/g, function( all,attr,con) {
			return htmlAccordion( 'ed_accordion_panel', attr , con);
		});
	}
	
	function restoreAccordionShortcodes( content ) {
		return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
			var data = getAccordionAttr( image, 'data-sh-attr' );
			var con = getAccordionAttr( image, 'data-sh-content' );
			var classes = getAccordionAttr( image, 'class' );

			if ( data && classes.indexOf('ed_accordion_panel') > -1) {
				return '<p>[wp_accordions' + data + ']' + con + '[/wp_accordions]</p>';
			}
			return match;
		});
	}
	
</script>