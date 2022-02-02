<?php
/**
 * 
 * @package News Block
 * @since 1.0.0
 */
if( !class_exists( 'News_Block_Theme_Info' ) ) :
    class News_Block_Theme_Info {
        /**
         * Variable
         */ 
        protected $theme_name;
        protected $version;
        protected $demofile;
        protected $importer_status;
        public $ajax_response = array();
        private static $_instance = null;

        /**
         * Ensures only one instance of the class is loaded or can be loaded
         * 
         * @access public
         * @static
         */
        public static function instance() {
            if( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Initial class load
         * 
         */
        function __construct() {
            $this->theme_name = esc_html( 'News Block' );
            $this->version = '1.7.0';
            $this->demofile = include get_template_directory() . '/inc/admin/assets/demos.php';
            // some actions of welcome notice
            if( isset( $_GET['news_block_welcome_notice_dismiss'] ) ) {
                update_option( 'news_block_welcome_notice_disable', true );
            }

            //Add the theme page
            add_action( 'admin_menu', array( $this, 'add_theme_info_menu' ) );
            add_action( 'admin_notices', array( $this, 'add_welcome_admin_notice' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'theme_info_scripts' ) );
            add_action( 'wp_ajax_news_block_importer_plugin_action', array( $this, 'news_block_importer_plugin_action' ) );
        }
        
        /**
         * Enqueue scripts
         * 
         */
        function theme_info_scripts($hook) {
            $news_block_welcome_notice_disable = get_option( 'news_block_welcome_notice_disable' );
            if( !$news_block_welcome_notice_disable ) {
                wp_enqueue_style( 'news-block-welcome-notice', get_template_directory_uri() . '/inc/admin/assets/welcome-notice.css', array(), esc_attr( $this->version ), 'all' );
            }

            if( $hook != "appearance_page_news-block-info" ) {
                return;
            }
            wp_enqueue_style( 'news-block-info', get_template_directory_uri() . '/inc/admin/assets/info-page.css', array(), esc_attr( $this->version ), 'all' );
            wp_enqueue_script( 'news-block-info', get_template_directory_uri() . '/inc/admin/assets/info-page.js', array( 'jquery' ), esc_attr( $this->version ), true );
            wp_localize_script( 'news-block-info', 'articleThememInfoObject', array(
                'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
                '_wpnonce'  => wp_create_nonce( 'news-block-theme-info-nonce' )
            ));
        }

        /**
         * Register admin menu for theme info
         * 
         */
        function add_theme_info_menu() {
            $theme_info = add_theme_page( 
                esc_html__( 'News Block Info', 'news-block' ), 
                esc_html__( 'News Block Info','news-block' ), 
                'manage_options', 
                'news-block-info.php', 
                array( $this, 'info_page_callback' )
            );
        }

        /**
         * Theme info page callback
         * 
         * renders the theme info structure
         */
        function info_page_callback() {
        ?>
            <div id="theme-info-admin">
                <div class="info-container">
                    <h2 class="info-title"><?php echo esc_html( $this->theme_name ). ' - ' . esc_attr( $this->version ); ?></h2>
                    <div class="info-block">
                        <a href="<?php echo esc_url('//doc.blazethemes.com/news-block/');?>" target="_blank" class="dashicons dashicons-book-alt info-icon"></a>
                        <p class="info-text">
                            <a href="<?php echo esc_url('//doc.blazethemes.com/news-block/');?>" target="_blank"><?php esc_html_e( 'Setup Tutorials', 'news-block' ); ?></a>
                        </p>
                    </div>
                    <div class="info-block">
                        <a href="<?php echo esc_url( '//www.blazethemes.com/support' ); ?>" target="_blank" class="dashicons dashicons-sos info-icon"></a>
                        <p class="info-text">
                            <a href="<?php echo esc_url( '//www.blazethemes.com/support' ); ?>" target="_blank"><?php esc_html_e('Support','news-block'); ?></a>
                        </p>
                    </div>
                    <div class="info-block">
                        <a href="<?php echo esc_url( '//demo.blazethemes.com/news-block' ); ?>" target="_blank" class="dashicons dashicons-desktop info-icon"></a>
                        <p class="info-text">
                            <a href="<?php echo esc_url( '//demo.blazethemes.com/news-block' ); ?>" target="_blank"><?php esc_html_e('Theme demo','news-block'); ?></a>
                        </p>
                    </div>
                </div><!-- .info-container -->
                <div class="theme-premium-features">
                    <h2 class="section-title"><?php esc_html_e( 'More On News Block Premium', 'news-block' ); ?></h2>
                    <div class="section-column-wrap">
                        <div class="features-column premium_description">
                            <?php esc_html_e( 'Fully compatible with WordPress popular theme builder Elementor and Gutenberg. With easy Drag & Drop you can give professional layouts to your websites. Compatible with latest WordPress version and with Few Easy Steps you can import any available demos to setup your website. Create news websites with news block template. Being multipurpose theme it is perfect for news and blog website.', 'news-block' ); ?>
                              
                        </div>
                        <div class="features-column upgrade_description">
                            <div class="upgrade_description_inner">
                                <div class="discount_code">
                                    <?php esc_html_e( 'Upgrade for $44.10 (10% off)', 'news-block' ); ?>
                                </div>
                                <a class="upgrade-button button button-primary" href="<?php echo esc_url( '//blazethemes.com/themes/news-block-pro' ); ?>" target="__blank"><?php echo sprintf( '%1s %2s', esc_html__( 'Upgrade To Premium Now', 'news-block' ), '' ) ?></a>
                                <div class="coupon_code">
                                    <span class="coupon_text">
                                        <?php esc_html_e( 'blaze10', 'news-block' ); ?>
                                        </span>
                                    <span>
                                    <?php esc_html_e( 'Use Coupon Code at Checkout', 'news-block' ); ?>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="theme-demos-listing">
                    <h2 class="info-title"><?php esc_html_e( 'Free and Premium Demos', 'news-block' ); ?></h2>
                    <div class="demo-importer-actions">
                        <?php
                            $this->importer_status = $this->plugin_active_status('blazethemes-demo-importer/blazethemes-demo-importer.php');
                            switch( $this->importer_status ) {
                                case 'inactive' : printf( esc_html__( 'Activate Blazethemes Demo Importer Now and Import any available demo in One Click', 'news-block') . ' %s', '<button class="news-block-importer-action-trigger" data-action="activate" data-process="' .esc_html( "Activating plugin" ). '">' .esc_html( 'Activate Plugin' ). '</button>' ); 
                                                break;
                                case 'install'  : printf( esc_html__( 'Install BlazeThemes Demo Importer and Import any available demo in One Click', 'news-block') . ' %s', '<button class="news-block-importer-action-trigger" data-action="install" data-process="' .esc_html( "Installing plugin" ). '">' .esc_html( 'Install and Activate Plugin' ). '</button>' );
                                                break;
                                        default: esc_html_e( 'All Ready for demo import!! Setup your site exactly like demo', 'news-block' );
                            }
                        ?>
                    </div>
                </div>
                <?php $this->theme_display_demos(); ?>
            </div><!-- #theme-info-admin -->
        <?php
        }

        /*
         *  Display the available demos
         */

        function theme_display_demos() {
            ?>
            <div class="wrap blazethemes-demo-importer-demo-importer-wrap">
                <?php
                if (is_array($this->demofile) && !is_null($this->demofile) && !empty($this->demofile)) {
                    $tags = array();
                    foreach ($this->demofile as $demo_slug => $demo_pack) {
                        if (isset($demo_pack['tags']) && is_array($demo_pack['tags'])) {
                            foreach ($demo_pack['tags'] as $key => $tag) {
                                $tags[$key] = $tag;
                            }
                        }
                    }
                    asort($tags);
                    
                    if ( !empty( $tags ) ) {
                        ?>
                        <div class="blazethemes-demo-importer-tab-filter blazethemes-demo-importer-clearfix">
                            <?php
                                if (!empty($tags)) {
                                    ?>
                                    <div class="blazethemes-demo-importer-tab-group" data-filter-group="tag">
                                        <div class="blazethemes-demo-importer-tab blazethemes-demo-importer-active" data-filter="*">
                                            <?php esc_html_e('All', 'news-block'); ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="blazethemes-demo-importer-demo-box-wrap wp-clearfix">
                        <?php
                        // Loop through Demos
                        foreach ($this->demofile as $demo_slug => $demo_pack) {
                            $tags = $class = '';
                            if (isset($demo_pack['tags'])) {
                                $tags = implode(' ', array_keys($demo_pack['tags']));
                            }

                            $classes = $tags;

                            $type = isset($demo_pack['type']) ? $demo_pack['type'] : 'free';
                            ?>
                            <div id="<?php echo esc_attr($demo_slug); ?>" class="blazethemes-demo-importer-demo-box <?php echo esc_attr($classes); ?>">
                                <div class="blazethemes-demo-importer-demo-elements">
                                    <?php if ( $type == 'pro' ) { ?>
                                        <div class="premium_label">
                                            <?php esc_html_e( 'Premium', 'news-block' ); ?>
                                        </div>
                                    <?php } else if( $type == 'free' ) { ?>
                                        <div class="free_label"><?php esc_html_e( 'Free', 'news-block' ); ?></div>
                                    <?php } ?>

                                    <img src="<?php echo esc_url($demo_pack['image']); ?>">
                                    
                                    <div class="blazethemes-demo-importer-demo-actions">
                                        <h4><?php echo esc_html($demo_pack['name']); ?></h4>
                                        <?php
                                            if( $type != 'coming-soon' ) {
                                        ?>
                                            <div class="blazethemes-demo-importer-demo-buttons">
                                                <a href="<?php echo esc_url($demo_pack['preview_url']); ?>" target="_blank" class="button">
                                                    <?php echo esc_html__('Preview', 'news-block'); ?>
                                                </a>
                                                <?php
                                                    if ( $type == 'pro' && ! strpos( get_option('stylesheet'), 'pro' ) ) {
                                                        $buy_url = isset($demo_pack['buy_url']) ? $demo_pack['buy_url'] : '#';
                                                    ?>
                                                        <a target="_blank" href="<?php echo esc_url($buy_url) ?>" class="button button-primary">
                                                            <?php echo esc_html__('Buy Now', 'news-block') ?>
                                                        </a>
                                                <?php } else {
                                                            if( $this->importer_status === 'active' ) {
                                                    ?>
                                                                <a href="#blazethemes-demo-importer-modal-<?php echo esc_attr($demo_slug) ?>" class="blazethemes-demo-importer-modal-button button button-primary">
                                                                    <?php echo esc_html__('Install', 'news-block') ?>
                                                                </a>
                                                <?php 
                                                            }
                                                        }
                                                ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php
                                        if( isset( $demo_pack['pagebuilder'] ) ) {
                                            foreach( $demo_pack['pagebuilder'] as $pagebuilder ) {
                                                echo '<h4 class="pagebuilder-label">' .esc_html( $pagebuilder ). '</h4>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php }
                        ?>
                    </div>
            <?php } else {
                    ?>
                    <div class="blazethemes-demo-importer-demo-wrap">
                        <?php esc_html_e("It looks like the config file for the demos is missing or contains errors!. Demo install can't go futher!", 'news-block'); ?>  
                    </div>
                <?php }
                ?>

                <?php
                /* Demo Modals */
                if (is_array($this->demofile) && !is_null($this->demofile)) {
                    foreach ($this->demofile as $demo_slug => $demo_pack) {
                        ?>
                        <div id="blazethemes-demo-importer-modal-<?php echo esc_attr($demo_slug) ?>" class="blazethemes-demo-importer-modal" style="display: none;">

                            <div class="blazethemes-demo-importer-modal-header">
                                <h2><?php printf(esc_html('Import %s Demo', 'news-block'), esc_html($demo_pack['name'])); ?></h2>
                                <div class="blazethemes-demo-importer-modal-back"><span class="dashicons dashicons-no-alt"></span></div>
                            </div>

                            <div class="blazethemes-demo-importer-modal-wrap">
                                <p><?php echo sprintf(esc_html__('We recommend you backup your website content before attempting to import the demo so that you can recover your website if something goes wrong. You can use %s plugin for it.', 'news-block'), '<a href="https://wordpress.org/plugins/all-in-one-wp-migration/" target="_blank">' . esc_html__('All in one migration', 'news-block') . '</a>'); ?></p>

                                <p><?php echo esc_html__('This process will install all the required plugins, import contents and setup customizer and theme options.', 'news-block'); ?></p>

                                <div class="blazethemes-demo-importer-modal-recommended-plugins">
                                    <h4><?php esc_html_e('Required Plugins', 'news-block'); ?></h4>
                                    <p><?php esc_html_e('For your website to look exactly like the demo,the import process will install and activate the following plugin if they are not installed or activated.', 'news-block'); ?></p>
                                    <?php
                                    $plugins = isset( $demo_pack['plugins'] ) ? $demo_pack['plugins'] : '';

                                    if (is_array( $plugins ) ) {
                                        ?>
                                        <ul class="blazethemes-demo-importer-plugin-status">
                                            <?php
                                            foreach ( $plugins as $plugin ) {
                                                $name = isset( $plugin['name'] ) ? $plugin['name'] : '';
                                                $status = $this->plugin_active_status($plugin['file_path']);
                                                if ($status == 'active') {
                                                    $plugin_class = '<span class="dashicons dashicons-yes-alt"></span>';
                                                } else if ($status == 'inactive') {
                                                    $plugin_class = '<span class="dashicons dashicons-warning"></span>';
                                                } else {
                                                    $plugin_class = '<span class="dashicons dashicons-dismiss"></span>';
                                                }
                                                ?>
                                                <li class="blazethemes-demo-importer-<?php echo esc_attr($status); ?>">
                                                    <?php
                                                    echo $plugin_class . ' ' . esc_html($name) . ' - <i>' . $this->get_plugin_status($status) . '</i>';
                                                    ?>
                                                </li>
                                            <?php }
                                            ?>
                                        </ul>
                                        <?php
                                    } else {
                                        ?>
                                        <ul>
                                            <li><?php esc_html_e('No Required Plugins Found.', 'news-block'); ?></li>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="blazethemes-demo-importer-reset-checkbox">
                                    <h4><?php esc_html_e('Reset Website', 'news-block') ?></h4>
                                    <p><?php esc_html_e('Reseting the website will delete all your post, pages, custom post types, categories, taxonomies, images and all other customizer and theme option settings.', 'news-block') ?></p>
                                    <p><?php esc_html_e('It is always recommended to reset the database for a complete demo import.', 'news-block') ?></p>
                                    <label class="blazethemes-demo-importer-reset-website-checkbox">
                                        <input id="checkbox-reset-<?php echo esc_attr($demo_slug); ?>" type="checkbox" value='1' checked="checked"/>
                                        <?php echo esc_html('Reset Website - Check this box only if you are sure to reset the website.', 'news-block'); ?>
                                    </label>
                                </div>

                                <a href="javascript:void(0)" data-demo-slug="<?php echo esc_attr($demo_slug) ?>" class="button button-primary blazethemes-demo-importer-import-demo"><?php esc_html_e('Import Demo', 'news-block'); ?></a>
                                <a href="javascript:void(0)" class="button blazethemes-demo-importer-modal-cancel"><?php esc_html_e('Cancel', 'news-block'); ?></a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div id="blazethemes-demo-importer-import-progress" style="display: none">
                    <h2 class="blazethemes-demo-importer-import-progress-header"><?php echo esc_html__('Demo Import Progress', 'news-block'); ?></h2>

                    <div class="blazethemes-demo-importer-import-progress-wrap">
                        <div class="blazethemes-demo-importer-import-loader">
                            <div class="blazethemes-demo-importer-loader-content">
                                <div class="blazethemes-demo-importer-loader-content-inside">
                                    <div class="blazethemes-demo-importer-loader-rotater"></div>
                                    <div class="blazethemes-demo-importer-loader-line-point"></div>
                                </div>
                            </div>
                        </div>
                        <div class="blazethemes-demo-importer-import-progress-message"></div>
                    </div>
                </div>
            </div>
            <?php
        }

        /** 
         * Check if Plugin is active or not
         */
        function plugin_active_status($file_path) {
            $status = 'install';
            $plugin_path = WP_PLUGIN_DIR . '/' . esc_attr($file_path);

            if (file_exists($plugin_path)) {
                $status = is_plugin_active($file_path) ? 'active' : 'inactive';
            }

            return $status;
        }

        public function get_plugin_status($status) {
            switch ($status) {
                case 'install':
                    $plugin_status = esc_html__('Not Installed', 'news-block');
                    break;

                case 'active':
                    $plugin_status = esc_html__('Installed and Active', 'news-block');
                    break;

                case 'inactive':
                    $plugin_status = esc_html__('Installed but Not Active', 'news-block');
                    break;
            }
            return $plugin_status;
        }

        /**
         * Activate or install importer plugin 
         * 
         */
        function news_block_importer_plugin_action() {
            check_ajax_referer( 'news-block-theme-info-nonce', '_wpnonce' );
            $_plugin_action = isset( $_REQUEST['plugin_action'] ) ? sanitize_text_field( $_REQUEST['plugin_action'] ) : '';
            $file_path = 'blazethemes-demo-importer/blazethemes-demo-importer.php';
            if( $_plugin_action === 'activate' ) {
                if( $file_path ) {
                    activate_plugin( $file_path, '', false, true );
                }
                $this->ajax_response['status'] = true;
                $this->ajax_response['message'] = esc_html__( 'Demo importer plugin activated', 'news-block' );
                $this->send_ajax_response();
            } else if( $_plugin_action === 'install' ) {
                $download_link = esc_url( 'demo.blazethemes.com/blazethemes-demo-importer/blazethemes-demo-importer.zip' );
                // Include required libs for installation
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
                require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
                $skin = new WP_Ajax_Upgrader_Skin();
                $upgrader = new Plugin_Upgrader($skin);
                $upgrader->install( $download_link );
                activate_plugin( $file_path, '', false, true );
                $this->ajax_response['status'] = true;
                $this->ajax_response['message'] = esc_html__( 'Demo importer plugin installed and activated', 'news-block' );
                $this->send_ajax_response();
            }
            $this->ajax_response['status'] = false;
            $this->ajax_response['message'] = esc_html__( 'Error while trying to install or active the plugin.', 'news-block' );
            $this->send_ajax_response();
        }

        public function send_ajax_response() {
            $json = wp_json_encode( $this->ajax_response );
            echo $json;
            die();
        }

        /**
         * Add welcome notice to the admin dashboard
         * 
         * @since 1.3.0
         */
        function add_welcome_admin_notice() {
            if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
            $news_block_welcome_notice_disable = get_option( 'news_block_welcome_notice_disable' );
            if( $news_block_welcome_notice_disable ) {
                return;
            }
        ?>
            <div class="news-block-welcome-notice notice notice-info is-dismissible">
                <h2><?php esc_html_e( 'News Block Welcome Notice', 'news-block' ); ?></h2>
                <div class="notice-content-wrap">
                    <div class="screenshot-wrap">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" height="200" height="200"/>
                    </div>
                    <div class="notice-content">
                        <span class="notice-highlight"><?php esc_html_e( 'You have successfully activated News Block !! ', 'news-block' ); ?></span>
                        <p><?php esc_html_e( 'Get started with multipurpose magazine theme and give your site a new look. We recommend you to please go through the documentation to get started with theme and setup homepage quicky.', 'news-block' ); ?></p>
                        <div class="notice-actions">
                            <a class="button button-primary load-customize hide-if-no-customize" href="<?php echo esc_url( get_admin_url() . '/themes.php?page=news-block-info.php' ); ?>"><?php esc_html_e( 'Install Demos', 'news-block' ); ?></a>
                            <a class="button button-primary load-customize hide-if-no-customize" target="_blank" href="<?php echo esc_url( get_admin_url( '', 'customize.php' ) ); ?>"><?php esc_html_e( 'Customize Site', 'news-block' ); ?></a>
                            <a class="button button-primary load-customize hide-if-no-customize" target="_blank" href="<?php echo esc_url( '//doc.blazethemes.com/news-block/ '); ?>"><?php esc_html_e( 'Documentation', 'news-block' ); ?></a>
                        </div>
                    </div>
                </div><!-- .notice-content-wrap -->
                <div class="notice-dismiss-button">
                    <a class="" href="<?php echo esc_attr( '?news_block_welcome_notice_dismiss=1' ); ?>"><?php esc_html_e( 'Dismiss this notice', 'news-block' ); ?></a>
                </div>
            </div>
            <?php
        }
    }
    News_Block_Theme_Info::instance();
endif;