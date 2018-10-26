jQuery(document).ready(function($) {
	var id = '1',
		initID  = 'initialize'
		preInitSaved = null;
	
	$('.color-picker').wpColorPicker();
	
	$('.handles').sortable({
		handle: 'span.move'
	});
	
	$('div.exbnda > .block-head > b.expand').unbind();
	
	$(document).on("click", '.accordion_upload-btn', function(e) {
		e.preventDefault();
        var thiss = $(this);
		var image = wp.media({ 
			title: 'Upload Image',
			// mutiple: true if you want to upload multiple files at once
			multiple: false
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			console.log(uploaded_image);
			var image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			thiss.prev('#accordion_image_url').val(image_url);
			thiss.prev('#accordion_image_url').prev('#previmg').attr("src",image_url);
		});
	}); 
    $(document).on("click", '.accordion_remove-btn', function(e) {
        $(this).prev('.accordion_upload-btn').prev('#accordion_image_url').removeAttr("value");
        $(this).prev('.accordion_upload-btn').prev('#accordion_image_url').prev('#previmg').removeAttr("src");
    });
	$(document).on("click", '.block-head > b.expand', function() {
		if ($(this).hasClass("bropped")) {
		$('.options-holder.oppened').slideUp('slow').addClass("cclossed").removeClass("oppened");
		$(this).removeClass("bropped");
		} else {
			$('.options-holder.oppened').slideUp('slow').addClass("cclossed").removeClass("oppened");
			$(this).parent('h2').next('.options-holder').slideDown('slow').addClass("oppened").removeClass("cclossed");
			$('.expand,.expand.bropped').removeClass("bropped");
			$(this).addClass("bropped");
		}
	});
	
	$('#toggle-check').click(function(e){
        $('.ecolabs').slideToggle("normal");
    });
	
	var wrapper = $(".input_fields_wrap"), //Fields wrapper
        nx = ajax_object.nx,
        mm = $('.input_fields_wrap > div:last-child').attr('id');
		if(! mm ){ var mm = "0"; };
        var x = mm.match(/\d+/),
        cvv = $('.input_fields_wrap > div:last-child').attr('id');
		if(! cvv ){ var cvv = "0"; };
        var a = cvv.match(/\d+/);
	$(document).on("click", ".add_new_field_button", function(e) { //on add input button click
		var thisbutton = $(this);
		thisbutton.prop("disabled",true);
		e.preventDefault();
		var ns = $('.input_fields_wrap > div').size();
		x++; //text box id increment
		var data = {
					'action': 'custom_accordion_data',
					'xx': x,
					'name': nx,
		};
		$('.loader-img').fadeIn();
		id = 'accordion_textarea_'+x;
		if( !preInitSaved ) {
			preInitSaved = jQuery.extend(true, {}, tinyMCEPreInit);
			// console.log(preInitSaved);
			preInitSaved.mceInit[initID].selector = '#placeholder';
			preInitSaved.mceInit['placeholder'] = preInitSaved.mceInit[initID];
			delete preInitSaved.mceInit[initID];

			preInitSaved.qtInit[initID].id = 'placeholder';
			preInitSaved.qtInit['placeholder'] = preInitSaved.qtInit[initID];
			delete preInitSaved.qtInit[initID];
		}
		jQuery.post(ajax_object.ajax_url, data, function(data) {
			$(wrapper).append(data);
				setTimeout( function() {
					// console.log(tinymce);
					if (typeof tinymce !== 'undefined') {
						rebuild = jQuery.extend(true, {}, preInitSaved);

						rebuild.mceInit['placeholder'].selector = '#' + id;
						rebuild.mceInit[id] = rebuild.mceInit['placeholder'];
						delete rebuild.mceInit['placeholder'];

						rebuild.qtInit['placeholder'].id = id;
						rebuild.qtInit[id] = rebuild.qtInit['placeholder'];
						delete rebuild.qtInit['placeholder'];

						init = rebuild.mceInit[id];

						$wrap = tinymce.$( '#wp-' + id + '-wrap' );

						// if ( ( $wrap.hasClass( 'tmce-active' ) || ! rebuild.qtInit.hasOwnProperty( id ) ) && ! init.wp_skip_init ) {

							tinymce.init( init );

							if ( ! window.wpActiveEditor ) {
								window.wpActiveEditor = id;
							}
							
						// }

						if ( typeof quicktags !== 'undefined' ) {
							
							quicktags( rebuild.qtInit );

							if ( ! window.wpActiveEditor ) {
								window.wpActiveEditor = id;
							}

							QTags( {'id': id } );
							QTags._buttonsInit();
						}
					}
					$('.loader-img').fadeOut();
					// getall();
					thisbutton.prop("disabled",false);
				}, 1200);   
		});
	});
	$(document).on("click", ".remove_field", function(e) { //user click on remove text
		e.preventDefault();
		if($(this).closest('div').parent().find(".main-block").length > 1){
			$(this).closest('div').remove();
			x++; //text box id increment
		}
	});
	// getall();
});