<?php
class OTW_Shortcode extends OTW_Component{
	
	
	/**
	 *  List with all available shortcodes
	 */
	public $shortcodes = array();
	
	/**
	 *  List settings for all shortcodes
	 */
	public $shortcode_settings = array();
	
	/**
	 * Key of tinymce shortcodes button
	 */
	public $tinymce_button_key = 'otwcsshortcodebtn';
	
	/**
	 * Tinymce button active for
	 */
	public $editor_button_active_for = array(
		'page' => true,
		'post' => true
	);
	
	/**
	 * Init in front
	 */
	public $init_in_front = false;
	
	/**
	 *
	 */
	private $default_external_libs = array();
	
	/**
	 * construct
	 */
	public function __construct(){
		
	}
	
	public function apply_shortcode_settings(){
		
		foreach( $this->shortcodes as $shortcode_key => $shortcode_settings ){
			
			if( !is_array( $shortcode_settings['children'] ) || !count( $shortcode_settings['children'] ) ){
				$this->shortcodes[ $shortcode_key ]['object']->apply_settings();
			}
		}
	}
	
	public function include_shortcodes(){
		
		$this->add_default_external_lib( 'css', 'otw-shortcode-preview', $this->component_url.'css/otw_shortcode_preview.css', 'live_preview', 300 );
		$this->add_default_external_lib( 'css', 'otw-font-familyopen-sans-condensed-light', '//fonts.googleapis.com/css?family=Open+Sans+Condensed:light&v1', 'admin', 0 );
		
		include_once( $this->component_path.'shortcodes/otw_shortcodes.class.php' );
		
		foreach( $this->shortcodes as $shortcode_key => $shortcode_settings ){
		
			if( !is_array( $shortcode_settings['children'] ) || !count( $shortcode_settings['children'] ) ){
			
				if( preg_match( "/^import_shortcode_(.*)$/", $shortcode_key ) ){
					$otw_shortcode_key = 'import_shortcode';
				}elseif( preg_match( "/^custom_shortcode_(.*)$/", $shortcode_key ) ){
					$otw_shortcode_key = 'custom_shortcode';
				}elseif( preg_match( "/^widget_shortcode_(.*)$/", $shortcode_key ) ){
					$otw_shortcode_key = 'widget_shortcode';
				}else{
					$otw_shortcode_key = $shortcode_key;
				}
				
				if( !class_exists( 'OTW_ShortCode_'.$otw_shortcode_key ) ){
					
					if( isset( $shortcode_settings['path'] ) ){
						include_once( $shortcode_settings['path'].'shortcodes/otw_shortcode_'.$otw_shortcode_key.'.class.php' );
					}else{
						include_once( $this->component_path.'shortcodes/otw_shortcode_'.$otw_shortcode_key.'.class.php' );
					}
				}
				
				$class_name = 'OTW_ShortCode_'.$otw_shortcode_key;
				$this->shortcodes[ $shortcode_key ]['object'] = new $class_name;
				$this->shortcodes[ $shortcode_key ]['object']->labels = $this->labels;
				$this->shortcodes[ $shortcode_key ]['object']->mode = $this->mode;
				$this->shortcodes[ $shortcode_key ]['object']->shortcode_key = $shortcode_key;
				$this->shortcodes[ $shortcode_key ]['object']->init_in_front = $this->init_in_front;
				
				if( isset( $shortcode_settings['dialog_text'] ) ){
					$this->shortcodes[ $shortcode_key ]['object']->dialog_text = $shortcode_settings['dialog_text'];
				}
				
				if( isset( $shortcode_settings['url'] ) ){
					$this->shortcodes[ $shortcode_key ]['object']->component_url = $shortcode_settings['url'];
				}else{
					$this->shortcodes[ $shortcode_key ]['object']->component_url = $this->component_url;
				}
				
				if( isset( $shortcode_settings['path'] ) ){
					$this->shortcodes[ $shortcode_key ]['object']->component_path = $shortcode_settings['path'];
				}else{
					$this->shortcodes[ $shortcode_key ]['object']->component_path = $this->component_path;
				}
				
				$this->shortcodes[ $shortcode_key ]['object']->external_libs = $this->default_external_libs;
				
				$this->shortcodes[ $shortcode_key ]['object']->register_external_libs();
			
			}
		}
		$this->add_registered_libs();
	}
	
	public function add_registered_libs(){
	
		foreach( $this->shortcodes as $shortcode_key => $shortcode_settings ){
			
			if( !is_array( $shortcode_settings['children'] ) || !count( $shortcode_settings['children'] ) ){
				foreach( $this->shortcodes[ $shortcode_key ]['object']->external_libs as $lib_array ){
					$this->add_external_lib( $lib_array['type'], $lib_array['name'], $lib_array['path'], $lib_array['int'], $lib_array['order'], $lib_array['deps'] );
				}
			}
		}
		
	}
	
	public function register_shortcodes(){
	
		if( count( $this->shortcodes ) ){
			uasort( $this->shortcodes, array( $this, 'sort_shortcodes' ) );
		}
		
		foreach( $this->shortcodes as $shortcode_key => $shortcode_data ){
			
			if( isset( $shortcode_data['object'] ) )
			{
				add_shortcode( $shortcode_data['object']->shortcode_name, array( &$this->shortcodes[ $shortcode_key ]['object'], 'display_shortcode' ) );
			}
		}
	}
	
	/**
	 *  Init 
	 */
	public function init(){
		
		$this->include_shortcodes();
		
		$this->apply_shortcode_settings();
		
		$this->register_shortcodes();
		
		if( is_admin() ){
			wp_enqueue_script('otw_shortcode_admin', $this->component_url.'js/otw_shortcode_admin.js' , array( 'jquery' ), $this->js_version );
			wp_enqueue_style( 'otw_shortcode_admin', $this->component_url.'css/otw_shortcode_admin.css', array( ), $this->css_version );
			
			add_action( 'admin_footer', array( &$this, 'load_admin_js' ) );
			
			add_action( 'wp_ajax_otw_shortcode_editor_dialog', array( &$this, 'build_shortcode_editor_dialog' ) );
			add_action( 'wp_ajax_otw_shortcode_get_code', array( &$this, 'get_code' ) );
			add_action( 'wp_ajax_otw_shortcode_live_preview', array( &$this, 'live_preview' ) );
			add_action( 'wp_ajax_otw_shortcode_live_reload', array( &$this, 'live_reload' ) );
			add_action( 'wp_ajax_otw_shortcode_preview_shortcodes', array( &$this, 'preview_shortcodes' ) );
			add_action( 'wp_ajax_otw_shortcode_preview_front_shortcodes', array( &$this, 'preview_front_shortcodes' ) );
			
			if( get_user_option('rich_editing') ){
				
				add_filter('mce_external_plugins', array( &$this, 'add_tinymce_plugin' ) );
				add_filter('mce_buttons', array( &$this,'register_tinymce_button' ) );
			}
		}else{
			if( $this->init_in_front ){
				wp_enqueue_script('otw_shortcode_front', $this->component_url.'js/otw_shortcode_admin.js' , array( 'jquery' ), $this->js_version );
				wp_enqueue_style( 'otw_shortcode_front', $this->component_url.'css/otw_shortcode_admin.css', array( ), $this->css_version );
				wp_enqueue_style('thickbox', false);
				wp_enqueue_script('thickbox');
				add_action( 'wp_footer', array( &$this, 'load_front_js' ) );
			}
		}
		
		parent::init();
	}
	
	/**
	 * Add plugin
	 */
	public function add_tinymce_plugin( $plugin_array ){
		
		if( $this->validate_tinymce_button() ){
			$plugin_array[ $this->tinymce_button_key ] = $this->component_url.'/js/otw_shortcode_tinymce_plugin.js';
		}
		return $plugin_array;
	}
	
	/**
	 * Register tinymce button
	 */
	public function register_tinymce_button( $buttons ){
		
		if( $this->validate_tinymce_button() ){
			array_push( $buttons, 'separator', $this->tinymce_button_key );
		}
		return $buttons;
	}
	
	private function validate_tinymce_button(){
		
		$add_button = false;
		
		if( function_exists('get_current_screen') ){
			
			$current_page = get_current_screen();
			
			if( isset( $current_page->base ) && ( $current_page->base == 'post' ) && isset( $current_page->post_type ) ){
				
				switch( $current_page->post_type ){
					
					case 'post':
					case 'page':
							if( isset( $this->editor_button_active_for[ $current_page->post_type ] ) && $this->editor_button_active_for[ $current_page->post_type ] ){
								$add_button = true;
							}
						break;
				}
			}
		}
		
		return $add_button;
	}
	
	/**
	 *  Add admin js
	 *
	 */
	public function load_admin_js(){
	
		$js  = "<script type=\"text/javascript\">";
		$js .= "otw_shortcode_component = new otw_shortcode_object();";
		$js .= "otw_shortcode_component.shortcodes = ".$this->format_js_shortcodes().";";
		$js .= "otw_shortcode_component.labels = ".json_encode( $this->labels ).";";
		$js .= "otw_shortcode_component.tinymce_button_key='".$this->tinymce_button_key."';";
		$js .= "otw_shortcode_component.wp_url='admin-ajax'";
		$js .= "</script>";
		
		echo $js;
	}
	
	/**
	 * Add front js
	 */
	public function load_front_js(){
	
		$js  = "<script type=\"text/javascript\">";
		$js .= "otw_shortcode_component = new otw_shortcode_object();";
		$js .= "otw_shortcode_component.shortcodes = ".$this->format_js_shortcodes().";";
		$js .= "otw_shortcode_component.labels = ".json_encode( $this->labels ).";";
		$js .= "otw_shortcode_component.tinymce_button_key='".$this->tinymce_button_key."';";
		$js .= "otw_shortcode_component.wp_url='".get_site_url()."/wp-admin/admin-ajax'";
		$js .= "</script>";
		
		echo $js;
	}
	
	/**
	 * Short code editor dialog interface
	 */
	public function build_shortcode_editor_dialog(){
		
		$shortcode = '';
		if( isset( $_GET['shortcode'] ) && array_key_exists( $_GET['shortcode'], $this->shortcodes ) ){
			$shortcode = $this->shortcodes[ $_GET['shortcode'] ];
		}
		
		if( $shortcode ){
			
			$content  = "\n<div style=\"min-height:100%; position:relative; overflow: hidden; background-color: #fff;\">";
			$content .= "\n<div class=\"otw-clear\" id=\"otw-shortcode-editor-buttons\">
					<div class=\"alignleft\">
						<input type=\"button\" accesskey=\"C\" value=\"".$this->get_label('Cancel')."\" name=\"cancel\" class=\"button\" id=\"otw-shortcode-btn-cancel\">
					</div>
					<div class=\"alignright\">
						<input type=\"button\" accesskey=\"I\" value=\"".$this->get_label('Insert')."\" name=\"insert\" class=\"button-primary\" id=\"otw-shortcode-btn-insert\">
					</div>
					<div class=\"otw-clear\"></div>
					</div>";
			
			if( isset( $this->shortcodes[ $_GET['shortcode'] ]['object']->dialog_text ) && strlen( $this->shortcodes[ $_GET['shortcode'] ]['object']->dialog_text ) ){
				$content .= "<div class=\"otw_shortcode_dialog_text\">".$this->shortcodes[ $_GET['shortcode'] ]['object']->dialog_text."</div>";
			}
			
			$content .= "<table cellspacing=\"2\" cellpadding=\"0\" class=\"otw-shortcode-editor-body\">";
			$content .= "<tr>";
			$content .= "<td valign=\"top\"><h3 class=\"otw_editor_section_title\">".$this->get_label('Options')."</h3></td>";
			$content .= "<th class=\"otw_empty_head\">&nbsp;</th>";
			
			if( $this->shortcodes[ $_GET['shortcode'] ]['object']->has_custom_options ){
				$content .= "<td  valign=\"top\" rowspan=\"4\">";
			}else{
				$content .= "<td  valign=\"top\" rowspan=\"2\">";
			}
			
			$content .= "\n</td>";
			$content .= "\n</tr>";
			$content .= "<tr>";
			$content .= "<td class=\"otw-shortcode-editor-fields\" valign=\"top\">";
			$content .= $this->shortcodes[ $_GET['shortcode'] ]['object']->build_shortcode_editor_options();
			$content .= "</td>";
			$content .= "<td>&nbsp;</td>";
			$content .= "</tr>";
			
			if( $this->shortcodes[ $_GET['shortcode'] ]['object']->has_custom_options ){
				$content .= "<tr>";
					$content .= "<th>".$this->get_label('Custom Options')."</th>";
					$content .= "<th class=\"otw_empty_head\">&nbsp;</th>";
				$content .= "</tr>";
				$content .= "<tr>";
					$content .= "<td class=\"otw-shortcode-editor-fields\" valign=\"top\">";
					$content .= $this->shortcodes[ $_GET['shortcode'] ]['object']->build_shortcode_editor_custom_options();
					$content .= "</td>";
					$content .= "<td>&nbsp;</td>";
				$content .= "</tr>";
			}
			$content .= "</table>";
			if( $this->shortcodes[ $_GET['shortcode'] ]['object']->has_preview ){
				
				$content .= "<div class=\"otw-shortcode-editor-preview-container\">
								
								<div class=\"otw-shortcode-editor-preview-wrapper\">
								<h3>".$this->get_label('Preview')."</h3>
								<div class=\"otw-shortcode-editor-preview\">
								</div>
								</div>
						</div>";
			}else{
				$content .= "&nbsp;";
			}

			$content .= "\n<div class=\"otw-clear\" id=\"otw-shortcode-editor-buttons-bottom\">
						<div class=\"alignleft\">
							<input type=\"button\" accesskey=\"C\" value=\"".$this->get_label('Cancel')."\" name=\"cancel\" class=\"button\" id=\"otw-shortcode-btn-cancel-bottom\">
						</div>
						<div class=\"alignright\">
							<input type=\"button\" accesskey=\"I\" value=\"".$this->get_label('Insert')."\" name=\"insert\" class=\"button-primary\" id=\"otw-shortcode-btn-insert-bottom\">
						</div>
						<div class=\"otw-clear\"></div>
					</div>";
			$content .= "\n</div>";
			echo $content;
			die;
		}else{
			wp_die( $this->get_label('Invalid shortcode') );
		}
		
	}
	
	/** Shortcodes preview
	 *
	 */
	public function preview_shortcodes(){
	
		$result = array();
		if( isset( $_POST['shortcode'] ) )
		{
			$result['shortcodes'] = $_POST['shortcode'];
			foreach( $result['shortcodes'] as $shortcode_key => $shortcode )
			{
				$result['shortcodes'][ $shortcode_key ]['preview'] = '';
				if( $this->shortcodes[ $shortcode['shortcode_type'] ]['object']->has_preview ){
				
					$this->shortcodes[ $shortcode['shortcode_type'] ]['object']->is_live_preview = true;
					
					if( $this->shortcodes[ $shortcode['shortcode_type'] ]['object']->preview == 'iframe' ){
						if( isset( $this->shortcodes[ $shortcode['shortcode_type'] ] ) ){
							foreach( $this->shortcodes[ $shortcode['shortcode_type'] ]['object']->external_libs as $lib ){
								
								$register = false;
								switch( $lib['int'] ){
									
									case 'live_preview':
											$register = true;
										break;
									case 'all':
											$register = true;
										break;
								}
								if( $register ){
								
									switch( $lib['type'] ){
										
										case 'js':
												$result['shortcodes'][ $shortcode_key ]['preview'] .= '<script type="text/javascript" src="'.$this->add_js_version( esc_url( $lib['path'] ) ).'"></script>';
											break;
										case 'css':
												$result['shortcodes'][ $shortcode_key ]['preview'] .= '<link rel="stylesheet" type="text/css" href="'.$this->add_css_version( esc_url( $lib['path'] ) ).'" />';
											break;
									}
								}
							}
						}
					}
					//$result['shortcodes'][ $shortcode_key ]['preview'] .= '<div style="text-align: center;">';
					$result['shortcodes'][ $shortcode_key ]['preview'] .= '<div class="otw_live_preview_wapper">';
					
					$result['shortcodes'][ $shortcode_key ]['preview'] .= do_shortcode( stripslashes( $shortcode['code'] ) );
					$result['shortcodes'][ $shortcode_key ]['preview'] .= '</div>';
				}else{
					$result['shortcodes'][ $shortcode_key ]['preview'] .= '<div class="otw_live_preview_wapper"></div>';
				}
			}
		}
		
		echo json_encode( $result );
		die;
	}
	
	/** Shortcodes preview
	 *
	 */
	public function preview_front_shortcodes(){
	
		$result = array();
		if( isset( $_POST['shortcode'] ) )
		{
			$result['shortcodes'] = $_POST['shortcode'];
			foreach( $result['shortcodes'] as $shortcode_key => $shortcode )
			{
				$result['shortcodes'][ $shortcode_key ]['preview'] = '';
				if( $this->shortcodes[ $shortcode['shortcode_type'] ]['object']->has_preview ){
				
					$this->shortcodes[ $shortcode['shortcode_type'] ]['object']->is_live_preview = true;
					
					$result['shortcodes'][ $shortcode_key ]['preview'] .= '<div class="otw_live_preview_wapper">';
					
					$result['shortcodes'][ $shortcode_key ]['preview'] .= do_shortcode( stripslashes( $shortcode['code'] ) );
					$result['shortcodes'][ $shortcode_key ]['preview'] .= '</div>';
				}else{
					$result['shortcodes'][ $shortcode_key ]['preview'] .= '<div class="otw_live_preview_wapper"></div>';
				}
			}
		}
		
		echo json_encode( $result );
		die;
	}
	
	/** Shortcode live reload
	 *
	 */
	public function live_reload(){
		
		if( isset( $_POST['shortcode'] ) ){
			
			foreach( $_POST['shortcode'] as $post_key => $post_value ){
				$_POST['shortcode_object']['otw-shortcode-element-'.$post_key] = $post_value;
			}
		}
		$this->build_shortcode_editor_dialog();
		die;
	}
	
	/** Shortcode live preview
	 *
	 */
	public function live_preview(){
		
		global $post;
		
		if( !$post && isset( $_POST['post'] ) ){
			$post = get_post( $_POST['post'] );
		}
		
		if( isset( $_POST['shortcode'] ) ){
			
			echo '<div class="otw_live_preview_shortcode">';
			$attributes = $_POST['shortcode'];
			
			if( isset( $attributes['shortcode_type'] ) && array_key_exists( $attributes['shortcode_type'], $this->shortcodes ) ){
				
				$this->shortcodes[$attributes['shortcode_type'] ]['object']->is_live_preview = true;
				
				if( $this->shortcodes[$attributes['shortcode_type'] ]['object']->preview == 'iframe' ){
					foreach( $this->shortcodes[ $attributes['shortcode_type'] ]['object']->external_libs as $lib ){
						
						$register = false;
						switch( $lib['int'] ){
							
							case 'live_preview':
									$register = true;
								break;
							case 'all':
									$register = true;
								break;
						}
						if( $register ){
						
							switch( $lib['type'] ){
								
								case 'js':
										echo '<script type="text/javascript" src="'.$this->add_js_version( esc_url( $lib['path'] ) ).'"></script>';
									break;
								case 'css':
										echo '<link rel="stylesheet" type="text/css" href="'.$this->add_css_version( esc_url( $lib['path'] ) ).'" />';
									break;
							}
						}
					}
				}
				if( $shortcode = $this->shortcodes[ $attributes['shortcode_type'] ]['object']->build_shortcode_code( $attributes ) ){
					echo do_shortcode( stripslashes( $shortcode ) );
				}elseif( $this->shortcodes[ $attributes['shortcode_type'] ]['object']->has_error ){
					
					echo '<div class="otw-shortcode-preview-error">';
					echo implode( '<br />', $this->shortcodes[ $attributes['shortcode_type'] ]['object']->errors );
					echo '</div>';
				}
			}
			echo '</div>';
		}
		die;
	}
	
	/** Get shortcode by given params from editor interace
	 *
	 */
	public function get_code(){
		
		$response = array();
		$response['code'] = '';
		
		$attributes = otw_stripslashes( $_POST );
		
		if( isset( $attributes['shortcode_type'] ) && array_key_exists( $attributes['shortcode_type'], $this->shortcodes ) ){
			
			if( $shortcode = $this->shortcodes[  $attributes['shortcode_type'] ]['object']->build_shortcode_code( $attributes ) ){
				$response['code'] = $shortcode;
			}
			if( $shortcode_attributes = $this->shortcodes[  $attributes['shortcode_type'] ]['object']->get_shortcode_attributes( $attributes ) ){
				$response['shortcode_attributes'] = $shortcode_attributes;
			}
			if( $this->shortcodes[  $attributes['shortcode_type'] ]['object']->has_error ){
				foreach( $this->shortcodes[  $attributes['shortcode_type'] ]['object']->errors as $error ){
					$this->add_error( $error );
				}
			}
		}else{
			$this->add_error( $this->get_label( 'Invalid shortcode' ) );
		}
		
		$response['has_error'] = $this->has_error;
		$response['errors'] = $this->errors;
		
		echo json_encode( $response );
		die;
	}
	
	/** Sort shortcodes basedn on order field
	 *
	 */
	public function sort_shortcodes( $a, $b ){
		if( $a['order'] > $b['order'] ){
			return 1;
		}
		elseif( $a['order'] < $b['order'] ){
			return -1;
		}
		
		return 0;
	}
	
	
	/**
	 * add default external lib
	 * @type js/css
	 * @name name
	 * @path url
	 * @int front/admin/all
	 * @deps depends
	 */
	public function add_default_external_lib( $type, $name, $path, $int, $order, $deps = array() ){
		
		$this->default_external_libs[] = array( 'type' => $type, 'name' => $name, 'path' => $path, 'int' => $int, 'order' => $order, 'deps' => $deps );
	}
	
	/**
	 * add version to js script
	 */
	private function add_js_version( $script ){
		
		if( !preg_match( "/\?|\&/", $script ) ){
			$script .= '?v='.$this->js_version;
		}
		return $script;
	}
	
	/**
	 * add version to css file
	 */
	private function add_css_version( $script ){
	
		if( !preg_match( "/\?|\&/", $script ) ){
			$script .= '?v='.$this->css_version;
		}
		return $script;
	}
	
	/**
	 * format shortcodes as json
	 */
	public function format_js_shortcodes(){
		
		$shortcodes = array();
		
		foreach( $this->shortcodes as $shortcode_key => $shortcode_data ){
			$shortcodes[ $shortcode_key ] = array();
			$shortcodes[ $shortcode_key ]['title'] = $shortcode_data['title'];
			
			if( isset( $shortcode_data['enabled'] ) ){
				$shortcodes[ $shortcode_key ]['enabled'] = $shortcode_data['enabled'];
			}
			
			if( isset( $shortcode_data['children'] ) ){
				$shortcodes[ $shortcode_key ]['children'] = $shortcode_data['children'];
			}
			
			if( isset( $shortcode_data['parent'] ) ){
				$shortcodes[ $shortcode_key ]['parent'] = $shortcode_data['parent'];
			}
			
			if( isset( $shortcode_data['order'] ) ){
				$shortcodes[ $shortcode_key ]['order'] = $shortcode_data['order'];
			}
			
			if( isset( $shortcode_data['object'] ) ){
				
				$shortcodes[ $shortcode_key ]['object']  = array();
				
				if( isset( $shortcode_data['object']->preview ) ){
					$shortcodes[ $shortcode_key ]['object']['preview'] = $shortcode_data['object']->preview;
				}
			}
		}
		return json_encode( $shortcodes );
	}
}
?>