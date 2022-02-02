<?php
/**
 * Theme Upsell Button
 * 
 * @package News Block
 * @since 1.0.0
 */ 
class News_Block_Upsell_Button extends WP_Customize_Section {
	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'news-block-upsell-button';

	/**
	 * Custom button text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $button_text = '';

	/**
	 * Custom button URL to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $button_url = '';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function json() {
		$json       = parent::json();
		$theme      = wp_get_theme();
		$button_url = $this->button_url;
		// Fall back to the `Theme URI` defined in `style.css`.
		if ( ! $button_url && $theme->get( 'ThemeURI' ) ) {
			$button_url = $theme->get( 'ThemeURI' );
		// Fall back to the `Author URI` defined in `style.css`.
		} elseif ( ! $button_url && $theme->get( 'AuthorURI' ) ) {
			$button_url = $theme->get( 'AuthorURI' );
		}
		$json['button_text'] = $this->button_text ? $this->button_text : $theme->get( 'Name' );
		$json['button_url']  = esc_url( $button_url );

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() { ?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<# if ( data.title) { #>
				<span class="upsell_field_txt">{{ data.title }}</span>
			<# } #>

			<# if ( data.button_text && data.button_url ) { #>
				<a href="{{ data.button_url }}" class="button button-secondary" target="_blank">{{ data.button_text }}</a>
			<# } #>
		</li>
	<?php }
}