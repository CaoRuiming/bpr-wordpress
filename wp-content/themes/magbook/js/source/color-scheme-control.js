/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
	var cssTemplate = wp.template( 'magbook-color-scheme' ),
		colorSchemeKeys = [
		'magbook_site_page_nav_link_title_color',
		'magbook_button_color',
		'magbook_top_bar_bg_color',
		'magbook_breaking_news_color',
		'magbook_feature_news_color',
		'magbook_tag_widget_color',
		'magbook_category_box_widget_color',
		'magbook_category_box_widget_2_color',
		'magbook_bbpress_woocommerce_color',
		'magbook_category_slider_widget_color',
		'magbook_category_grid_widget_color',
		],
		colorSettings = [
		'magbook_site_page_nav_link_title_color',
		'magbook_button_color',
		'magbook_top_bar_bg_color',
		'magbook_breaking_news_color',
		'magbook_feature_news_color',
		'magbook_tag_widget_color',
		'magbook_category_box_widget_color',
		'magbook_category_box_widget_2_color',
		'magbook_bbpress_woocommerce_color',
		'magbook_category_slider_widget_color',
		'magbook_category_grid_widget_color',
		];

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {

					api( 'magbook_site_page_nav_link_title_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_site_page_nav_link_title_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_button_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_button_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_top_bar_bg_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_top_bar_bg_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_breaking_news_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_breaking_news_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_feature_news_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_feature_news_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_tag_widget_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_tag_widget_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_category_box_widget_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_category_box_widget_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_category_box_widget_2_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_category_box_widget_2_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_bbpress_woocommerce_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_bbpress_woocommerce_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_category_slider_widget_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_category_slider_widget_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

					api( 'magbook_category_grid_widget_color' ).set( colorScheme[value].colors[3] );
					api.control( 'magbook_category_grid_widget_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );

				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'color_scheme' )(), css,
			colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			colors[ setting ] = api( setting )();
		});
		// Add additional colors.
		colors.magbook_site_page_nav_link_title_color = Color( colors.magbook_site_page_nav_link_title_color ).toCSS();
		colors.magbook_button_color = Color( colors.magbook_button_color ).toCSS();
		colors.magbook_top_bar_bg_color = Color( colors.magbook_top_bar_bg_color ).toCSS();
		colors.magbook_breaking_news_color = Color( colors.magbook_breaking_news_color ).toCSS();
		colors.magbook_feature_news_color = Color( colors.magbook_feature_news_color ).toCSS();
		colors.magbook_tag_widget_color = Color( colors.magbook_tag_widget_color ).toCSS();
		colors.magbook_category_box_widget_color = Color( colors.magbook_category_box_widget_color ).toCSS();
		colors.magbook_category_box_widget_2_color = Color( colors.magbook_category_box_widget_2_color ).toCSS();
		colors.magbook_bbpress_woocommerce_color = Color( colors.magbook_bbpress_woocommerce_color ).toCSS();
		colors.magbook_category_slider_widget_color = Color( colors.magbook_category_slider_widget_color ).toCSS();
		colors.magbook_category_grid_widget_color = Color( colors.magbook_category_grid_widget_color ).toCSS();
		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize );
