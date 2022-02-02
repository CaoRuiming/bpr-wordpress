jQuery(document).ready(function() {
	
	jQuery('.site-title a').focus(function() {
		jQuery('.core-blog-search').hide('slow'); //hide the button
	});
});