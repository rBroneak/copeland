(function ($) {

	var isiOS = navigator.userAgent.match(/iPad|iPhone|iPod/i) != null;

	// DROP DOWN MENUS
	$.fn.elementalNav = function( options ) {
		var defaults = {};
		options = $.extend(defaults, options);

		return this.each(function () {
			var $this = $(this);

			$this.find('li')[($.fn.hoverIntent) ? 'hoverIntent' : 'hover'](function(){
				$(this).addClass('hover');
				$('ul:first',this).stop(true, true).fadeIn(100);
			}, function(){
				$(this).removeClass('hover');
				$('ul:first',this).delay(300).fadeOut(100);
			});

			$this.find('li:has(ul)').find('a:first').addClass('has-children');
		});
	};

	$.fn.elementalInit = function() {

		// remove hover on touch devices
		if ( isiOS ) {
			$('body').children().on('click', $.noop);
		}

	};

	function _get_title(e) {
		return e.attr('title') || e.data('title');
	}

	function _get_breakpoint() {
		return $('body').data('breakpoint') || 320;
	}

})(jQuery);