<?php
/**
 * Init function
 */
if( !function_exists( 'otw_dcsw_widgets_init' ) ){
	
	function otw_dcsw_widgets_init(){
		
		global $otw_components;
		
		if( isset( $otw_components['registered'] ) && isset( $otw_components['registered']['otw_shortcode'] ) ){
			
			$shortcode_components = $otw_components['registered']['otw_shortcode'];
			arsort( $shortcode_components );
			
			foreach( $shortcode_components as $shortcode ){
				if( is_file( $shortcode['path'].'/widgets/otw_shortcode_widget.class.php' ) ){
					
					include_once( $shortcode['path'].'/widgets/otw_shortcode_widget.class.php' );
					break;
				}
			}
		}
		register_widget( 'OTW_Shortcode_Widget' );
	}
}
/**
 * Init function
 */
if( !function_exists( 'otw_dcsw_init' ) ){
	
	function otw_dcsw_init(){
		
		global $otw_dcsw_plugin_url, $otw_dcsw_plugin_options, $otw_dcsw_shortcode_component, $otw_dcsw_shortcode_object, $otw_dcsw_form_component, $otw_dcsw_validator_component, $otw_dcsw_form_object, $wp_dcsw_cs_items, $otw_dcsw_js_version, $otw_dcsw_css_version, $wp_widget_factory;
		
		if( is_admin() ){
			
		
			add_action('admin_menu', 'otw_dcsw_init_admin_menu' );
			
			add_action('admin_print_styles', 'otw_dcsw_enqueue_admin_styles' );
			
			add_action('admin_enqueue_scripts', 'otw_dcsw_enqueue_admin_scripts');
		}
		otw_dcsw_enqueue_styles();
		
		include_once( plugin_dir_path( __FILE__ ).'otw_dcsw_dialog_info.php' );
		
		//shortcode component
		$otw_dcsw_shortcode_component = otw_load_component( 'otw_shortcode' );
		$otw_dcsw_shortcode_object = otw_get_component( $otw_dcsw_shortcode_component );
		$otw_dcsw_shortcode_object->js_version = $otw_dcsw_js_version;
		$otw_dcsw_shortcode_object->css_version = $otw_dcsw_css_version;
		$otw_dcsw_shortcode_object->editor_button_active_for['page'] = true;
		$otw_dcsw_shortcode_object->editor_button_active_for['post'] = true;
		
		$otw_dcsw_shortcode_object->add_default_external_lib( 'css', 'style', get_stylesheet_directory_uri().'/style.css', 'live_preview', 10 );
		
		if( isset( $otw_dcsw_plugin_options['otw_dcsw_theme_css'] ) && strlen( $otw_dcsw_plugin_options['otw_dcsw_theme_css'] ) ){
			
			if( preg_match( "/^http(s)?\:\/\//", $otw_dcsw_plugin_options['otw_dcsw_theme_css'] ) ){
				$otw_dcsw_shortcode_object->add_default_external_lib( 'css', 'theme_style', $otw_dcsw_plugin_options['otw_dcsw_theme_css'], 'live_preview', 11 );
			}else{
				$otw_dcsw_shortcode_object->add_default_external_lib( 'css', 'theme_style', get_stylesheet_directory_uri().'/'.$otw_dcsw_plugin_options['otw_dcsw_theme_css'], 'live_preview', 11 );
			}
		}
		
		$otw_dcsw_shortcode_object->shortcodes['dropcap'] = array( 'title' => __('Dropcaps', 'otw_dcsw'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 3,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_dcsw_plugin_url.'/include/otw_components/otw_shortcode/', 'dialog_text' => $otw_dcsw_dialog_text  );
		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_dcsw_shortcode_object.labels.php' );
		$otw_dcsw_shortcode_object->init();
		
		//form component
		$otw_dcsw_form_component = otw_load_component( 'otw_form' );
		$otw_dcsw_form_object = otw_get_component( $otw_dcsw_form_component );
		$otw_dcsw_form_object->js_version = $otw_dcsw_js_version;
		$otw_dcsw_form_object->css_version = $otw_dcsw_css_version;
		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_dcsw_form_object.labels.php' );
		$otw_dcsw_form_object->init();
		
		//validator component
		$otw_dcsw_validator_component = otw_load_component( 'otw_validator' );
		$otw_dcsw_validator_object = otw_get_component( $otw_dcsw_validator_component );
		$otw_dcsw_validator_object->init();
		
	}
}

/**
 * include needed styles
 */
if( !function_exists( 'otw_dcsw_enqueue_styles' ) ){
	function otw_dcsw_enqueue_styles(){
		global $otw_dcsw_plugin_url, $otw_dcsw_css_version;
	}
}


/**
 * Admin styles
 */
if( !function_exists( 'otw_dcsw_enqueue_admin_styles' ) ){
	
	function otw_dcsw_enqueue_admin_styles(){
		
		global $otw_dcsw_plugin_url, $otw_dcsw_css_version;
		
		wp_enqueue_style( 'otw_dcsw_admin', $otw_dcsw_plugin_url.'/css/otw_dcsw_admin.css', array( 'thickbox' ), $otw_dcsw_css_version );
	}
}

/**
 * Admin scripts
 */
if( !function_exists( 'otw_dcsw_enqueue_admin_scripts' ) ){
	
	function otw_dcsw_enqueue_admin_scripts( $requested_page ){
		
		global $otw_dcsw_plugin_url, $otw_dcsw_js_version;
		
		switch( $requested_page ){
			
			case 'widgets.php':
					wp_enqueue_script("otw_shotcode_widget_admin", $otw_dcsw_plugin_url.'/include/otw_components/otw_shortcode/js/otw_shortcode_widget_admin.js'  , array( 'jquery', 'thickbox' ), $otw_dcsw_js_version );
					
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}
				break;
		}
	}
	
}

/**
 * Init admin menu
 */
if( !function_exists( 'otw_dcsw_init_admin_menu' ) ){
	
	function otw_dcsw_init_admin_menu(){
		
		global $otw_dcsw_plugin_url;
		
		add_menu_page(__('Dropcaps Shortcode And Widget', 'otw_dcsw'), __('Dropcaps Shortcode And Widget', 'otw_dcsw'), 'manage_options', 'otw-dcsw-settings', 'otw_dcsw_settings', $otw_dcsw_plugin_url.'/images/otw-sbm-icon.png');
		add_submenu_page( 'otw-dcsw-settings', __('Settings', 'otw_dcsw'), __('Settings', 'otw_dcsw'), 'manage_options', 'otw-dcsw-settings', 'otw_dcsw_settings' );
		

	}
}

/**
 * Settings page
 */
if( !function_exists( 'otw_dcsw_settings' ) ){
	
	function otw_dcsw_settings(){
		require_once( 'otw_dcsw_settings.php' );
	}
}



/**
 * Keep the admin menu open
 */
if( !function_exists( 'otw_open_dcsw_menu' ) ){
	
	function otw_open_dcsw_menu( $params ){
		
		global $menu;
		
		foreach( $menu as $key => $item ){
			if( $item[2] == 'otw-cm-settings' ){
				$menu[ $key ][4] = $menu[ $key ][4].' wp-has-submenu wp-has-current-submenu wp-menu-open menu-top otw-menu-open';
			}
		}
	}
}


?>