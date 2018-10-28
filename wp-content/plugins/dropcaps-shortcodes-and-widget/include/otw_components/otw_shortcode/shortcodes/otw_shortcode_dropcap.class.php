<?php
class OTW_Shortcode_DropCap extends OTW_Shortcodes{
	
	public function __construct(){
		
		$this->has_custom_options = true;
		
		parent::__construct();
	}
	
	public function register_external_libs(){
	
		$this->add_external_lib( 'css', 'otw-shortcode-general_foundicons', $this->component_url.'css/general_foundicons.css', 'all', 10 );
		$this->add_external_lib( 'css', 'otw-shortcode-social_foundicons', $this->component_url.'css/social_foundicons.css', 'all', 20 );
		$this->add_external_lib( 'css', 'otw-shortcode', $this->component_url.'css/otw_shortcode.css', 'all', 100 );
	}

	
	/**
	 * apply settings
	 */
	public function apply_settings(){
	
		$this->settings = array(
		
			'fonts' => array(
				''			=> 'none(default)' 
			),
			'default_font' => '',
			
			'color_classes' => array(
				''                      => $this->get_label( 'none (Default)' ),
				'otw-red-text'                   => $this->get_label( 'Red' ),
				'otw-orange-text'                => $this->get_label( 'Orange' ),
				'otw-green-text'                 => $this->get_label( 'Green' ),
				'otw-greenish-text'              => $this->get_label( 'Greenish' ),
				'otw-aqua-text'                  => $this->get_label( 'Aqua' ),
				'otw-blue-text'                  => $this->get_label( 'Blue' ),
				'otw-pink-text'                  => $this->get_label( 'Pink' ),
				'otw-silver-text'                => $this->get_label( 'Silver' ),
				'otw-brown-text'                 => $this->get_label( 'Brown' ),
				'otw-black-text'                 => $this->get_label( 'Black' )
			),
			'default_color_class' => '',
			
			'background_color_classes' => array(
				''                      => $this->get_label( 'blank (Default)' ),
				'otw-no-background'         => $this->get_label( 'transparent' ),
				'otw-red-background'                   => $this->get_label( 'Red' ),
				'otw-orange-background'                => $this->get_label( 'Orange' ),
				'otw-green-background'                 => $this->get_label( 'Green' ),
				'otw-greenish-background'              => $this->get_label( 'Greenish' ),
				'otw-aqua-background'                  => $this->get_label( 'Aqua' ),
				'otw-blue-background'                  => $this->get_label( 'Blue' ),
				'otw-pink-background'                  => $this->get_label( 'Pink' ),
				'otw-silver-background'                => $this->get_label( 'Silver' ),
				'otw-brown-background'                 => $this->get_label( 'Brown' ),
				'otw-black-background'                 => $this->get_label( 'Black' ),
				'otw-white-background'                 => $this->get_label( 'White' )
			),
			'default_background_color_class' => '',
			
			'sizes' => array(
				''       => $this->get_label( 'Small' ),
				'medium' => $this->get_label( 'Medium' ),
				'large'  => $this->get_label( 'Large' )
			),
			'default_size' => '',
			
			'borders' => array(
				'border'    => $this->get_label( 'yes' ),
				''       => $this->get_label( 'no (Default)' )
			),
			'default_border' => '',
			
			'border_color_classes' => array(
				'otw-no-border-color'              => $this->get_label( 'none (Default)' ),
				'otw-red-border'                   => $this->get_label( 'Red' ),
				'otw-orange-border'                => $this->get_label( 'Orange' ),
				'otw-green-border'                 => $this->get_label( 'Green' ),
				'otw-greenish-border'              => $this->get_label( 'Greenish' ),
				'otw-aqua-border'                  => $this->get_label( 'Aqua' ),
				'otw-blue-border'                  => $this->get_label( 'Blue' ),
				'otw-pink-border'                  => $this->get_label( 'Pink' ),
				'otw-silver-border'                => $this->get_label( 'Silver' ),
				'otw-brown-border'                 => $this->get_label( 'Brown' ),
				'otw-black-border'                 => $this->get_label( 'Black' )
			),
			'default_border_color_class' => '',
			
			'shadows' => array(
				'shadow'    => $this->get_label( 'yes' ),
				''          => $this->get_label( 'no (Default)' )
			),
			'default_shadow' => '',
			
			'squares' => array(
				'square'    => $this->get_label( 'yes' ),
				''          => $this->get_label( 'no (Default)' )
			),
			'default_square' => ''
		);
		
		foreach( $this->google_fonts as $font ){
			$this->settings['fonts'][ $font['name'] ] = $font['name'];
		}
	}
	
	/**
	 * Shortcode info box admin interface
	 */
	public function build_shortcode_editor_options(){
		
		$html = '';
		
		$source = array();
		if( isset( $_POST['shortcode_object'] ) ){
			$source = $_POST['shortcode_object'];
		}
		
		$html .= OTW_Form::text_input( array( 'id' => 'otw-shortcode-element-label', 'label' => $this->get_label( 'Label' ), 'description' => $this->get_label( 'The label for the dropcap. Usually a letter or a number.' ), 'parse' => $source )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-font', 'label' => $this->get_label( 'Font' ), 'description' => $this->get_label( 'The Font for the label. None means general text font.' ), 'parse' => $source, 'options' => $this->settings['fonts'], 'value' => $this->settings['default_font'] )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-color_class', 'label' => $this->get_label( 'Label Color' ), 'description' => $this->get_label( 'The label color.' ), 'parse' => $source, 'options' => $this->settings['color_classes'], 'value' => $this->settings['default_color_class'] )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-background_color_class', 'label' => $this->get_label( 'Background color' ), 'description' => $this->get_label( 'The label background color.' ), 'parse' => $source, 'options' => $this->settings['background_color_classes'], 'value' => $this->settings['default_background_color_class'] )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-size', 'label' => $this->get_label( 'Size' ), 'description' => $this->get_label( 'The size of the label.' ), 'parse' => $source, 'options' => $this->settings['sizes'], 'value' => $this->settings['default_size'] )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-border', 'label' => $this->get_label( 'Border' ), 'description' => $this->get_label( 'Enables border.' ), 'parse' => $source, 'options' => $this->settings['borders'], 'value' => $this->settings['default_border'] )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-border_color_class', 'label' => $this->get_label( 'Border color' ), 'description' => $this->get_label( 'Choose predefined color of the border.' ), 'parse' => $source, 'options' => $this->settings['border_color_classes'], 'value' => $this->settings['default_border_color_class'] )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-shadow', 'label' => $this->get_label( 'Shadow' ), 'description' => $this->get_label( 'Enables shadow.' ), 'parse' => $source, 'options' => $this->settings['shadows'], 'value' => $this->settings['default_shadow'] )  );
		
		$html .= OTW_Form::select( array( 'id' => 'otw-shortcode-element-square', 'label' => $this->get_label( 'Square' ), 'description' => $this->get_label( 'Enables square.' ), 'parse' => $source, 'options' => $this->settings['squares'], 'value' => $this->settings['default_square'] )  );
		
		$html .= OTW_Form::text_area( array( 'id' => 'otw-shortcode-element-content', 'label' => $this->get_label( 'Content' ), 'description' => $this->get_label( 'The content. HTML is allowed.' ), 'parse' => $source )  );
		
		return $html;
	}
	
	/**
	 * Shortcode info box admin interface custom options
	 */
	public function build_shortcode_editor_custom_options(){
		
		$html = '';
		
		$source = array();
		if( isset( $_POST['shortcode_object'] ) ){
			$source = $_POST['shortcode_object'];
		}
		
		$html .= OTW_Form::color_picker( array( 'id' => 'otw-shortcode-element-label_color', 'label' => $this->get_label( 'Label color custom' ), 'description' => $this->get_label( 'Choose a custom label color.' ), 'parse' => $source )  );
		
		$html .= OTW_Form::color_picker( array( 'id' => 'otw-shortcode-element-border_color', 'label' => $this->get_label( 'Border color custom' ), 'description' => $this->get_label( 'Choose a custom border color.' ), 'parse' => $source )  );
		
		$html .= OTW_Form::color_picker( array( 'id' => 'otw-shortcode-element-background_color', 'label' => $this->get_label( 'Background color custom' ), 'description' => $this->get_label( 'Choose a custom background color.' ), 'parse' => $source )  );
		
		$html .= OTW_Form::text_input( array( 'id' => 'otw-shortcode-element-css_class', 'label' => $this->get_label( 'CSS Class' ), 'description' => $this->get_label( 'If you\'d like to style this element separately enter a name here. A CSS class with this name will be available for you to style this particular element..' ), 'parse' => $source )  );
		
		return $html;
	}
	
	/** build button shortcode
	 *
	 *  @param array
	 *  @return string
	 */
	public function build_shortcode_code( $attributes ){
		
		$code = '';
		
		if( !$this->has_error ){
		
			$code = '[otw_shortcode_dropcap';
			
			$code .= $this->format_attribute( 'label', 'label', $attributes );
			$code .= $this->format_attribute( 'font', 'font', $attributes );
			$code .= $this->format_attribute( 'color_class', 'color_class', $attributes );
			$code .= $this->format_attribute( 'background_color_class', 'background_color_class', $attributes );
			$code .= $this->format_attribute( 'size', 'size', $attributes );
			$code .= $this->format_attribute( 'border', 'border', $attributes );
			$code .= $this->format_attribute( 'border_color_class', 'border_color_class', $attributes );
			$code .= $this->format_attribute( 'shadow', 'shadow', $attributes );
			$code .= $this->format_attribute( 'square', 'square', $attributes );
			
			$code .= $this->format_attribute( 'label_color', 'label_color', $attributes );
			$code .= $this->format_attribute( 'border_color', 'border_color', $attributes );
			$code .= $this->format_attribute( 'background_color', 'background_color', $attributes );
			$code .= $this->format_attribute( 'css_class', 'css_class', $attributes, false, '', true  );
			
			$code .= ']';
			
			$code .= $attributes['content'];
			
			$code .= '[/otw_shortcode_dropcap]';
		}
		
		return $code;

	}
	
	/**
	 * Display shortcode
	 */
	public function display_shortcode( $attributes, $content ){
		
		$html = '';
		
		if( $font = $this->format_attribute( '', 'font', $attributes, false, '' ) )
		{
			if( $font_info = $this->is_google_font( $font ) )
			{
				$html .= $this->include_google_font( $font_info );
			}
		}
		
		$html .= '<p';
		$html .= '>';
		
		$html .= '<span';
		
		/*class attributes*/
		$class = 'otw-sc-dropcap';
		
		$class .= $this->format_attribute( '', 'color_class', $attributes, false, $class );
		$class .= $this->format_attribute( '', 'background_color_class', $attributes, false, $class );
		$class .= $this->format_attribute( '', 'size', $attributes, false, $class );
		$class .= $this->format_attribute( '', 'border', $attributes, false, $class );
		$class .= $this->format_attribute( '', 'border_color_class', $attributes, false, $class );
		$class .= $this->format_attribute( '', 'shadow', $attributes, false, $class );
		$class .= $this->format_attribute( '', 'square', $attributes, false, $class );
		$class .= $this->format_attribute( '', 'css_class', $attributes, false, $class );
		
		if( strlen( $class ) ){
			$html .= ' class="'.$class.'"';
		}
		/*end class attributes*/
		
		
		/*styles*/
		$style = '';
		
		if( $font = $this->format_attribute( '', 'font', $attributes, false, '' ) )
		{
			$font = $this->format_font_face( $font );
			
			$style = $this->append_attribute( $style, 'font-family: '.$font.';' );
		}
		
		if( $label_color = $this->format_attribute( '', 'label_color', $attributes, false, '' ) ){
			$style = $this->append_attribute( $style, 'color: '.$label_color.' !important;' );
		}
		if( $border_color = $this->format_attribute( '', 'border_color', $attributes, false, '' ) ){
			$style = $this->append_attribute( $style, 'border-color: '.$border_color.';' );
		}
		if( $background_color = $this->format_attribute( '', 'background_color', $attributes, false, '' ) ){
			$style = $this->append_attribute( $style, 'background-color: '.$background_color.';' );
		}
		
		if( strlen( $style ) ){
			$html .= ' style="'.$style.'"';
		}
		/*end styles*/
		
		$html .= '>';
		
		if( $label = $this->format_attribute( '', 'label', $attributes, false, '' ) ){
			$html .= $label;
		}
		
		$html .= '</span>';
		
		$html .= nl2br( $content );
		
		$html .= '</p>';
		
		return $html;
	}
}
?>