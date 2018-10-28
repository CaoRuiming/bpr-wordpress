<?php
class OTW_Shortcode_Widget extends WP_Widget{
	
	/**
	  * Labes
	  */
	public $labels = array();
	
	function __construct(){
		
		global $otw_components;
		
		parent::__construct( 'otw_shortcode_widget', __('OTW Shortcode Widget', 'otw-shortcode-widget' ) );
	}
	
	/**
	 * Admin backend form
	 */
	public function form( $instance ){
		
		global $otw_components;
		
		$output = '';
		$output .= "\n<div class=\"otw-ws-content\">";
			$output .= "\n<div id=\"".$this->get_field_id( 'otw-sw-controls' )."\">";
				$output .= "\n<label for=\"".$this->get_field_id( 'otw-shortcode-type' )."\">".__( 'Select Shortcode', 'otw-shortcode-widget' )."</label><br />";
				$output .= "\n<select id=\"".$this->get_field_id( 'otw-shortcode-type' )."\">";
				if( isset( $otw_components['loaded'] ) && isset( $otw_components['loaded']['otw_shortcode'] ) ){
					
					foreach( $otw_components['loaded']['otw_shortcode'] as $otw_shortcode_component ){
						
						foreach( $otw_shortcode_component['objects'][1]->shortcodes as $shortcode_key => $shortcode ){
						
							if( !is_array( $shortcode['children'] ) ){
							
								if( !preg_match( "/^widget_shortcode/", $shortcode_key ) ){
									$output .= "\n<option value=\"".$shortcode_key."\" >".$shortcode['title']."</option>";
								}
							}
						}
						break;
					}
				}
				
				$output .= "\n</select>";
				$output .= "&nbsp;<input type=\"button\" value=\"".__( 'Add', 'otw-shortcode-widget' )."\" class=\"button button-primary\" id=\"".$this->get_field_id( 'otw-sw-add-shortcode' )."\" onclick=\"otw_sw_add_shortcode( this );\"/>";
			$output .= "\n</div>";
			$output .= "\n<div id=\"".$this->get_field_id( 'otw-sw-selected-shortcodes' )."\">";
			
			$output .= "\n</div>";
		
		$output .= "\n</div>";
		
		$otw_sw_code = '';
		
		if( isset( $instance['otw-sw-code'] ) ){
			$otw_sw_code = $instance['otw-sw-code'];
		}
		
		$output .= "\n<input type=\"hidden\" id=\"".$this->get_field_id( 'otw-sw-code' )."\" value=\"".otw_htmlentities( $otw_sw_code )."\" name=\"".$this->get_field_name( 'otw-sw-code' )."\"/>";
		$output .= "\n<script type=\"text/javascript\">";
		$output .= "\notw_sw_dislpay_code('".$this->get_field_id( 'otw-sw-code' )."')";
		$output .= "\n</script>";
		echo $output;
	}
	
	public function update( $new_instance, $old_instance ){
		return $new_instance;
	}
	
	public function widget( $args, $instance ){
		
		$output = '';
		if( isset( $instance['otw-sw-code'] ) ){
			
			$otw_sw_object = json_decode( $instance['otw-sw-code'] );
			
			if( isset( $otw_sw_object->shortcodes ) ){
				
				foreach( $otw_sw_object->shortcodes as $shortcode_object ){
				
					
					if( isset( $shortcode_object->shortcode ) && isset( $shortcode_object->shortcode->shortcode_code ) ){
						$output .= do_shortcode( $shortcode_object->shortcode->shortcode_code );
					}
				}
			}
		}
		
		echo $output;
	}
	
}