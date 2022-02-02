<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class core_blog_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . '/inc/custom-button/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'core_blog_Customize_Section_Pro' );

		// doc sections.
		$manager->add_section(
			new core_blog_Customize_Section_Pro(
				$manager,
				'core-blog',
				array(
					'title'    => esc_html__( 'Recommended Plugins', 'core-blog' ),
					'pro_text' => esc_html__( 'Install Now', 'core-blog' ),
					'pro_url'  => 'themes.php?page=tgmpa-install-plugins',
					'priority'  => 1
				)
			)
		);
		
		// Demo sections.
		$manager->add_section(
			new core_blog_Customize_Section_Pro(
				$manager,
				'core-blog-demo',
				array(
					'title'    => esc_html__( 'Upgrade To Pro', 'core-blog' ),
					'pro_text' => esc_html__( 'Click Here', 'core-blog' ),
					'pro_url'  => 'http://blogwpthemes.com/product/core-blog-pro-wordpress-theme/',
					'priority'  => 2
				)
			)
		);
		 	}
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'core-blog-customize-controls', trailingslashit( get_template_directory_uri() ) . '/inc/custom-button/customize-controls.js', array( 'customize-controls' ) );
		wp_enqueue_style( 'core-blog-customize-controls', trailingslashit( get_template_directory_uri() ) . '/inc/custom-button/customize-controls.css' );
	}
}
core_blog_Customize::get_instance();