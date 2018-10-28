/*!*********************************************************************
 * A Small Javascript function to use the Media Uploader from WordPress
 * Arnan de Gans from AJdG Solutions (http://meandmymac.net, http://www.ajdg.net)
 **********************************************************************/

/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2017 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

jQuery(document).ready(function(){
	var custom_uploader;
	jQuery('#adrotate_image_button').click(function(e) {
		e.preventDefault();
		if(custom_uploader) {
			custom_uploader.open();
			return;
		}
	
		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Banner',
			button: {
				text: 'Choose Banner'
			},
			multiple: false
		});
		
		custom_uploader.on('select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();
			jQuery('#adrotate_image').val(attachment.url);
		});
		
		custom_uploader.open();
	});
});