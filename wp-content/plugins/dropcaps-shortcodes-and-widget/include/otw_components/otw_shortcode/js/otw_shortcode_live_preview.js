jQuery(function($) {
	/*tabs layout*/
	otw_shortcode_tabs( jQuery( '#otw-shortcode-preview' ).contents().find('body').find( '.otw-sc-tabs' ) );
	otw_shortcode_tabs( jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find( '.otw-sc-tabs' ) );

	/*content toggle*/
	otw_shortcode_content_toggle( jQuery( '#otw-shortcode-preview' ).contents().find('body').find('.otw-sc-toggle > .toggle-trigger'), jQuery( '#otw-shortcode-preview' ).contents().find('body').find('.otw-sc-toggle > .toggle-trigger.closed') );
	otw_shortcode_content_toggle( jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find('.otw-sc-toggle > .toggle-trigger'), jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find('.otw-sc-toggle > .toggle-trigger.closed') );
	
	//accordions
	otw_shortcode_accordions( jQuery( '#otw-shortcode-preview' ).contents().find('body').find( '.otw-sc-accordion' )  );
	otw_shortcode_accordions( jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find( '.otw-sc-accordion' ) );
	
	//faq
	otw_shortcode_faq( jQuery( '#otw-shortcode-preview' ).contents().find('body').find( '.otw-sc-faq' )  );
	otw_shortcode_faq( jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find( '.otw-sc-faq' ) );
	
	//showdow overlay
	otw_shortcode_shadow_overlay( jQuery( '#otw-shortcode-preview' ).contents().find('body').find( '.shadow-overlay' )  );
	otw_shortcode_shadow_overlay( jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find( '.shadow-overlay' ) );
	
	//contact form
	jQuery( '#otw-shortcode-preview' ).contents().find('body').find('.otw-sc-contact-form form').submit(function() {
		return false;
	});
	jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find('.otw-sc-contact-form form').submit(function() {
		return false;
	});
	
	otw_shortcode_testimonials( jQuery( '#otw-shortcode-preview' ).contents().find('body').find( '.otw-sc-testimonials' ) );
	otw_shortcode_testimonials( jQuery( '.otw-shortcode-preview iframe' ).contents().find('body').find( '.otw-sc-testimonials' ) );
	
});