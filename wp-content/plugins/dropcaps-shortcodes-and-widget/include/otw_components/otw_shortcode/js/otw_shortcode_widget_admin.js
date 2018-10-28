function otw_sw_add_shortcode( controler ){
	
	var id_matches = false;
	if( id_matches = controler.id.match( "^(.*)otw-sw-add-shortcode$" ) ){
		
		var shortcode_id = id_matches[1];
		
		var wp_url = otw_shortcode_component.wp_url;
		
		var code_object = otw_sw_get_code_object( shortcode_id );
		
		var shortcode_type = jQuery( '#' + shortcode_id + 'otw-shortcode-type' ).val();
		
		var post_data = {};
		
		if( code_object.shortcodes.length == 0 ){
			
			jQuery.post( 'admin-ajax.php?action=otw_shortcode_editor_dialog&shortcode=' + shortcode_type, { shortcode_object: post_data }, function(b){
								
								jQuery( "#otw-dialog").remove();
								var cont = jQuery( '<div id="otw-dialog">' + b + '</div>' );
								jQuery( "body").append( cont );
								jQuery( "#otw-dialog").hide();
								tb_position = function(){
									var isIE6 = typeof document.body.style.maxHeight === "undefined";
									var b=jQuery(window).height();
									jQuery("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
									if ( ! isIE6 ) { // take away IE6
										jQuery("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
									}
									jQuery( '#TB_ajaxContent' ).css( 'width', '950px' );
									jQuery( '#TB_ajaxContent' ).css( 'padding', '0' );
									
									otw_setup_html_areas();
								}
								if( typeof( otw_tb_remove ) == 'undefined' ){
									otw_tb_remove = window.tb_remove;
									tb_remove = function(){
										
										otw_close_html_areas();
										otw_tb_remove();
									}
								}
								
								jQuery( "#otw-dialog").find( '#otw-shortcode-btn-insert' ).val( otw_sw_get_label( 'Save' ) );
								jQuery( "#otw-dialog").find( '#otw-shortcode-btn-insert-bottom' ).val( otw_sw_get_label( 'Save' ) );
								
								var f=jQuery(window).width();
								b=jQuery(window).height();
								f=1000<f?1000:f;
								f-=80;
								b=760<b?760:b;
								b-=110; 
								otw_form_init_fields();
								otw_shortcode_editor = new otw_shortcode_editor_object( shortcode_type );
								otw_shortcode_editor.preview = otw_shortcode_component.shortcodes[ shortcode_type ].object.preview;
								otw_shortcode_editor.wp_url = wp_url;
								
								otw_shortcode_editor.init_fields();
								otw_shortcode_editor.shortcode_created = function( shortcode_object ){
									otw_sw_insert_code( code_object, -1, shortcode_object, shortcode_type );
								}
								tb_show( ' OTW ' + otw_shortcode_component.shortcodes[ shortcode_type ].title, "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
							} );
		
		};
		
	};
};
function otw_sw_delete( shortcode_id, shortcode_number ){

	var code_object = otw_sw_get_code_object( shortcode_id );
	
	var tmp_shortcodes = new Array();
	
	for( var cS = 0; cS < code_object.shortcodes.length; cS++ ){
	
		if( shortcode_number != cS ){
		
			tmp_shortcodes[ tmp_shortcodes.length ] = code_object.shortcodes[ cS ];
		};
	};
	code_object.shortcodes = tmp_shortcodes;
	
	otw_sw_save_code_object( code_object );
};
function otw_sw_dislpay_code( container_id ){

	var id_matches = false;
	if( id_matches = container_id.match( "^(.*)otw-sw-code$" ) ){
		
		var code_object = otw_sw_get_code_object( id_matches[1] );
		
		var shortcode_id = id_matches[1];
		
		if( typeof( code_object.shortcodes ) == 'object' ){
		
			
			var display_html = '';
			for( var cS = 0; cS < code_object.shortcodes.length; cS++ ){
				
				display_html = display_html + '<div class="otw-sw-item">';
				var display_name = code_object.shortcodes[ cS ].type;
				
				for( var cO = 0; cO < jQuery( '#' + shortcode_id + 'otw-shortcode-type'  )[0].options.length; cO++ ){
					
					if( jQuery( '#' + shortcode_id + 'otw-shortcode-type'  )[0].options[ cO ].value == display_name ){
						
						display_name = jQuery( '#' + shortcode_id + 'otw-shortcode-type'  )[0].options[ cO ].text;
						break;
					}
				}
				display_html = display_html + '<div class="otw-sw-header">';
				display_html = display_html + '<a href="javascript:;" class="otw-sw-remove" onClick="otw_sw_delete( \'' + shortcode_id + '\', ' + cS + ');"><span>' + otw_sw_get_label( 'remove' ) + '</span></a>';
				display_html = display_html + '<a href="javascript:;" class="otw-sw-edit" onClick="otw_sw_settings( \'' + shortcode_id + '\', ' + cS + ');"><span>' + otw_sw_get_label( 'settings' ) + '</span></a>';
				display_html = display_html + '</div>';
				display_html = display_html + '<div class="otw-sw-body">';
				display_html = display_html + display_name;
				display_html = display_html + '</div>';
				
				display_html = display_html + '</div>';
			};
			
			jQuery( '#' + shortcode_id + 'otw-sw-selected-shortcodes' ).html( display_html );
			
			if( code_object.shortcodes.length > 0 ){
				jQuery( '#' + shortcode_id + 'otw-sw-controls'  ).hide();
			}else{
				jQuery( '#' + shortcode_id + 'otw-sw-controls'  ).show();
			}
		};
		
	}
			

};
function otw_sw_save_code_object( code_object ){
	
	jQuery( '#' + code_object.id + 'otw-sw-code' ).val( JSON.stringify( code_object ) );
	
	otw_sw_dislpay_code( code_object.id + 'otw-sw-code' );
};
function otw_sw_get_code_object( shortcode_id ){
	
	var code_object = {};
	code_object.id = shortcode_id;
	code_object.shortcodes = new Array();
	
	
	var code_container = jQuery( '#' + shortcode_id + 'otw-sw-code' );
	
	if( code_container.size() ){
		
		var saved_object = jQuery.parseJSON( code_container.val() );
		
		if( typeof( saved_object ) == 'object' && saved_object != null ){
		
			if( typeof( saved_object.shortcodes ) == 'object' ){
				code_object.shortcodes = saved_object.shortcodes;
			};
		};
	};
	
	return code_object;
}
function otw_sw_settings( shortcode_id, shortcode_number ){
	
	if( typeof( otw_shortcode_component ) != 'object' ){
		return;
	}
	
	wp_url = otw_shortcode_component.wp_url;
	
	var code_object = otw_sw_get_code_object( shortcode_id );
	
	for( var cS = 0; cS < code_object.shortcodes.length; cS++ ){
	
		if( shortcode_number == cS ){
			
			var shortcode_type = code_object.shortcodes[ cS ].type;
			
			var post_data = {};
			for( var s_item in code_object.shortcodes[ cS ].shortcode ){
				if( typeof( code_object.shortcodes[ cS ].shortcode[ s_item ] ) != 'function' ){
					post_data[ 'otw-shortcode-element-' + s_item ] = code_object.shortcodes[ cS ].shortcode[ s_item ];
				};
			};
			
			jQuery.post( 'admin-ajax.php?action=otw_shortcode_editor_dialog&shortcode=' + shortcode_type, { shortcode_object: post_data }, function(b){
									
									jQuery( "#otw-dialog").remove();
									var cont = jQuery( '<div id="otw-dialog">' + b + '</div>' );
									jQuery( "body").append( cont );
									jQuery( "#otw-dialog").hide();
									tb_position = function(){
										var isIE6 = typeof document.body.style.maxHeight === "undefined";
										var b=jQuery(window).height();
										jQuery("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
										if ( ! isIE6 ) { // take away IE6
											jQuery("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
										}
										jQuery( '#TB_ajaxContent' ).css( 'width', '950px' );
										jQuery( '#TB_ajaxContent' ).css( 'padding', '0' );
										otw_setup_html_areas();
									}
									if( typeof( otw_tb_remove ) == 'undefined' ){
										otw_tb_remove = window.tb_remove;
										tb_remove = function(){
											
											otw_close_html_areas();
											otw_tb_remove();
										}
									}
									
									jQuery( "#otw-dialog").find( '#otw-shortcode-btn-insert' ).val( otw_sw_get_label( 'Save' ) );
									jQuery( "#otw-dialog").find( '#otw-shortcode-btn-insert-bottom' ).val( otw_sw_get_label( 'Save' ) );
									
									var f=jQuery(window).width();
									b=jQuery(window).height();
									f=1000<f?1000:f;
									f-=80;
									b=760<b?760:b;
									b-=110; 
									otw_form_init_fields();
									otw_shortcode_editor = new otw_shortcode_editor_object( shortcode_type );
									otw_shortcode_editor.preview = otw_shortcode_component.shortcodes[ shortcode_type ].object.preview;
									otw_shortcode_editor.wp_url = wp_url;
									
									otw_shortcode_editor.init_fields();
									otw_shortcode_editor.shortcode_created = function( shortcode_object ){
										otw_sw_insert_code( code_object, shortcode_number, shortcode_object, shortcode_type );
									}
									tb_show( ' OTW ' + otw_shortcode_component.shortcodes[ shortcode_type ].title, "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
								} );
			
			break;
		};
	};
};
function otw_sw_insert_code( code_object, shortcode_number, shortcode_object, shortcode_type ){
	
	if( shortcode_number == -1 ){
	
		shortcode_number = code_object.shortcodes.length;
		code_object.shortcodes[ code_object.shortcodes.length ] = {
		
			'type':  shortcode_type,
			'shortcode': {}
		
		};
	};
	
	code_object.shortcodes[ shortcode_number ].shortcode = shortcode_object;
	otw_sw_save_code_object( code_object );
	tb_remove();
};
function otw_sw_get_label( string ){
	
	if( typeof( otw_shortcode_component ) == 'object' ){
		return string;
	}
	return otw_shortcode_component.get_label( string );
}