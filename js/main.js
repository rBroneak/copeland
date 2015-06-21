/**
 * main.js v1
 * Created by Ben Gillbanks <http://www.binarymoon.co.uk/>
 * Available under GPL2 license
 */

(function($){

	$(document).ready(function(){

		if ( $.isFunction( $.fn.elementalNav ) ) {
			$('.menu ul').elementalNav();
		}

		if ( $.isFunction( $.fn.responsiveNavigation ) ) {
			$('.nav').responsiveNavigation({
				breakpoint:567
			});
		}

		$().elementalInit();

		if ( $.isFunction( $.fn.masonry ) ) {
			$( '.masonry-wrapper' ).imagesLoaded( function() {
				$( '.masonry-wrapper' ).masonry({
					itemSelector: 'article',
					gutter: 0,
					isOriginLeft: ! $( 'body' ).is( '.rtl' )
				});
			});
		}

		if ( $.isFunction( $.fn.elementalSlides ) ) {
			$('#lead-story').elementalSlides();
		}

		// resize lead story slider height based on content height
		update_lead_story_height();

		var resized = false;
		$(window).resize(function(){
			resized = true;
		});

		setInterval( function() {
			if ( resized ) {
				update_lead_story_height();
			}
			resized = false;
		}, 250 );
	});

	function update_lead_story_height() {

		var items = $('#lead-story .item');

		if ( items.length <= 1 ) {
			return;
		}

		var max_height = 0;
		items.each(function(){
			max_height = Math.max( $( this ).outerHeight( true ), max_height );
		});
		$( '#lead-story' ).css({ 'height': max_height });

	}

})(jQuery);