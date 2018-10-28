function otw_shortcode_object(){
	
	this.shortcodes = {};
	
	this.labels = {};
	
	this.wp_url = '';
	
	this.dropdown_menu = false;
	
}
otw_shortcode_object.prototype.open_drowpdown_menu = function( append_to ){
	
	this.dropdown_menu = jQuery( '#otw_shortcode_dropdown_menu' );
	
	if( !this.dropdown_menu.size() ){
	
		var links = '<div id=\"otw_shortcode_dropdown_menu\">';
		
		links = links + '<ul>';
		
		for( var shortcode in this.shortcodes ){
			
			if( this.shortcodes[ shortcode ].enabled && !this.shortcodes[ shortcode ].parent ){
				
				if( this.shortcodes[ shortcode ].children ){
					
					links = links + '<li class="otw-shortcode-dropdown-item-parent" ><a class="otw-shortcode-dropdown-parent">' + this.shortcodes[ shortcode ].title + '</a>';
					
					links = links + '<ul class="otw-shortcode-dropdown-level1">';
					
					for( var cC = 0; cC < this.shortcodes[ shortcode ].children.length; cC++ ){
						
						var sub_shortcode = this.shortcodes[ shortcode ].children[ cC ]
						
						links = links + '<li><a class="otw-shortcode-dropdown-action-' + sub_shortcode + '">' + this.shortcodes[ sub_shortcode ].title + '</a></li>';
					}
					links = links + '</ul>';
					
					links = links + '</li>';
					
				}else{
					links = links + '<li><a class="otw-shortcode-dropdown-action-' + shortcode + '">' + this.shortcodes[ shortcode ].title + '</a></li>';
				}
			};
		};
		links = links + '<li class="otw-dropdown-line"><a class="otw-shortcode-dropdown-action-close">' + this.get_label( 'Close' ) + '</a></li>';
		
		links = links + '</ul>';
		
		links = links + '</div>';
		
		this.dropdown_menu = jQuery( links );
		
		this.init_dropdown_actions();
		
		this.dropdown_menu.appendTo( jQuery( 'body' ) );
	}
	else
	{
		this.dropdown_menu.hide();
	}
	var link = jQuery( append_to );
	
	var link_height = link.outerHeight();
	
	this.dropdown_menu.css("top", link.offset().top + link_height );
	
	var dropdown_right_postion = link.offset().left + this.dropdown_menu.width();
	
	if( ( dropdown_right_postion ) > jQuery(document).width() ){
		this.dropdown_menu.css("left", link.offset().left - this.dropdown_menu.width() + link.width() );
	}else{
		this.dropdown_menu.css("left", link.offset().left );
	};
	
	this.dropdown_menu.slideDown(100);
	this.dropdown_menu.show();
};

otw_shortcode_object.prototype.insert_code = function( shortcode_object ){
	
};

otw_shortcode_object.prototype.init_dropdown_actions = function(){
	
	with( this ){
	
		jQuery( 'body' ).click( function( event ){
		
			var close_it = true;
			
			if( jQuery( event.target ).parents( '.mce-btn' ).attr( 'data-otwkey' ) == otw_shortcode_component.tinymce_button_key ){
				close_it = false
			};
			if( jQuery( event.target ).parents( '.mce_' + otw_shortcode_component.tinymce_button_key ).size() ){
				close_it = false;
			};
			if( jQuery( event.target ).hasClass( 'otw-column-control-add' ) ){
				close_it = false;
			};
			if( jQuery( event.target ).parents( '#otw_shortcode_dropdown_menu' ).size() ){
				close_it = false;
			};
			if( close_it && dropdown_menu.css( 'display' ) == 'block' ){
				dropdown_menu.hide();
			};
		} );
		
		dropdown_menu.find( 'a' ).click( function(){
			
			var class_name = jQuery( this ).attr( 'class' );
			
			if( class_name ){
				
				var matches = false;
				if( matches = jQuery( this ).attr( 'class' ).match( /^otw\-shortcode\-dropdown\-action\-([a-zA-Z0-9_\-]+)$/ ) ){
					
					switch( matches[1] ){
						
						case 'close':
								dropdown_menu.hide();
							break;
						default:
								jQuery.get( wp_url + '.php?action=otw_shortcode_editor_dialog&shortcode=' + matches[1],function(b){
									
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
									var f=jQuery(window).width();
									b=jQuery(window).height();
									f=1000<f?1000:f;
									f-=80;
									/*b-=84;*/
									b=760<b?760:b;
									b-=110; 
									otw_form_init_fields();
									otw_shortcode_editor = new otw_shortcode_editor_object( matches[1] );
									otw_shortcode_editor.preview = shortcodes[ matches[1] ].object.preview;
									otw_shortcode_editor.wp_url = wp_url;
									
									otw_shortcode_editor.init_fields();
									
									otw_shortcode_editor.shortcode_created = function( shortcode_object ){
										insert_code( shortcode_object );
									}
									tb_show( get_label( 'Insert' ) + ' OTW ' + shortcodes[ matches[1] ].title, "#TB_inline?width="+f+"&height="+b+"&inlineId=otw-dialog" );
									
								} );
								dropdown_menu.hide();

							break;
					};
				};
			};
		} );
	};
};

otw_shortcode_object.prototype.get_label = function( label ){

	if( this.labels[ label ] ){
		return this.labels[ label ];
	};
	
	return label;
};
otw_shortcode_editor_object = function( type ){
	
	this.fields = {};
	
	this.shortcode_type = type;
	
	this.preview = 'iframe';
	
	this.code = '';
	
	this.wp_url = '';
	
	this.init_action_buttons();
	
	this.init_html_areas();
};
function otw_close_html_areas(){

	var areas = jQuery( '.otw-html-area-holder' );
	
	for( var cA = 0; cA < areas.size(); cA++ ){
		
		var id_matches = false;
		
		if( id_matches = areas[cA].id.match( /^otw\-shortcode\-element\-(.*)\-holder$/ ) ){
			
			var editor_node = jQuery( '#otw-shortcode-element-' + id_matches[1] + '_tmce-form-control' )
			
			editor_node.hide();
		}
	}
}
function otw_setup_html_areas(){

	var areas = jQuery( '.otw-html-area-holder' );
	
	if( jQuery( '#TB_window' ).size() ){
		
		for( var cA = 0; cA < areas.size(); cA++ ){
			
			var id_matches = false;
			
			if( id_matches = areas[cA].id.match( /^otw\-shortcode\-element\-(.*)\-holder$/ ) ){
				
				var editor_node = jQuery( '#otw-shortcode-element-' + id_matches[1] + '_tmce-form-control' )
				
				var ivalue = jQuery( '#otw-shortcode-element-' + id_matches[1] ).val();
				
				jQuery( '#TB_ajaxContent' ).css( 'overflow', 'visible' );
				
				editor_node.css( 'position', 'fixed' );
				editor_node.css( 'display', 'block' );
				editor_node.css( 'top', ( jQuery( '#TB_window' ).position().top - ( TB_HEIGHT / 2  ) ) + jQuery( areas[cA] ).position().top + 20 + 'px' );
				editor_node.css( 'left', ( jQuery( '#TB_window' ).offset().left + 40 )  + 'px');
				editor_node.css( 'z-index', '4000000' );
				
				if( typeof tinymce != "undefined" ) {
					
					var editor = tinymce.get( 'otw-shortcode-element-' + id_matches[1] + '_tmce' );
					
					if( editor && editor instanceof tinymce.Editor ) {
						
						var editor = tinymce.get( 'otw-shortcode-element-' + id_matches[1] + '_tmce' );
						editor.setContent( ivalue );
						
						if( jQuery( '#otw-shortcode-element-' + id_matches[1] ).attr( 'data-loaded' ) != 1 ){
							
							editor.onChange.add( function(){
								jQuery( '#otw-shortcode-element-' + id_matches[1] ).val( editor.getContent() );
								otw_shortcode_editor.live_preview();
							} );
						}
						editor.save( { no_events: true } );
						jQuery( '#otw-shortcode-element-' + id_matches[1] ).attr( 'data-loaded', 1 );
						
					}else{
						jQuery( '#otw-shortcode-element-' + id_matches[1]  + '_tmce' ).val( ivalue );
					}
					jQuery( '#otw-shortcode-element-' + id_matches[1]  + '_tmce' ).unbind( 'change' );
					jQuery( '#otw-shortcode-element-' + id_matches[1]  + '_tmce' ).change( function(){
					
						var editor = tinymce.get( 'otw-shortcode-element-' + id_matches[1] + '_tmce' );
						
						jQuery( '#otw-shortcode-element-' + id_matches[1] ).val( this.value );
						otw_shortcode_editor.live_preview();
					} );
					
					if( jQuery( '#otw-shortcode-element-' + id_matches[1] ).attr( 'data-loaded' ) != 1 ){
						
						jQuery( '#wp-otw-shortcode-element-' + id_matches[1]  + '_tmce-wrap' ).bind( 'DOMSubtreeModified', function(){
						
							if( jQuery( '#otw-shortcode-element-' + id_matches[1] ).attr( 'data-loaded' ) != 1 ){
								var editor = tinymce.get( 'otw-shortcode-element-' + id_matches[1] + '_tmce' );
								
								if( editor && editor instanceof tinymce.Editor ) {
									editor.onChange.add( function(){
										jQuery( '#otw-shortcode-element-' + id_matches[1] ).val( editor.getContent() );
										otw_shortcode_editor.live_preview();
									} );
									jQuery( '#otw-shortcode-element-' + id_matches[1] ).attr( 'data-loaded', 1 );
								}
							}
						});
					}
				}
				
			}
		}
	}
}
otw_shortcode_editor_object.prototype.init_html_areas = function(){
	
	return;
	var areas = jQuery( '.otw-html-area' );
	
	for( var cA = 0; cA < areas.size(); cA++ ){
	
		var textfield_id = areas[ cA ].value;
		
		if( jQuery( '#' + textfield_id ).size() ){
		
		/*
			if( typeof( window.tinyMCEPreInit ) != 'undefined' ){
				
				
				window.tinyMCEPreInit.mceInit[textfield_id] = {};
				var init = window.tinyMCEPreInit.mceInit[textfield_id] = tinymce.extend( {}, tinyMCEPreInit.mceInit[ 'content' ] );//new
				window.tinyMCEPreInit.mceInit[textfield_id].selector = '#'+textfield_id;
				window.tinyMCEPreInit.mceInit[textfield_id].external_plugins = {};
				window.tinyMCEPreInit.mceInit[textfield_id].setup = function(ed) {
					ed.onChange.add(function(ed, l) {
						jQuery( '#' + textfield_id ).val( l.content );
						jQuery( '#' + textfield_id ).change();
						});
					};
				wrapper = tinymce.DOM.select( '#wp-' + textfield_id + '-wrap' )[0];
				
				
				
				window.tinyMCEPreInit.qtInit[textfield_id]=_.extend({},tinyMCEPreInit.qtInit['replycontent'],{id:textfield_id})
				qt=quicktags(window.tinyMCEPreInit.qtInit[textfield_id]);
				QTags._buttonsInit();
				
				if ( ( tinymce.DOM.hasClass( wrapper, 'tmce-active' ) || ! tinyMCEPreInit.qtInit.hasOwnProperty( textfield_id ) ) ) {

						try {
							tinymce.init( init );

							if ( ! window.wpActiveEditor ) {
								window.wpActiveEditor = edId;
							}
						} catch(e){}
					}
				
				window.switchEditors.go(textfield_id,'tmce');
				
				tinymce.execCommand('mceAddControl', false, textfield_id);
				
			}
			*/
//			window.tinyMCEPreInit.mceInit[textfield_id]=_.extend({},tinyMCEPreInit.mceInit['content']);
			if( typeof( window.tinyMCEPreInit ) != 'undefined' ){
			
				window.tinyMCEPreInit.mceInit[textfield_id]={};
				window.tinyMCEPreInit.mceInit[textfield_id] = tinymce.extend( {}, tinyMCEPreInit.mceInit[ 'content' ] );//new
				
				try { tinymce.init( window.tinyMCEPreInit.mceInit[textfield_id] ); } catch(e){ }//new
				window.tinyMCEPreInit.qtInit[textfield_id]=_.extend({},tinyMCEPreInit.qtInit['replycontent'],{id:textfield_id})
				qt=quicktags(window.tinyMCEPreInit.qtInit[textfield_id]);
				QTags._buttonsInit();
				window.switchEditors.go(textfield_id,'html');
			}
		}
	};
};
otw_shortcode_editor_object.prototype.init_action_buttons = function(){
	
	with( this ){
		
		jQuery( '#otw-shortcode-btn-cancel' ).click( function(){
			tb_remove();
		});
		
		jQuery( '#otw-shortcode-btn-insert' ).click( function(){
			
			get_code();
		} );
		
		jQuery( '#otw-shortcode-btn-cancel-bottom' ).click( function(){
			tb_remove();
		});
		
		jQuery( '#otw-shortcode-btn-insert-bottom' ).click( function(){
			
			get_code();
		} );
	};
};

otw_shortcode_editor_object.prototype.live_reload = function(){
	
	var s_code = this.get_values();
	
	var matches = false;
	var post_id = 0;
	if( matches = location.href.match( /post\=([0-9]+)/ ) ){
		post_id = matches[1];
	}
	with( this ){
		
		jQuery( '.otw-shortcode-editor-preview' ).html( 'Loading, please wait...' );
		
		var save_button_value = jQuery( '#TB_ajaxContent' ).find( '#otw-shortcode-btn-insert' ).val();
		
		jQuery.post( wp_url + '.php?action=otw_shortcode_live_reload&shortcode=' + this.shortcode_type , { 'shortcode': s_code, 'post': post_id }, function( response ){
			
			jQuery( '#TB_ajaxContent' ).html( response );
			
			otw_form_init_fields();
			
			fields = {};
			
			code = '';
			
			init_fields();
			
			init_action_buttons();
			
			jQuery( '#TB_ajaxContent' ).find( '#otw-shortcode-btn-insert' ).val( save_button_value );
			jQuery( '#TB_ajaxContent' ).find( '#otw-shortcode-btn-insert-bottom' ).val( save_button_value );
		});
	}
};
otw_shortcode_editor_object.prototype.live_preview = function(){
	
	if( !jQuery( '.otw-shortcode-editor-preview' ).size() ){
		return ;
	};
	if( this.preview != 'iframe' ){
		var preview_html = '<div id="otw-shortcode-preview"></div>';
	}else{
		var preview_html = '<iframe width="100%" scrolling="no" id="otw-shortcode-preview"></iframe>';
	}
	jQuery( '.otw-shortcode-editor-preview' ).html( preview_html );
	
	var s_code = this.get_values();
	
	var matches = false;
	var post_id = 0;
	if( matches = location.href.match( /post\=([0-9]+)/ ) ){
		post_id = matches[1];
	}
	
	with( this ){
		
		jQuery.post( wp_url + '.php?action=otw_shortcode_live_preview&shortcode=' + this.shortcode_type , { 'shortcode': s_code, 'post': post_id }, function( response ){
			
			if( preview != 'iframe' ){
				
				jQuery( '#otw-shortcode-preview' ).height(jQuery('#TB_ajaxContent').height() - 150 );
				jQuery( '#otw-shortcode-editor-buttons' ).show();
				
				jQuery( '#otw-shortcode-preview' ).html( response );
				jQuery( '#otw-shortcode-preview' ).find('a,input').click( function( event ){
					event.stopPropagation();
					return false;
				});
				jQuery( '#otw-shortcode-preview' ).css( 'overflow', 'hidden' );
				jQuery( '.otw-shortcode-editor-preview' ).fadeIn();
				
				jQuery( '#TB_ajaxContent' ).scroll( function(){
					jQuery( '#otw-shortcode-preview' ).parents( '.otw-shortcode-editor-preview-container' ).css( 'padding-top', this.scrollTop + 'px');
				});
				
				if( typeof( twttr ) == 'object' ){
					twttr.widgets.load();
				};
			}else{
				jQuery( '#otw-shortcode-preview' ).height(jQuery('#TB_ajaxContent').height() - 150 );
				jQuery( '#otw-shortcode-editor-buttons' ).show();
				jQuery( '#otw-shortcode-preview' ).contents().find('body').html( '' );
				jQuery( '#otw-shortcode-preview' ).contents().find('body').append(response);
				jQuery( '#otw-shortcode-preview' ).contents().find('body')[0].style.border=  'none';
				jQuery( '#otw-shortcode-preview' ).contents().find('body')[0].style.background =  'none';
				jQuery( '#otw-shortcode-preview' ).contents().find('body')[0].style.padding =  '0';
				jQuery( '#otw-shortcode-preview' ).contents().find('a,input').click( function( event ){
					event.stopPropagation();
					return false;
				});
				jQuery( '.otw-shortcode-editor-preview' ).fadeIn();
				
				jQuery( '#TB_ajaxContent' ).scroll( function(){
					jQuery( '#otw-shortcode-preview' ).parents( '.otw-shortcode-editor-preview-container' ).css( 'padding-top', this.scrollTop + 'px');
				});
			}
		});
	}
};

otw_shortcode_editor_object.prototype.shortcode_error = function( errors ){
	
	var error_html = '<div class=\"otw-shortcode-editor-error\" >';
	
	for( var cE = 0; cE < errors.length; cE++){
	
		error_html = error_html + '<p>' + errors[ cE ]  + '</p>';
	}
	
	error_html = error_html + '</div>';
	
	jQuery( '.otw-shortcode-editor-preview' ).html( error_html );
}

otw_shortcode_editor_object.prototype.get_values = function(){

	v_code = {};
	v_code.shortcode_code = '';
	v_code.shortcode_type = this.shortcode_type;
	
	for( var field in otw_shortcode_editor.fields ){
	
		var matches = false;
		if( matches = field.match( /^otw\-shortcode\-element\-([a-z0-9\_\-]+)$/ ) ){
			
			switch( otw_shortcode_editor.fields[ field ].element_type ){
				
				case 'checkbox':
						
						if( otw_shortcode_editor.fields[ field ].element[0].checked == true ){
							v_code[ matches[1] ] = otw_shortcode_editor.fields[ field ].current_value;
						}else{
							v_code[ matches[1] ] = '';
						}
					break;
				case 'text_area':
						
						if( ( otw_shortcode_editor.fields[ field ].element.attr( 'data-type' ) == 'tmce' ) && ( otw_shortcode_editor.fields[ field ].element.attr( 'data-loaded' ) == 1 ) ){
						
							if( tinyMCE.get( 'otw-shortcode-element-' + matches[1] + '_tmce' ) != null ){
								
								var textArea = jQuery( '#otw-shortcode-element-' + matches[1] + '_tmce' );
								
								if( ( textArea.length > 0 ) && textArea.is(':visible') ){
									v_code[ matches[1] ] = textArea.val();
								}else{
									v_code[ matches[1] ] = tinyMCE.get( 'otw-shortcode-element-' + matches[1] + '_tmce' ).getContent();
								}
								otw_shortcode_editor.fields[ field ].element.val( v_code[ matches[1] ] );
								
							}else if( jQuery( '#otw-shortcode-element-' + matches[1] + '_tmce' ).size() ){
								
								v_code[ matches[1] ] = jQuery( '#otw-shortcode-element-' + matches[1] + '_tmce' ).val();
								otw_shortcode_editor.fields[ field ].element.val( v_code[ matches[1] ] );
							}else{
								
								v_code[ matches[1] ] = otw_shortcode_editor.fields[ field ].current_value;
							}
							
						}else{
							v_code[ matches[1] ] = otw_shortcode_editor.fields[ field ].current_value;
						}
					break;
				default:
						v_code[ matches[1] ] = otw_shortcode_editor.fields[ field ].current_value;
					break;
			};
		}else if( field == 'otw_item_id' ){
			v_code.otw_item_id = otw_shortcode_editor.fields[ field ].current_value;
		}
	};
	
	return v_code;
};

otw_shortcode_editor_object.prototype.get_code = function(){
	
	this.code = this.get_values();
	
	with( this ){
		//here make request to get the code validated
		
		if( !wp_url ){
			wp_url = 'admin-ajax';
		}
		
		jQuery.post( wp_url + '.php?action=otw_shortcode_get_code&shortcode=' + this.shortcode_type , this.code, function( response ){
			
			var response_code = jQuery.parseJSON( response );
			
			if( !response_code.has_error ){
				code.shortcode_code = response_code.code;
				
				if( typeof( response_code.shortcode_attributes ) != 'undefined' ){
				
					for( var sA in response_code.shortcode_attributes ){
					
						code[ sA ] = response_code.shortcode_attributes[ sA ];
					}
				}
				shortcode_created( code );
			}else{
				shortcode_error( response_code.errors );
			};
		});
	};
};

otw_shortcode_editor_object.prototype.init_fields = function(){
	
	//collect inputs
	with( this ){
		jQuery( '.otw-shortcode-editor-fields' ).find( 'input[type=text]' ).each( function(){
		
			var element = jQuery( this );
			
			if( element.attr( 'id' ) ){
				fields[ element.attr( 'id' ) ] = new otw_shortcode_editor_element( 'text_input', element );
			}
			element.change( function(){
				live_preview();
			});
		} );
		jQuery( '.otw-shortcode-editor-fields' ).find( 'input[type=hidden]' ).each( function(){
		
			var element = jQuery( this );
			
			if( element.attr( 'id' ) ){
				fields[ element.attr( 'id' ) ] = new otw_shortcode_editor_element( 'hidden_input', element );
			}
		} );
		jQuery( '.otw-shortcode-editor-fields' ).find( 'input[type=checkbox]' ).each( function(){
		
			var element = jQuery( this );
			
			if( element.attr( 'id' ) ){
				fields[ element.attr( 'id' ) ] = new otw_shortcode_editor_element( 'checkbox', element );
			}
			element.change( function(){
				live_preview();
			});
		} );
		jQuery( '.otw-shortcode-editor-fields' ).find( 'select' ).each( function(){
		
			var element = jQuery( this );
			
			if( element.attr( 'id' ) ){
				fields[ element.attr( 'id' ) ] = new otw_shortcode_editor_element( 'select', element );
			}
			element.change( function(){
				if( jQuery( this ).attr( 'data-reload' ) == '1' ){
					live_reload();
				}else{
					live_preview();
				}
			});
		} );
		jQuery( '.otw-shortcode-editor-fields' ).find( 'textarea' ).each( function(){
		
			var element = jQuery( this );
			
			if( element.attr( 'id' ) ){
				fields[ element.attr( 'id' ) ] = new otw_shortcode_editor_element( 'text_area', element );
			}
			element.change( function(){
				live_preview();
			});
		} );

	};
	
	this.live_preview();
};

otw_shortcode_editor_element = function( element_type, element ){
	
	this.element_type = element_type;
	
	this.element = element;
	
	this.initial_value = this.element.val();
	
	this.current_value = this.initial_value;
	
	this.is_changed = false;
	
	with( this ){
		element.change( function(){
			
			current_value = element.val();
			
			if( current_value != initial_value ){
				is_changed = true;
			}else{
				is_changed = false;
			}
		} );
	};
};

otw_shortcode_component = null;
otw_shortcode_editor = null;