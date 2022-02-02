( function( api ) {

	// Extends our custom "magbook" section.
	api.sectionConstructor['magbook'] = api.Section.extend( {

		// No magbooks for this type of section.
		attachMagbooks: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
