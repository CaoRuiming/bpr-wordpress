<?php
/**
 * Sanitize functions
 * 
 * @package News Block
 * @since 1.0.0
 */

 if( !function_exists( 'news_block_sanitize_toggle_control' )  ) :
    /**
     * Sanitize toggle control value
     * 
     */
    function news_block_sanitize_toggle_control( $value ) {
        return rest_sanitize_boolean( $value );
    }
 endif;

 if( !function_exists( 'news_block_sanitize_repeater_control' ) ) :
    /**
     * Sanitize repeater field
     * 
     */
    function news_block_sanitize_repeater_control( $input ) {
        $input_decoded = json_decode( $input, true );
        if( !empty( $input_decoded ) ) {
            foreach( $input_decoded as $boxk => $box ) {
                foreach ( $box as $key => $value ) {
                    $input_decoded[$boxk][$key] = wp_kses_post( force_balance_tags( $value ) );
                }
            }
            return json_encode($input_decoded);
        }
        return $input;
    }
 endif;

 if( !function_exists( 'news_block_sanitize_select_control' ) ) :
    /**
     * Sanitize select control value
     * 
     */
    function news_block_sanitize_select_control( $input, $setting ) {
        // Ensure input is a slug.
        $input = sanitize_key( $input );
        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control( $setting->id )->choices;
        // If the input is a valid key, return it; otherwise, return the default.
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
endif;

// adds sanitization callback function for header style
if ( ! function_exists( 'news_block_sanitize_menuhover' ) ) :
    function news_block_sanitize_menuhover( $value ) {
      $menu_hover_effect = array( 'menu_hover_1', 'menu_hover_none' );
      if ( ! in_array( $value, $menu_hover_effect ) ) {
        $value = 'menu_hover_1';
      }
      return $value;
    }
  endif;