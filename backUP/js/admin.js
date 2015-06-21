var fonts = fonts || [];

function bm_load_css( family ) {
	
	if ( ! fonts[family].loaded && fonts[family].type > 0 ) {
		fonts[family].loaded = true;
		var font_family = fonts[family].name;
		if ( fonts[family].weight !== undefined ) {
			font_family = font_family + ':' + fonts[family].weight;
		}
		var font_uri = google_font_path + font_family.replace(' ', '+');
		jQuery("head").append('<link href="' + font_uri + '" rel="stylesheet" type="text/css">');
	}
	
}

function bm_font_family( family ) {

	var font_family = '';
	if ( fonts[family].type === 0 ) {
		font_family = fonts[family].family;
	} else {
		font_family = '"' + fonts[family].name + '", arial, serif';
	}

	return font_family;

}

jQuery(document).ready(function(){

	jQuery('.font_wrap').each(function() {
		var $this = jQuery(this);
		var font_select = $this.find('.font_face select');
		var size_select = $this.find('.font_size input');
		var font_frame = $this.find('.font_frame p');
		var base_size = parseInt( $this.data('base'), 10 );
		
		size_select.change(function() {
			var font_size = parseInt( jQuery(this).val(), 10 );
			font_frame.css( 'font-size', ( base_size + font_size ) + 'px' );
		});
		
		font_select.change(function() {
			var font_name = jQuery(this).val();
			bm_load_css(font_name);
			font_frame.each(function() {
				jQuery(this).css('font-family', bm_font_family(font_name));
			});
		});
		var font_name = font_select.val();
		bm_load_css(font_name);
		font_frame.each(function() {
			jQuery(this).css('font-family', bm_font_family(font_name));
			jQuery(this).css('font-size', ( base_size + parseInt( size_select.val(), 10 ) ) + 'px');
		});
	});
	
	jQuery('.multicheck_all').click(function(){
		var $this = jQuery(this);
		$this.parent().find('input').each(function(){
			jQuery(this).attr('checked', 'checked');
		});
		return false;
	});
	
	jQuery('.multicheck_none').click(function(){
		var $this = jQuery(this);
		$this.parent().find('input').each(function(){
			jQuery(this).attr('checked', false);
		});
		return false;
	});
	
	var bm_farbtastic = jQuery.farbtastic('#bm-colour-picker');
	var bm_colour_picker = jQuery('#bm-colour-picker');
	
	jQuery( '.colour-input' ).each(function() {
		bm_farbtastic.linkTo(this);
		jQuery(this).parent().find('.colour-default').click(function(){
			var prev_input = jQuery( this ).parent().find( '.colour-input' );
			prev_input.val( prev_input.data( 'default' ) );
			bm_farbtastic.linkTo( prev_input );
			return false;
		});
	}).focus(function() {
		var position = jQuery(this).position();
		bm_farbtastic.linkTo(this);
		bm_colour_picker.show().css({
			'top':position.top + jQuery(this).outerHeight(),
			'left':position.left
		});
	}).focusout(function() {
		bm_colour_picker.hide();
	});
	
	bm_colour_picker.hide();

});