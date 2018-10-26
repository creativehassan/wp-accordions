jQuery(document).ready(function($) {
	var $target = '';
	var openHashAccordion = function(){
		if (window.location.hash) {
			$target = $('body').find(window.location.hash);
			if ($target.length) {
				$target = $('body').find(window.location.hash).parent();
				setTimeout(function(){
					$('a[href="'+window.location.hash+'"]').trigger('click');
					$('html,body').animate({ scrollTop: $target.offset().top - 50  }, 50, 'swing');
				}, 1000)
			}
		} else {
			setTimeout(function(){
				$('.card-accordion').each(function(){
					$(this).find('.card:first a[data-toggle="collapse"]').trigger('click');
				});
			}, 1000)
			
		}
	}
	$('p:empty').remove();
	
	openHashAccordion();
});



