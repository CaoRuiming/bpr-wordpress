jQuery( document ).ready( function() {
	// Use buttonset() for radio tabs.
	jQuery( '.customize-control-radio-tab .buttonset' ).buttonset();

	// Handles setting the new value in the customizer.
	jQuery( '.customize-control-radio-tab input:radio' ).change(
		function() {
			// Get the name of the setting.
			var setting = jQuery( this ).attr( 'data-customize-setting-link' );

			// Get the value of the currently-checked radio input.
			var activeTab = jQuery( this ).val();

			// Set the new value.
			wp.customize( setting, function( obj ) {
				obj.set( activeTab );
			} );
		}
	);

} ); // jQuery( document ).ready