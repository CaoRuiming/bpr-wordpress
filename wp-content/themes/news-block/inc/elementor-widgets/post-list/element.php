<?php
/**
 * Post List Element
 * 
 * @package News Block
 * @since 1.0.0
 * 
 */
class News_Block_Post_List_Element extends \Elementor\Widget_Base {

    /**
     * @return - name of the widget
     */
    public function get_name() {
        return 'post-list';
    }

    /**
     * @return - title of the widget
     */
    public function get_title() {
        return esc_html__( 'Post List', 'news-block' );
    }

    /**
     * @return - icon for the widget
     */
    public function get_icon() {
        return 'fas fa-list';
    }

    /**
     * @return - category name for the widget
     */
    public function get_categories() {
        return [ 'news-block-elements' ];
    }

    /**
     * Get List of categories
     */
    public function blaze_mag_get_categories( $posttype ) {
        $categories_lists = [];
        $taxonomies = get_taxonomies( array( 'object_type' => array( $posttype ) ) );
        if( !empty( $taxonomies ) ) {
            foreach( $taxonomies as $news_block_taxonomy ) {
                $taxonomy_name = $news_block_taxonomy;
                break;
            }
            $categories = get_terms( $taxonomy_name );
            if( !empty( $categories ) ) {
                foreach( $categories as $category ) {
                    $categories_lists[ $category->slug ] = esc_html( $category->name ). ' ('.absint( $category->count ). ')';
                }
            }
        }
        return $categories_lists;
    }

    /**
     * add controls for widget.
     */
    protected function _register_controls() {

        //General Settings
        $this->start_controls_section(
            'general_setting_section',
            [
                'label' => esc_html__( 'General Setting', 'news-block' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'blockLayout',
            [
                'label' => esc_html__( 'Available Layouts', 'news-block' ),
                'type' => 'RADIOIMAGE',
                'default' => 'layout-default',
                'options' => [
                    [
                        'value' => 'layout-default',
                        'label' => get_template_directory_uri() . '/images/block-layouts/dummy.png',
                    ],
                    [
                        'value' => 'layout-one',
                        'label' => get_template_directory_uri() . '/images/block-layouts/dummy.png',
                    ],
                    [
                        'value' => 'layout-two',
                        'label' => get_template_directory_uri() . '/images/block-layouts/dummy.png',
                    ]
                ],
            ]
        );

        $this->add_control(
            'blockTitleOption',
            [
                'label' => esc_html__( 'Show block title', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'show',
            ]
        );

        $this->add_control(
            'blockTitle',
            [
                'label'     => esc_html__( 'Block Title', 'news-block' ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__( 'News Block Post List Title', 'news-block' ),
                'placeholder' => esc_html__( 'Enter title', 'news-block' ),
                'condition' => [
                    'blockTitleOption' => 'show'
                ]
            ]
        );

        $this->add_control(
            'postCategory',
            [
                'label' => esc_html__( 'Post Categories', 'news-block' ),
                'type' => 'MULTICHECKBOX',
                'options' => $this->blaze_mag_get_categories( 'post' ),
            ]
        );
        
        $this->add_control(
            'buttonOption',
            [
                'label' => esc_html__( 'Show read more button', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'hide',
            ]
        );

        $this->add_control(
            'buttonLabel',
            [
                'label' => esc_html__( 'Button Label', 'news-block' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Add label here...', 'news-block' ),
                'default'   => esc_html__( 'Read more', 'news-block' ),
                'condition' => [
                    'buttonOption' => 'show'
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'query_setting_section',
            [
                'label' => esc_html__( 'Query Setting', 'news-block' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'postCount',
            [
                'label' => esc_html__( 'Post Count', 'news-block' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 200,
                'step' => 1,
                'default' => 2,
            ]
        );
        
        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Order', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'   => esc_html__( 'Ascending', 'news-block' ),
                    'desc'   => esc_html__( 'Descending', 'news-block' )
                ]
            ]
        );

        $this->add_control(
            'thumbOption',
            [
                'label' => esc_html__( 'Show thumbnail', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'show',
            ]
        );

        $this->add_control(
            'titleOption',
            [
                'label' => esc_html__( 'Show title', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'show',
            ]
        );

        $this->add_control(
            'dateOption',
            [
                'label' => esc_html__( 'Show date', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'hide',
            ]
        );
        
        $this->add_control(
            'authorOption',
            [
                'label' => esc_html__( 'Show author', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'hide',
            ]
        );
        
        $this->add_control(
            'categoryOption',
            [
                'label' => esc_html__( 'Show categories', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'hide',
            ]
        );
        
        $this->add_control(
            'tagsOption',
            [
                'label' => esc_html__( 'Show tags', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'hide',
            ]
        );
        
        $this->add_control(
            'commentOption',
            [
                'label' => esc_html__( 'Show comments number', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'hide',
            ]
        );

        $this->add_control(
            'contentOption',
            [
                'label' => esc_html__( 'Show content', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'show',
            ]
        );
         
        $this->add_control(
            'contentType',
            [
                'label' => esc_html__( 'Content Type', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'excerpt',
                'options' => [
                    'excerpt'   => esc_html__( 'Excerpt', 'news-block' ),
                    'content'   => esc_html__( 'Content', 'news-block' )
                ],
                'condition' => [
                    'contentOption' => 'show'
                ],
            ]
        );
        $this->end_controls_section();

        /**************************************************************/
        $this->start_controls_section(
            'extra_option_section',
            [
            'label' => esc_html__( 'Extra Settings', 'news-block' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'permalinkTarget',
            [
                'label' => esc_html__( 'Links open in', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '_self',
                'options' => [
                    '_self'  => esc_html__( 'Same Tab', 'news-block' ),
                    '_blank'  => esc_html__( 'New Tab', 'news-block' )
                ],
            ]
        );

        $this->add_control(
            'imageHoverType',
            [
                'label' => esc_html__( 'Image Hover Type', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'  => esc_html__( 'None', 'news-block' ),
                    'effect-one'    => esc_html__( 'Effect One', 'news-block' ),
                    'effect-two'    => esc_html__( 'Effect Two', 'news-block' )
                ],
            ]
        );

        $this->add_control(
			'pagination_options',
			[
				'label' => __( 'Pagination Settings', 'news-block' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'paginationOption',
            [
                'label' => esc_html__( 'Enable Pagination', 'news-block' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'news-block' ),
                'label_off' => esc_html__( 'Hide', 'news-block' ),
                'show' => esc_html__( 'Show', 'news-block' ),
                'hide' => esc_html__( 'Hide', 'news-block' ),
                'return_value' => 'show',
                'default' => 'hide',
            ]
        );

        $this->end_controls_section();

        /**************************************************/
        $this->start_controls_section(
            'element_color_section',
            [
            'label' => esc_html__( 'Color Settings', 'news-block' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'blockPrimaryColor',
            [
                'label' => esc_html__( 'Primary Color', 'news-block' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#004F71',
                'selectors' => [
                    '{{WRAPPER}} .bmm-block-title.layout--one' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .bmm-post-title:hover' => 'color: {{VALUE}}'
                ],
            ]
        );
        $this->end_controls_section();
    }
    
    /**
     * renders the widget content.
     */
    protected function render() {
        global $blazemagemodulespaged;
        $settings = $this->get_settings_for_display();
        extract( $settings );
        $element_id = $this->get_id();
        $posttype = 'post';
        $blockTitleOption   = ( $blockTitleOption === 'show' );
        $buttonOption       = ( $buttonOption === 'show' );
        $contentOption      = ( $contentOption === 'show' );
        $thumbOption        = ( $thumbOption === 'show' );
        $titleOption        = ( $titleOption === 'show' );
        $dateOption         = ( $dateOption === 'show' );
        $authorOption       = ( $authorOption === 'show' );
        $categoryOption     = ( $categoryOption === 'show' );
        $tagsOption         = ( $tagsOption === 'show' );
        $commentOption      = ( $commentOption === 'show' );
        $paginationOption   = ( $paginationOption === 'show' );
        $paged = 1;
        if( $paginationOption ) {
            if( isset( $_GET[ 'listpaged'.$blazemagemodulespaged ] ) ) {
                $paged = absint( $_GET[ 'listpaged'.$blazemagemodulespaged ] );
            }
        }
        
        echo '<div id="blaze-mag-modules-post-list-block-'.esc_attr( $element_id ).'" class="blaze-mag-modules-post-list-block block-'.esc_attr( $element_id ).' bmm-block bmm-block-post-list--'.esc_html( $blockLayout ).' bmm-block-image-hover--'.esc_html( $imageHoverType ).'">';
            if( !empty( $blockTitle ) ) {
                echo '<h2 class="bmm-block-title layout--default">'.esc_html( $blockTitle ).'</h2>';
            }
            // include template file w.r.t layout value
            include( NEWS_BLOCKS_INCLUDES_PATH .'elementor-widgets/post-list/'.$blockLayout.'/'.$blockLayout.'.php' );

            if( $paginationOption ) {
                $paginate_args = array(
                                'format' => '?listpaged'.$blazemagemodulespaged.'=%#%',
                                'current' => max( 1, $paged ),
                                'total' => $max_num_pages,
                                'type' => 'list'
                            );  
                echo '<div class="bmm-pagination-links">' . paginate_links( $paginate_args ) . '</div><!-- .bmm-pagination-links -->';
                                $blazemagemodulespaged++;
            }
        echo '</div><!-- #blaze-mag-modules-post-list-block -->';
    }
}