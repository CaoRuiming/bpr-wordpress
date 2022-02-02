<?php
/**
 * Radio tab control.
 *
 * @since  1.0.0
 */
class News_Block_Upsell_Control extends WP_Customize_Control {
    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'news-block-upsell';
    public $features;

    /**
     * Add custom JSON parameters to use in the JS template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function to_json() {
        parent::to_json();
        $this->json['features'] = $this->features;
        $this->json['link']    = $this->get_link();
        $this->json['value']   = $this->value();
        $this->json['id']      = $this->id;
    }

    /**
     * Underscore JS template to handle the control's output.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function content_template() { ?>
        <# if ( data.label ) { #>
            <span class="customize-control-title">{{ data.label }}</span>
        <# } #>

        <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
        <# } #>

       <# if ( data.features ) { #>
            <ul class="item-wrap">
                <# for ( key in data.features ) { #>
                    <li class="single-item">{{ data.features[ key ] }}</li>
                <# } #>
            </ul>
        <# } #>
        
    <?php }
}