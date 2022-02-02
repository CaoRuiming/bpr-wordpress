<?php
/**
 * Element multicheckbox custom elementor control.
 * 
 */
class News_Block_Multicheckbox_Control extends \Elementor\Base_Data_Control {
    /**
     * Control name.
     */
    public function get_type() {
        return 'MULTICHECKBOX';
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
        wp_enqueue_script( 'blaze-mag-modules-multicheckbox-control', NEWS_BLOCK_ELEMENTOR_DIR_URI . 'custom-controls/multicheckbox/multicheckbox.js', array( 'jquery' ), NEWS_BLOCK_VERSION, true );
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
        <div id="elementor-multicheckbox-control-field">
            <label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper bmm-elementor-custom-control">
                <div id="<?php echo esc_attr( $control_uid ); ?>" class="bmm-multicheckbox-control-wrap">
                    <# _.each( data.options, function( option, key ) { #>
                        <div class="bmm-multicheckbox-item <# if( _.contains( data.controlValue, key ) ) { #>isActive<# } #>">
                            <input type="checkbox" value="{{{ key }}}" name="{{{ data.name }}}" class="bmm-multicheckbox-field" <# if( _.contains( data.controlValue, key ) ) { #>checked<# } #>>
                            <label class="bmm-multicheckbox-label">{{{ option }}}</label>
                        </div>
                    <# }); #>
                </div>
            </div>
        </div>
    <?php
    }
}