jQuery( document ).ready( function(){
	jQuery(".otw-sc-message.closable-message").find(".close-message").click(function() {
		jQuery(this).parent(".otw-sc-message").fadeOut("fast");
	});
} );