<?php
/**
 * Radio tab control.
 *
 * @package News Block
 * @since  1.0.0
 */
class News_Block_WP_Radio_Tab_Control extends WP_Customize_Control {

    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'radio-tab';

    /**
     * Loads the jQuery UI Button script and custom scripts/styles.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function enqueue() {
        wp_enqueue_style(  'news-block-radio-tab', get_template_directory_uri() . '/inc/customizer/custom-controls/radio-tab/radio-tab.css', array(), NEWS_BLOCK_VERSION, 'all' );
        wp_enqueue_script( 'jquery-ui-button' );
        wp_enqueue_script( 'news-block-radio-tab', get_template_directory_uri() . '/inc/customizer/custom-controls/radio-tab/radio-tab.js', array( 'jquery' ), NEWS_BLOCK_VERSION, true );
    }

    /**
     * Add custom JSON parameters to use in the JS template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function to_json() {
        parent::to_json();
        $this->json['choices'] = $this->choices;
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

        <# if ( ! data.choices ) {
            return;
        } #>

        <# if ( data.label ) { #>
            <span class="customize-control-title">{{ data.label }}</span>
        <# } #>

        <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
        <# } #>

        <div class="buttonset">
            <# for ( key in data.choices ) { #>
                <div class="radio-tab-single-wrap">
                    <input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" {{{ data.link }}} <# if ( key === data.value ) { #> checked="checked" <# } #> />
                    <label for="{{ data.id }}-{{ key }}">
                        <span class="screen-reader-text">{{ data.choices[ key ]['label'] }}</span>
                        <# if( data.choices[ key ]['icon'] && data.choices[ key ]['label'] ) { #>
                            <i class="{{data.choices[ key ]['icon']}}"></i>
                            <span class="tab-label">{{ data.choices[ key ]['label'] }}</span>
                        <# } else if( data.choices[ key ]['icon'] ) { #>
                            <i class="{{data.choices[ key ]['icon']}}"></i>
                        <# } else { #>
                            <span class="tab-label">{{ data.choices[ key ]['label'] }}</span>
                        <# } #>
                    </label>
                </div><!-- .radio-tab-single-wrap -->
            <# } #>
        </div><!-- .buttonset -->
    <?php }
}