<?php
/**
 * Element radio image custom elementor control.
 * 
 */
class News_Block_Radio_Image_Control extends \Elementor\Base_Data_Control {
    /**
     * Control name.
     */
    public function get_type() {
        return 'RADIOIMAGE';
    }
    
    /**
     * Enqueue control scripts and styles.
     *
     * Used to register and enqueue custom scripts and styles used by control.
     *
     * @since 1.0.0
     * @access public
     */
    public function enqueue() {
        wp_enqueue_style( 'news-block-elementor-radio-image-control', NEWS_BLOCK_ELEMENTOR_DIR_URI . 'custom-controls/radio-image/radio-image.css', array(), NEWS_BLOCK_VERSION, 'all' );

        wp_enqueue_script( 'news-block-elementor-radio-image-control', NEWS_BLOCK_ELEMENTOR_DIR_URI . 'custom-controls/radio-image/radio-image.js', array( 'jquery' ), NEWS_BLOCK_VERSION, true );
    }
    
    protected function get_default_settings() {
		return array(
			'label_block' => true,
			'options' => array(),
        );
    }
    
    public function content_template() {
        $control_uid = $this->get_control_uid();
    ?>
        <div id="elementor-radio-image-control-field">
            <label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper bmm-elementor-custom-control">
                <ul id="<?php echo esc_attr( $control_uid ); ?>" class="bmm-radio-image-control-wrap">
                    <# _.each( data.options, function( option ) { #>
                        <li class='bmm-radio-image-item <# if( option.value === data.controlValue ) { #>isActive<# } #>' data-value="{{ option.value }}">
                            {{ option.value }}
                            <i class="bmm-preview far fa-eye"></i>
                            <div class="bmm-preview-image-enlarge">
                                <img src="{{ option.label }}" alt="{{ option.value }}" />
                            </div>
                        </li>
                    <# }); #>
                </ul>
            </div>
        </div>
    <?php
    }
}