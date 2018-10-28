<?php
class OTW_Component{

	/**
	 * Component url
	 * 
	 * @var  string 
	 */
	public $component_url;

	/**
	 * Component path
	 * 
	 * @var  string 
	 */
	public $component_path;
	
	/**
	 * Labels
	 * 
	 * @var  array
	 */
	public $labels = array();
	
	/**
	 * Errors
	 * 
	 * @var  array
	 */
	public $errors = array();
	
	/**
	 * has errors
	 * 
	 * @var  boolen
	 */
	public $has_error = false;
	
	/**
	 * mode
	 * 
	 * @var  string
	 */
	public $mode = 'production';
	
	/**
	 *  External libs
	 */
	public $external_libs = array();
	
	/**
	 * js version
	 */
	public $js_version = '1.13';
	
	/**
	 * css version
	 */
	public $css_version = '1.13';
	
	/**
	 *  Set settings
	 */
	public function add_settings( $settings ){
		
		$this->component_url = $settings['url'];
		
		$this->component_path = $settings['path'];
	}
	
	public function init(){
		
		if( !is_admin() )
		{
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1000 );
		}
		else
		{
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1000 );
		}
	}
	
	public function enqueue_scripts(){
		
		$this->enqueue_javascripts();
		
		$this->enqueue_styles();
	}
	
	public function enqueue_javascripts(){
	
		if( isset( $this->external_libs['js'] ) ){
			
			uasort( $this->external_libs['js'], array( $this, 'order_external_libs' ) );
			
			foreach( $this->external_libs['js'] as $js_lib ){
				
				$register = false;
				switch( $js_lib['int'] ){
					
					case 'admin':
							if( is_admin()  ){
								$register = true;
							}
						break;
					case 'front':
							if( !is_admin()  ){
								$register = true;
							}
						break;
					case 'all':
							$register = true;
						break;
				}
				if( $register ){
					wp_enqueue_script( $js_lib['name'], $js_lib['path'], $js_lib['deps'] );
				}
			}
		}
	}
	
	public function order_external_libs( $lib_a, $lib_b ){
		
		if( $lib_a['order'] > $lib_b['order'] ){
			return 1;
		}
		elseif( $lib_a['order'] < $lib_b['order'] ){
			return -1;
		}
		return 0;
	}
	
	public function enqueue_styles(){
	
	
		if( isset( $this->external_libs['css'] ) ){
		
			uasort( $this->external_libs['css'], array( $this, 'order_external_libs' ) );
			
			$registered = array();
			foreach( $this->external_libs['css'] as $css_lib ){
				
				$register = false;
				switch( $css_lib['int'] ){
					
					case 'admin':
							if( is_admin()  ){
								$register = true;
							}
						break;
					case 'front':
							if( !is_admin()  ){
								$register = true;
							}
						break;
					case 'all':
							$register = true;
						break;
				}
				
				if( $register ){
				
					if( !isset( $registered[ $css_lib['name'] ] ) ){
						
						wp_enqueue_style( $css_lib['name'], $css_lib['path'], $css_lib['deps'] );
						$registered[ $css_lib['name'] ] = $css_lib['path'];
					}
				}
			}
		}
	}
	
	/**
	 * add external lib
	 * @type js/css
	 * @name name
	 * @path url
	 * @int front/admin/all
	 * @deps depends
	 */
	public function add_external_lib( $type, $name, $path, $int, $order, $deps  ){
		
		if( !isset( $this->external_libs[ $type ] ) ){
			$this->external_libs[ $type ] = array();
		}
		$this->external_libs[ $type ][] = array( 'name' => $name, 'path' => $path, 'int' => $int, 'order' => $order, 'deps' => $deps );
	}
	
	/**
	 *  Get Label
	 */
	public function get_label( $label_key ){
		
		if( isset( $this->labels[ $label_key ] ) ){
		
			return $this->labels[ $label_key ];
		}
		
		if( $this->mode == 'dev' ){
			return strtoupper( $label_key );
		}
		
		return $label_key;
	}
	
	/**
	 *  add error
	 */
	public function add_error( $error_string ){
		
		$this->errors[] = $error_string;
		$this->has_error = true;
	}
	
	/**
	 * Replace WP autop formatting
	 */
	public function otw_shortcode_remove_wpautop($content){
		
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}
?>