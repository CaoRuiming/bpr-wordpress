jQuery(document).ready(function($) {
	
	otw_form_init_fields();
});

otw_form_init_fields = function(){
	
	jQuery( '.otw-form-select' ).change( function(){
		jQuery( this ).parent().find( 'span' ).html( this.options[ this.selectedIndex ].text );
	} );
	
	var startingColour = '000000';
	jQuery( '.otw-color-selector' ).each( function(){ 
		
		var colourPicker = jQuery(this).ColorPicker({
		
		color: startingColour,
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				jQuery(colourPicker).next( 'input').change();
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery(colourPicker).children( 'div').css( 'backgroundColor', '#' + hex);
				jQuery(colourPicker).next( 'input').attr( 'value','#' + hex);
				
			}
		
		});
	});
	jQuery( '.otw-form-color-picker' ).change( function(){
		jQuery( this ).parent( 'div' ).children( 'div' ).children( 'div' ).css( 'backgroundColor', this.value );
	});
	jQuery(  '.otw-form-uploader' ).change( function(){
		otw_form_set_upload_preview_image( this.id );
	});
	jQuery(  '.otw-form-uploader-control' ).click( function( event ){
	
		var $this = jQuery(this),
		editor = $this.data('editor'),
		
		options = {
			frame:    'post',
			state:    'insert',
			title:    wp.media.view.l10n.addMedia,
			multiple: true
		};
		
		event.preventDefault();
		$this.blur();
		if ( $this.hasClass( 'gallery' ) ) {
			options.state = 'gallery';
			options.title = wp.media.view.l10n.createGalleryTitle;
		}
		wp.media.editor.insert = function( params ){
		
			var matches = null;
			
			if( matches = params.match( /src="([^\"]*)"/ ) ){
				
				jQuery( '#' + editor ).val( matches[1] );
			}else{
				jQuery( '#' + editor ).val( '' );
			}
			jQuery( '#' + editor ).change();
			
			otw_form_set_upload_preview_image( editor );
		}
		
		wp.media.editor.open( editor, options );
	} );
	jQuery(  '.otw-form-uploader-control' ).each( function(){
		otw_form_set_upload_preview_image( jQuery( this ).data( 'editor' ) );
	});
};
otw_form_set_upload_preview_image = function( element_id ){

	var previewNode = jQuery( '#' + element_id + '-preview' );
	var previewURL  = jQuery( '#' + element_id ).val();
	
	previewNode.css('background-image', 'url("' + previewURL + '")');
	previewNode.css('background-repeat', 'no-repeat');
	
};