<?php
global $otw_components;
/**
 *  Load component
 *  @param string component
 *  @param string version. If false will load the latest version available
 *  @param boolean
 *  @return void
 **/
if (!function_exists( "otw_load_component" )){
	function otw_load_component( $component_name, $version = false, $new_instance = false ){
		global $otw_components;
		
		if( isset( $otw_components['registered'][ $component_name ] ) ){
			
			if( !$version ){
				
				foreach( $otw_components['registered'][ $component_name ] as $c_version => $c_path ){
					
					if( !$version || ( $version < $c_version ) ){
						$version = $c_version;
					}
				}
			}
			
			if( isset( $otw_components['registered'][ $component_name ][ $version ] ) ){
				
				if( !isset( $otw_components['loaded'][ $component_name ] ) ){
					$otw_components['loaded'][ $component_name ] = array();
				}
				
				if( !isset( $otw_components['loaded'][ $component_name ][ $version ] ) ){
					$otw_components['loaded'][ $component_name ][ $version ] = array();
					$otw_components['loaded'][ $component_name ][ $version ]['version'] = $version;
					$otw_components['loaded'][ $component_name ][ $version ]['path']    = $otw_components['registered'][ $component_name ][ $version ]['path'];
					$otw_components['loaded'][ $component_name ][ $version ]['url']     = $otw_components['registered'][ $component_name ][ $version ]['url'];
					$otw_components['loaded'][ $component_name ][ $version ]['usage']   = array();
					$otw_components['loaded'][ $component_name ][ $version ]['objects'] = array();
					
				}
				$otw_component_key = 0;
				if( count( $otw_components['loaded'][ $component_name ][ $version ]['objects'] ) ){
					
					if( $new_instance ){
						
						if( !class_exists( 'OTW_Component' ) ){
							include_once( dirname( $otw_components['loaded'][ $component_name ][ $version ]['path'] ).'/otw_functions/otw_component.class.php' );
						}
						
						include_once( $otw_components['loaded'][ $component_name ][ $version ]['path'].$component_name.'.class.php' );
						$otw_component_key = count( $otw_components['loaded'][ $component_name ][ $version ]['objects'] ) + 1;
						$otw_components['loaded'][ $component_name ][ $version ]['objects'][ $otw_component_key ] = new $otw_components['registered'][ $component_name ][ $version ]['class_name'];
					}else{
						$otw_component_key = 1;
					}
				}else{
					
					if( !class_exists( 'OTW_Component' ) ){
						include_once( dirname( $otw_components['loaded'][ $component_name ][ $version ]['path'] ).'/otw_functions/otw_component.class.php' );
					}
					
					include_once( $otw_components['loaded'][ $component_name ][ $version ]['path'].$component_name.'.class.php' );
					$otw_component_key = 1;
					$otw_components['loaded'][ $component_name ][ $version ]['objects'][ $otw_component_key ] = new $otw_components['registered'][ $component_name ][ $version ]['class_name'];
				}
				$otw_components['loaded'][ $component_name ][ $version ]['usage'][] = __FILE__;
				
				$otw_components['loaded'][ $component_name ][ $version ]['objects'][ $otw_component_key ]->add_settings( $otw_components['loaded'][ $component_name ][ $version ] );
				
				return array( 'name' => $component_name, 'version' => $version, 'key' => $otw_component_key );
			}
		}
		else{
			wp_die( 'OTW Component '.$component_name.' is not registered.' );
		}
	}
}

/**
 *  Register component
 *  @param string component
 *  @param string component_path
 *  @return void
 **/
if (!function_exists( "otw_register_component" )){
	function otw_register_component( $component_name, $component_path, $component_url ){
		global $otw_components;
		
		if( !is_array(  $otw_components ) ){
			$otw_components = array();
		}
		
		if( !isset(  $otw_components['registered'] ) ){
			$otw_components['registered'] = array();
		}
		
		if( !isset(  $otw_components['loaded'] ) ){
			$otw_components['loaded'] = array();
		}
		
		//check if requested component exists
		@include( $component_path.$component_name.'.info.php' );
		
		if( isset( $otw_component['version'] ) ){
			
			if( !isset( $otw_components['registered'][ $component_name ] ) ){
				$otw_components['registered'][ $component_name ] = array();
			}
			if( !isset( $otw_components['registered'][ $component_name ][ $otw_component['version'] ] ) ){
				$otw_components['registered'][ $component_name ][ $otw_component['version'] ] = array();
				$otw_components['registered'][ $component_name ][ $otw_component['version'] ]['path'] = $component_path;
				$otw_components['registered'][ $component_name ][ $otw_component['version'] ]['url']  = $component_url;
				$otw_components['registered'][ $component_name ][ $otw_component['version'] ]['class_name'] = $otw_component['class_name'];
			}
		}else{
			wp_die( 'Component '.$component_name.' does not exists.' );
		}
	}
}
/**
 *  Return object of loaded component
 *  @param array component
 *  @return object
 **/
if (!function_exists( "otw_get_component" )){
	function otw_get_component( $component ){
		global $otw_components;
		
		if( isset( $component['name'] ) && isset( $component['version'] ) && isset( $component['key'] )  ){
			
			if( isset( $otw_components['loaded'][ $component['name'] ] ) && isset( $otw_components['loaded'][ $component['name'] ][ $component['version'] ] ) && isset( $otw_components['loaded'][ $component['name'] ][ $component['version'] ]['objects'] ) && isset( $otw_components['loaded'][ $component['name'] ][ $component['version'] ]['objects'][ $component['key'] ] ) ){
				return $otw_components['loaded'][ $component['name'] ][ $component['version'] ]['objects'][ $component['key'] ];
			}
		}
		wp_die( 'OTW Component '.$component['name'].' is not loaded.' );
	}
}
/**
 * Order otw meta goxes
 *
 */
if (!function_exists( "otw_order_meta_boxes" )){
	function otw_order_meta_boxes(){
		global $wp_meta_boxes;
		
		if( is_array( $wp_meta_boxes ) && count( $wp_meta_boxes ) ){
			
			foreach( $wp_meta_boxes as $item_type => $sections ){
			
				if( isset( $sections['normal'] ) && isset( $sections['normal']['high'] ) && is_array( $sections['normal']['high'] ) && count( $sections['normal']['high'] ) ){
					
					$high_boxes = $sections['normal']['high'];
					$box_orders = array();
					
					$order_key = 2;
					foreach( $high_boxes as $box_id => $box_data ){
						
						if( $box_id == 'otw_content_sidebars_settings' ){
							$box_orders[ $box_id ] = 1;
						}elseif( $box_id == 'otw_grid_manager_content' ){
							$box_orders[ $box_id ] = 0;
						}else{
							$box_orders[ $box_id ][ $box_id ] = $order_key;
							$order_key++;
						}
					}
					
					if( count( $box_orders ) ){
						$wp_meta_boxes[ $item_type ]['normal']['high'] = array();
						asort( $box_orders );
						
						foreach( $box_orders as $box_id => $box_order ){
							
							$wp_meta_boxes[ $item_type ]['normal']['high'][ $box_id ] = $high_boxes[ $box_id ];
							
						}
					}
				}
			}
		}
	}
}


/**
 * Wrap the item content with row
 * @param string
 */
if (!function_exists( "otw_pre_content_wrapper" )){
	function otw_pre_content_wrapper( $the_content ){
		return $the_content;
	}
}

/**
 * Wrap the full content with row
 * @param string
 */
if (!function_exists( "otw_post_content_wrapper" )){
	function otw_post_content_wrapper( $the_content ){
	
		if( otw_is_content_sidebars_content() ){
			$the_content = '<div class="otw-row"><div class="otw-row"><div class="otw-twentyfour otw-columns">'.$the_content.'</div></div></div>';
		}
		return $the_content;
	}
}

/**
 *  Check if content is changed by the grid manager component
 *  return @boolean
 */
if (!function_exists( "otw_is_grid_manager_content" )){
	function otw_is_grid_manager_content(){
		
		global $otw_components;
		
		if( isset( $otw_components['loaded'] ) && isset( $otw_components['loaded']['otw_grid_manager'] ) ){
		
			foreach( $otw_components['loaded']['otw_grid_manager'] as $otw_component ){
			
				if( isset( $otw_component['objects'] ) ){
					
					foreach( $otw_component['objects'] as $otw_co_object ){
						
						if( $otw_co_object->is_valid_for_object() ){
							return true;
						}
					}
				}
			}
		}
		return false;
	}
}

/**
 *  Check if content is changed by the content sidebars component
 *  return @boolean
 */
if (!function_exists( "otw_is_content_sidebars_content" )){
	function otw_is_content_sidebars_content(){
		
		global $otw_components;
		
		if( isset( $otw_components['loaded'] ) && isset( $otw_components['loaded']['otw_content_sidebars'] ) ){
		
			foreach( $otw_components['loaded']['otw_content_sidebars'] as $otw_component ){
			
				if( isset( $otw_component['objects'] ) ){
				
					foreach( $otw_component['objects'] as $otw_co_object ){
						
						if( $otw_co_object->is_valid_for_object() ){
							return true;
						}
					}
				}
			}
		
		}
		return false;
	}
}
/**
 *  strip slashes
 *  return @string
 */
if (!function_exists( "otw_stripslashes" )){
	function otw_stripslashes( $string_array ){
	
		if( get_magic_quotes_gpc() ){
			if( is_array( $string_array ) ){
				$string_array = array_map('stripslashes_deep', $string_array );
			}else{
				$string_array = stripslashes( $string_array );
			}
		}else{
			if( is_array( $string_array ) ){
				$string_array = array_map('stripslashes_deep', $string_array );
			}else{
				$string_array = stripslashes( $string_array );
			}
		}
		return $string_array;
	}
}

/**
 *  Html entities
 *  return @string
 */
if (!function_exists( "otw_htmlentities" )){
	function otw_htmlentities( $string ){
		
		return htmlentities( $string, ENT_COMPAT, 'UTF-8' );
	}
}

/**
 *  Html entities decocode
 *  return @string
 */
if (!function_exists( "otw_htmlentities_decode" )){
	function otw_htmlentities_decode( $string ){
		
		return html_entity_decode( $string, ENT_COMPAT, 'UTF-8' );
	}
}

/**
 *  Compare the current version with given one
 *  return integer
 */
if (!function_exists( "otw_comprare_blog_version" )){
	function otw_comprare_blog_version( $version ){
	
		$blog_version = get_bloginfo('version');
		
		$blog_version_parts = explode( '.', $blog_version );
		$version_parts = explode( '.', $version );
		
		foreach( $blog_version_parts as $part_key => $part_value )
		{
			if( $part_value > $version_parts[ $part_key ] )
			{
				return -1;
			}
			elseif( $part_value < $version_parts[ $part_key ] )
			{
				return 1;
			}
		}
		return 0;
	}
}

?>