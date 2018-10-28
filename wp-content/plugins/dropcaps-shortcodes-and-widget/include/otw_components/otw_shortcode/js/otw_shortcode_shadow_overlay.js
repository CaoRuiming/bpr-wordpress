jQuery( document ).ready( function(){
	jQuery('.shadow-overlay').hover(function() {
		jQuery(this).stop().stop().animate({boxShadow: '0 0 30px 0 rgba(0,0,0,0.7)'}, 300);
	}, function(){
		jQuery(this).stop().stop().animate({boxShadow: '0 0 0 0'}, 250);
	});
} );