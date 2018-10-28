<?php
class OTW_Shortcodes{

	/**
	 * array with labels
	 */
	public $labels = array();
	
	/**
	 * array with settings
	 */
	public $settings = array();
	
	/**
	 * mode
	 */
	public $mode = '';
	
	/**
	 * has custom options
	 */
	public $has_custom_options = false;
	
	/**
	 * has preview
	 */
	public $has_preview = true;
	
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
	 * component url
	 * 
	 * @var  string
	 */
	public $component_url = '';
	
	/**
	 * component path
	 * 
	 * @var  string
	 */
	public $component_path = '';
	
	/**
	 * external libs
	 *
	 */
	public $external_libs = array();
	
	/**
	 * previews
	 *
	 */
	public $preview = 'iframe';
	
	/**
	 * is live preview requested
	 */
	public $is_live_preview = false;
	
	/**
	 *  Key of the shortcode
	 */
	public $shortcode_key = '';
	
	/**
	 *  Name of the shortcode
	 */
	public $shortcode_name = '';
	
	/**
	 *  Init in front
	 */
	public $init_in_front = false;
	
	/**
	 * dialog_text
	 */
	public $dialog_text = '';
	
	/**
	 * google web fonts
	 */
	public $google_fonts = array(
		array( 'name' => "Abel", 'variant' => ''),
		array( 'name' => "Abril Fatface", 'variant' => ''),
		array( 'name' => "Aclonica", 'variant' => ''),
		array( 'name' => "Actor", 'variant' => ''),
		array( 'name' => "Adamina", 'variant' => ''),
		array( 'name' => "Aldrich", 'variant' => ''),
		array( 'name' => "Alice", 'variant' => ''),
		array( 'name' => "Alike Angular", 'variant' => ''),
		array( 'name' => "Alike", 'variant' => ''),
		array( 'name' => "Allan", 'variant' => ':bold'),
		array( 'name' => "Allerta Stencil", 'variant' => ''),
		array( 'name' => "Allerta", 'variant' => ''),
		array( 'name' => "Amaranth", 'variant' => ''),
		array( 'name' => "Amatic SC", 'variant' => ''),
		array( 'name' => "Andada", 'variant' => ''),
		array( 'name' => "Andika", 'variant' => ''),
		array( 'name' => "Annie Use Your Telescope", 'variant' => ''),
		array( 'name' => "Anonymous Pro", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Antic", 'variant' => ''),
		array( 'name' => "Anton", 'variant' => ''),
		array( 'name' => "Arapey", 'variant' => ':r,i'),
		array( 'name' => "Architects Daughter", 'variant' => ''),
		array( 'name' => "Arimo", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Artifika", 'variant' => ''),
		array( 'name' => "Arvo", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Asset", 'variant' => ''),
		array( 'name' => "Astloch", 'variant' => ':b'),
		array( 'name' => "Atomic Age", 'variant' => ''),
		array( 'name' => "Aubrey", 'variant' => ''),
		array( 'name' => "Bangers", 'variant' => ''),
		array( 'name' => "Bentham", 'variant' => ''),
		array( 'name' => "Bevan", 'variant' => ''),
		array( 'name' => "Bigshot One", 'variant' => ''),
		array( 'name' => "Bitter", 'variant' => ''),
		array( 'name' => "Black Ops One", 'variant' => ''),
		array( 'name' => "Bowlby One SC", 'variant' => ''),
		array( 'name' => "Bowlby One", 'variant' => ''),
		array( 'name' => "Brawler", 'variant' => ''),
		array( 'name' => "Buda", 'variant' => ':light'),
		array( 'name' => "Butcherman Caps", 'variant' => ''),
		array( 'name' => "Cabin Condensed", 'variant' => ':r,b'),
		array( 'name' => "Cabin Sketch", 'variant' => ':r,b'),
		array( 'name' => "Cabin", 'variant' => ':400,400italic,700,700italic,'),
		array( 'name' => "Calligraffitti", 'variant' => ''),
		array( 'name' => "Candal", 'variant' => ''),
		array( 'name' => "Cantarell", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Cardo", 'variant' => ''),
		array( 'name' => "Carme", 'variant' => ''),
		array( 'name' => "Carter One", 'variant' => ''),
		array( 'name' => "Caudex", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Cedarville Cursive", 'variant' => ''),
		array( 'name' => "Changa One", 'variant' => ''),
		array( 'name' => "Cherry Cream Soda", 'variant' => ''),
		array( 'name' => "Chewy", 'variant' => ''),
		array( 'name' => "Chivo", 'variant' => ''),
		array( 'name' => "Coda", 'variant' => ''),
		array( 'name' => "Coda", 'variant' => ':800'),
		array( 'name' => "Comfortaa", 'variant' => ':r,b'),
		array( 'name' => "Coming Soon", 'variant' => ''),
		array( 'name' => "Contrail One", 'variant' => ''),
		array( 'name' => "Convergence", 'variant' => ''),
		array( 'name' => "Copse", 'variant' => ''),
		array( 'name' => "Corben", 'variant' => ''),
		array( 'name' => "Corben", 'variant' => ':b'),
		array( 'name' => "Cousine", 'variant' => ''),
		array( 'name' => "Coustard", 'variant' => ':r,b'),
		array( 'name' => "Covered By Your Grace", 'variant' => ''),
		array( 'name' => "Crafty Girls", 'variant' => ''),
		array( 'name' => "Creepster Caps", 'variant' => ''),
		array( 'name' => "Crimson Text", 'variant' => ''),
		array( 'name' => "Crushed", 'variant' => ''),
		array( 'name' => "Cuprum", 'variant' => ''),
		array( 'name' => "Damion", 'variant' => ''),
		array( 'name' => "Dancing Script", 'variant' => ''),
		array( 'name' => "Dawning of a New Day", 'variant' => ''),
		array( 'name' => "Days One", 'variant' => ''),
		array( 'name' => "Delius Swash Caps", 'variant' => ''),
		array( 'name' => "Delius Unicase", 'variant' => ''),
		array( 'name' => "Delius", 'variant' => ''),
		array( 'name' => "Didact Gothic", 'variant' => ''),
		array( 'name' => "Dorsa", 'variant' => ''),
		array( 'name' => "Droid Sans Mono", 'variant' => ''),
		array( 'name' => "Droid Sans", 'variant' => ':r,b'),
		array( 'name' => "Droid Serif", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Eater Caps", 'variant' => ''),
		array( 'name' => "EB Garamond", 'variant' => ''),
		array( 'name' => "Expletus Sans", 'variant' => ':b'),
		array( 'name' => "Fanwood Text", 'variant' => ''),
		array( 'name' => "Federant", 'variant' => ''),
		array( 'name' => "Federo", 'variant' => ''),
		array( 'name' => "Fjord One", 'variant' => ''),
		array( 'name' => "Fontdiner Swanky", 'variant' => ''),
		array( 'name' => "Forum", 'variant' => ''),
		array( 'name' => "Francois One", 'variant' => ''),
		array( 'name' => "Gentium Book Basic", 'variant' => ''),
		array( 'name' => "Geo", 'variant' => ''),
		array( 'name' => "Geostar Fill", 'variant' => ''),
		array( 'name' => "Geostar", 'variant' => ''),
		array( 'name' => "Give You Glory", 'variant' => ''),
		array( 'name' => "Gloria Hallelujah", 'variant' => ''),
		array( 'name' => "Goblin One", 'variant' => ''),
		array( 'name' => "Gochi Hand", 'variant' => ''),
		array( 'name' => "Goudy Bookletter 1911", 'variant' => ''),
		array( 'name' => "Gravitas One", 'variant' => ''),
		array( 'name' => "Gruppo", 'variant' => ''),
		array( 'name' => "Hammersmith One", 'variant' => ''),
		array( 'name' => "Holtwood One SC", 'variant' => ''),
		array( 'name' => "Homemade Apple", 'variant' => ''),
		array( 'name' => "IM Fell DW Pica", 'variant' => ':r,i'),
		array( 'name' => "IM Fell English SC", 'variant' => ''),
		array( 'name' => "IM Fell English", 'variant' => ':r,i'),
		array( 'name' => "Inconsolata", 'variant' => ''),
		array( 'name' => "Indie Flower", 'variant' => ''),
		array( 'name' => "Irish Grover", 'variant' => ''),
		array( 'name' => "Irish Growler", 'variant' => ''),
		array( 'name' => "Istok Web", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Jockey One", 'variant' => ''),
		array( 'name' => "Josefin Sans", 'variant' => ':400,400italic,700,700italic'),
		array( 'name' => "Josefin Slab", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Judson", 'variant' => ':r,ri,b'),
		array( 'name' => "Julee", 'variant' => ''),
		array( 'name' => "Jura", 'variant' => ''),
		array( 'name' => "Just Another Hand", 'variant' => ''),
		array( 'name' => "Just Me Again Down Here", 'variant' => ''),
		array( 'name' => "Kameron", 'variant' => ':r,b'),
		array( 'name' => "Kelly Slab", 'variant' => ''),
		array( 'name' => "Kenia", 'variant' => ''),
		array( 'name' => "Kranky", 'variant' => ''),
		array( 'name' => "Kreon", 'variant' => ':r,b'),
		array( 'name' => "Kristi", 'variant' => ''),
		array( 'name' => "La Belle Aurore", 'variant' => ''),
		array( 'name' => "Lancelot", 'variant' => ''),
		array( 'name' => "Lato", 'variant' => ':400,700,400italic'),
		array( 'name' => "League Script", 'variant' => ''),
		array( 'name' => "Leckerli One", 'variant' => ''),
		array( 'name' => "Lekton", 'variant' => ''),
		array( 'name' => "Limelight", 'variant' => ''),
		array( 'name' => "Linden Hill", 'variant' => ''),
		array( 'name' => "Lobster Two", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Lobster", 'variant' => ''),
		array( 'name' => "Lora", 'variant' => ''),
		array( 'name' => "Love Ya Like A Sister", 'variant' => ''),
		array( 'name' => "Loved by the King", 'variant' => ''),
		array( 'name' => "Luckiest Guy", 'variant' => ''),
		array( 'name' => "Maiden Orange", 'variant' => ''),
		array( 'name' => "Mako", 'variant' => ''),
		array( 'name' => "Marck Script", 'variant' => ''),
		array( 'name' => "Marvel", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Mate SC", 'variant' => ''),
		array( 'name' => "Mate", 'variant' => ':r,i'),
		array( 'name' => "Maven Pro", 'variant' => ''),
		array( 'name' => "Meddon", 'variant' => ''),
		array( 'name' => "MedievalSharp", 'variant' => ''),
		array( 'name' => "Megrim", 'variant' => ''),
		array( 'name' => "Merienda One", 'variant' => ''),
		array( 'name' => "Merriweather", 'variant' => ''),
		array( 'name' => "Metrophobic", 'variant' => ''),
		array( 'name' => "Michroma", 'variant' => ''),
		array( 'name' => "Miltonian Tattoo", 'variant' => ''),
		array( 'name' => "Miltonian", 'variant' => ''),
		array( 'name' => "Modern Antiqua", 'variant' => ''),
		array( 'name' => "Molengo", 'variant' => ''),
		array( 'name' => "Monofett", 'variant' => ''),
		array( 'name' => "Monoton", 'variant' => ''),
		array( 'name' => "Montez", 'variant' => ''),
		array( 'name' => "Mountains of Christmas", 'variant' => ''),
		array( 'name' => "Muli", 'variant' => ''),
		array( 'name' => "Neucha", 'variant' => ''),
		array( 'name' => "Neuton", 'variant' => ''),
		array( 'name' => "News Cycle", 'variant' => ''),
		array( 'name' => "Nixie One", 'variant' => ''),
		array( 'name' => "Nobile", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Nosifer Caps", 'variant' => ''),
		array( 'name' => "Nova Cut", 'variant' => ''),
		array( 'name' => "Nova Flat", 'variant' => ''),
		array( 'name' => "Nova Mono", 'variant' => ''),
		array( 'name' => "Nova Oval", 'variant' => ''),
		array( 'name' => "Nova Round", 'variant' => ''),
		array( 'name' => "Nova Script", 'variant' => ''),
		array( 'name' => "Nova Slim", 'variant' => ''),
		array( 'name' => "Numans", 'variant' => ''),
		array( 'name' => "Nunito", 'variant' => ''),
		array( 'name' => "OFL Sorts Mill Goudy TT", 'variant' => ':r,i'),
		array( 'name' => "Old Standard TT", 'variant' => ':r,b,i'),
		array( 'name' => "Open Sans Condensed", 'variant' => ':300,300italic'),
		array( 'name' => "Open Sans", 'variant' => ':r,i,b,bi'),
		array( 'name' => "Orbitron", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Oswald", 'variant' => ''),
		array( 'name' => "Over the Rainbow", 'variant' => ''),
		array( 'name' => "Ovo", 'variant' => ''),
		array( 'name' => "Pacifico", 'variant' => ''),
		array( 'name' => "Passero One", 'variant' => ''),
		array( 'name' => "Patrick Hand", 'variant' => ''),
		array( 'name' => "Paytone One", 'variant' => ''),
		array( 'name' => "Permanent Marker", 'variant' => ''),
		array( 'name' => "Petrona", 'variant' => ''),
		array( 'name' => "Philosopher", 'variant' => ''),
		array( 'name' => "Pinyon Script", 'variant' => ''),
		array( 'name' => "Play", 'variant' => ':r,b'),
		array( 'name' => "Playfair Display", 'variant' => ''),
		array( 'name' => "Podkova", 'variant' => ''),
		array( 'name' => "Poller One", 'variant' => ''),
		array( 'name' => "Poly", 'variant' => ''),
		array( 'name' => "Pompiere", 'variant' => ''),
		array( 'name' => "Prata", 'variant' => ''),
		array( 'name' => "Prociono", 'variant' => ''),
		array( 'name' => "PT Sans Caption", 'variant' => ':r,b'),
		array( 'name' => "PT Sans Narrow", 'variant' => ':r,b'),
		array( 'name' => "PT Sans", 'variant' => ':r,b,i,bi'),
		array( 'name' => "PT Serif Caption", 'variant' => ':r,i'),
		array( 'name' => "PT Serif", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Puritan", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Quattrocento Sans", 'variant' => ''),
		array( 'name' => "Quattrocento", 'variant' => ''),
		array( 'name' => "Questrial", 'variant' => ''),
		array( 'name' => "Quicksand", 'variant' => ''),
		array( 'name' => "Radley", 'variant' => ''),
		array( 'name' => "Raleway", 'variant' => ':100'),
		array( 'name' => "Rametto One", 'variant' => ''),
		array( 'name' => "Rancho", 'variant' => ''),
		array( 'name' => "Rationale", 'variant' => ''),
		array( 'name' => "Redressed", 'variant' => ''),
		array( 'name' => "Reenie Beanie", 'variant' => ''),
		array( 'name' => "Rochester", 'variant' => ''),
		array( 'name' => "Rock Salt", 'variant' => ''),
		array( 'name' => "Rokkitt", 'variant' => ':400,700'),
		array( 'name' => "Rosario", 'variant' => ''),
		array( 'name' => "Ruslan Display", 'variant' => ''),
		array( 'name' => "Salsa", 'variant' => ''),
		array( 'name' => "Sancreek", 'variant' => ''),
		array( 'name' => "Sansita One", 'variant' => ''),
		array( 'name' => "Satisfy", 'variant' => ''),
		array( 'name' => "Schoolbell", 'variant' => ''),
		array( 'name' => "Shadows Into Light", 'variant' => ''),
		array( 'name' => "Shanti", 'variant' => ''),
		array( 'name' => "Short Stack", 'variant' => ''),
		array( 'name' => "Sigmar One", 'variant' => ''),
		array( 'name' => "Six Caps", 'variant' => ''),
		array( 'name' => "Slackey", 'variant' => ''),
		array( 'name' => "Smokum", 'variant' => ''),
		array( 'name' => "Smythe", 'variant' => ''),
		array( 'name' => "Sniglet", 'variant' => ':800'),
		array( 'name' => "Snippet", 'variant' => ''),
		array( 'name' => "Sorts Mill Goudy", 'variant' => ''),
		array( 'name' => "Special Elite", 'variant' => ''),
		array( 'name' => "Spinnaker", 'variant' => ''),
		array( 'name' => "Stardos Stencil", 'variant' => ''),
		array( 'name' => "Sue Ellen Francisco", 'variant' => ''),
		array( 'name' => "Sunshiney", 'variant' => ''),
		array( 'name' => "Supermercado One", 'variant' => ''),
		array( 'name' => "Swanky and Moo Moo", 'variant' => ''),
		array( 'name' => "Syncopate", 'variant' => ''),
		array( 'name' => "Tangerine", 'variant' => ':r,b'),
		array( 'name' => "Tenor Sans", 'variant' => ''),
		array( 'name' => "Terminal Dosis Light", 'variant' => ''),
		array( 'name' => "Terminal Dosis", 'variant' => ''),
		array( 'name' => "The Girl Next Door", 'variant' => ''),
		array( 'name' => "Tienne", 'variant' => ''),
		array( 'name' => "Tinos", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Tulpen One", 'variant' => ''),
		array( 'name' => "Ubuntu Condensed", 'variant' => ''),
		array( 'name' => "Ubuntu Mono", 'variant' => ''),
		array( 'name' => "Ubuntu", 'variant' => ':r,b,i,bi'),
		array( 'name' => "Ultra", 'variant' => ''),
		array( 'name' => "UnifrakturCook", 'variant' => ':bold'),
		array( 'name' => "UnifrakturMaguntia", 'variant' => ''),
		array( 'name' => "Unkempt", 'variant' => ''),
		array( 'name' => "Unna", 'variant' => ''),
		array( 'name' => "Varela Round", 'variant' => ''),
		array( 'name' => "Varela", 'variant' => ''),
		array( 'name' => "Vast Shadow", 'variant' => ''),
		array( 'name' => "Vibur", 'variant' => ''),
		array( 'name' => "Vidaloka", 'variant' => ''),
		array( 'name' => "Volkhov", 'variant' => ''),
		array( 'name' => "Vollkorn", 'variant' => ':r,b'),
		array( 'name' => "Voltaire", 'variant' => ''),
		array( 'name' => "VT323", 'variant' => ''),
		array( 'name' => "Waiting for the Sunrise", 'variant' => ''),
		array( 'name' => "Wallpoet", 'variant' => ''),
		array( 'name' => "Walter Turncoat", 'variant' => ''),
		array( 'name' => "Wire One", 'variant' => ''),
		array( 'name' => "Yanone Kaffeesatz", 'variant' => ':r,b'),
		array( 'name' => "Yellowtail", 'variant' => ''),
		array( 'name' => "Yeseva One", 'variant' => ''),
		array( 'name' => "Zeyada", 'variant' => '')
	);
	
	/**
	 * construct
	 */ 
	public function __construct(){
		$this->shortcode_name = strtolower( get_class( $this ) );
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
	 * Build shortcode editor
	 */
	public function build_shortcode_editor_options(){
		
		return $this->get_label( 'Invalid shortcode' );
		
	}
	
	/**
	 * apply predefined settings
	 */
	public function apply_settings(){
		
	}
	
	/**
	 * Build shortcode editor
	 */
	public function build_shortcode_editor_custom_options(){
		
		return $this->get_label( 'Invalid shortcode' );
		
	}
	
	/**
	 * Build shortcode
	 */
	public function build_shortcode_code( $attributes ){
		
		echo $this->get_label( 'Invalid shortcode' );
		
	}
	
	
	/**
	 * Display shortcode
	 */
	public function display_shortcode( $attributes, $content ){
		return $this->get_label( 'Invalid shortcode' );
	}
	
	/**
	 *  format attribute
	 *  
	 *  @param string name
	 *
	 *  @param string key
	 *
	 *  @param array with attributes
	 *
	 *  @param boolean create attribute if no value
	 *
	 *  @return string
	 */
	public function format_attribute( $attribute_name, $attribute_key, $attributes, $show_empty = false, $add_space = '', $htmlentities = false ){
	
		if( isset( $attributes[ $attribute_key ] ) && strlen( trim( $attributes[ $attribute_key ] ) ) ){
			if( $attribute_name ){
				return ' '.$attribute_name.'="'.$this->clean_attribute( $attributes[ $attribute_key ], $htmlentities ).'"';
			}else{
				if( strlen( $add_space ) ){
					return ' '.$this->clean_attribute( $attributes[ $attribute_key ], $htmlentities );
				}
				return $this->clean_attribute( $attributes[ $attribute_key ], $htmlentities );
			}
		}elseif( $show_empty ){
			if( $attribute_name ){
				return ' '.$attribute_name.'=""';
			}
		}
		return '';
	}
	
	/** append attribute to existing list with attributes
	 *
	 *  @param string
	 *  @param string
	 *  @return string
	 */
	public function append_attribute( $append_to, $attribute ){
		
		$result = $append_to;
		
		if( strlen( $result ) ){
			$result .= ' '.$attribute;
		}else{
			$result .= $attribute;
		}
		return $result;
	}
	
	/**
	 *  add error
	 */
	public function add_error( $error_string ){
		
		$this->errors[] = $error_string;
		$this->has_error = true;
	}
	
	/**
	 * Return shortcode attributes
	 */
	public function get_shortcode_attributes( $attributes ){
		return array();
	}
	
	/**
	 * Check if is google font
	 */
	public function is_google_font( $font_name )
	{
		foreach( $this->google_fonts as $g_font )
		{
			if( $g_font['name'] == $font_name )
			{
				return $g_font;
			}
		}
		return false;
	}
	
	/**
	 * Include google font
	 */
	public function include_google_font( $font_info )
	{
		$output = '';
		
		$font = urlencode( $font_info['name'].$font_info['variant'] );
		
		$output .= "\n<!-- Google Webfonts -->\n";
		
		$output .= '<link href="//fonts.googleapis.com/css?family=' . $font .'" rel="stylesheet" type="text/css" />'."\n\n";
		
		$output = str_replace( '|"','"',$output);
		
		return $output;
	}
	
	/**
	 * Format font face
	 */
	public function format_font_face( $font_name ){
		
		if( $this->is_google_font( $font_name ) ){
			
			switch( $font_name ){
				
				case 'PT Sans':
						$font_name = "'" . $font_name . "', Helvetica Neue, Helvetica, Arial, sans-serif";
					break;
				case 'Droid Serif':
						$font_name = "'" . $font_name . "', Times New Roman, Times, Serif";
					break;
				default:
						$font_name = "'" . $font_name . "', arial, serif";
					break;
			}
		}
		return $font_name;
	}
	
	public function clean_attribute( $attribute_value, $htmlentities ){
		
		if( $htmlentities ){
			$attribute_value = otw_htmlentities( $attribute_value );
		}
		return $attribute_value;
	}
	
	public function add_external_lib( $type, $name, $path, $int, $order, $deps = false ){
	
		$this->external_libs[] = array( 'type' => $type, 'name' => $name, 'path' => $path, 'int' => $int, 'order' => $order, 'deps' => $deps );
	}
	
	public function register_external_libs(){
	
	}
}
