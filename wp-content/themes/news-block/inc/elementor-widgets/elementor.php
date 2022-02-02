<?php
/**
 * Handles the admin-specific hooks, and
 * public-facing site hooks.
 * 
 * @package News Block
 * @since 1.0.0
 * 
 */
if ( !class_exists( 'News_Block_Elements' ) ):
    class News_Block_Elements {
        /**
         * Instance
         *
         * @access private
         * @static
         *
         * @var News_Block_Elements The single instance of the class.
         */
        private static $_instance = null;

        /**
         * Ensures only one instance of the class is loaded or can be loaded.
         *
         * @access public
         * @static
         *
         * @return News_Block_Elements An instance of the class.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Load the dependencies and set the hooks for the admin area and
         * the public-facing side of the element.
         */
        public function __construct() {
            add_action( 'init', array( $this, 'init' ), 99 );
        }
        
        /**
         * Initialize the dependencies necessary hooks.
         */
        public function init() {
            if ( ! did_action( 'elementor/loaded' ) ) {
                define( 'NEWS_BLOCK_ELEMENTOR', false );
                return;
            }
            $GLOBALS['blazemagemodulespaged'] = 1;
            define( 'NEWS_BLOCK_ELEMENTOR_DIR', get_template_directory() . '/inc/elementor-widgets/' );
            define( 'NEWS_BLOCK_ELEMENTOR_DIR_URI', get_template_directory_uri() . '/inc/elementor-widgets/' );

            add_action( 'elementor/elements/categories_registered', array( $this, 'add_elements_categories' ) );
            
            // //Register custom control
            add_action( 'elementor/controls/controls_registered', array( $this, 'register_control' ) );

            // Register elements
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
            add_action( 'elementor/editor/before_enqueue_styles', array( $this, 'elementor_editor_enqueue_styles' ) );
            add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'elementor_enqueue_scripts' ) );
        }

        /**
         * Register new control
         */
        public function register_control() {
            // Inlcude control files.
            require_once( NEWS_BLOCK_ELEMENTOR_DIR . 'custom-controls/radio-image/radio-image.php' );
            require_once( NEWS_BLOCK_ELEMENTOR_DIR . 'custom-controls/multicheckbox/multicheckbox.php' );
            
            //Register control
            $controls_manager = \Elementor\Plugin::$instance;
            $controls_manager->controls_manager->register_control( 'RADIOIMAGE', new News_Block_Radio_Image_Control() );
            $controls_manager->controls_manager->register_control( 'MULTICHECKBOX', new News_Block_Multicheckbox_Control() );
        }

        /**
         * Initialize the widgets in elementor
         * 
         */
        public function init_widgets() {
            // Include Widget files
            require_once( NEWS_BLOCK_ELEMENTOR_DIR . 'post-grid/element.php' );
            require_once( NEWS_BLOCK_ELEMENTOR_DIR . 'post-list/element.php' );
            require_once( NEWS_BLOCK_ELEMENTOR_DIR . 'post-grid-alter/element.php' );
            require_once( NEWS_BLOCK_ELEMENTOR_DIR . 'post-carousel/element.php' );
            require_once( NEWS_BLOCK_ELEMENTOR_DIR . 'post-grid-boxed/element.php' );

            // Register widget
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \News_Block_Post_Grid_Element() ); // grid element
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \News_Block_Post_List_Element() ); // list element
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \News_Block_Post_Grid_Alter_Element() ); // grid alter element
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \News_Block_Post_Carousel_Element() ); // carousel element
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \News_Block_Post_Grid_Boxed_Element() ); // most viewed element
        }

        /**
         * Enqueue Editor elements scripts.
         */
        public function elementor_editor_enqueue_styles() {
            wp_enqueue_style( 'font-awesome-5-all',
                get_template_directory_uri() . '/assets/lib/fontawesome/css/all.min.css',
                array(),
                NEWS_BLOCK_VERSION,
                'all'
            );
        }

        /**
         * Enqueue elements scripts.
         */
        public function elementor_enqueue_scripts() {
            wp_enqueue_script( 'blaze-mag-modules-elementor-public-script',
                NEWS_BLOCK_ELEMENTOR_DIR_URI . '/assets/elementor.js',
                array( 'jquery' ),
                NEWS_BLOCK_VERSION,
                true
            );
        }

        /**
         * Init Widgets categories
         *
         * @since 1.0.0
         *
         * @access public
         */
        public function add_elements_categories( $elements_manager ) {
            $elements_manager->add_category(
                'news-block-elements',
                [
                    'title' => esc_html__( 'News Block Elements', 'news-block' )
                ]
            );
        }
    }
    News_Block_Elements::instance();
endif;