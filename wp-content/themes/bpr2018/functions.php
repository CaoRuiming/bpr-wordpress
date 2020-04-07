<?php

/*
 |------------------------------------------------------------------
 | Bootstraping a Theme
 |------------------------------------------------------------------
 |
 | This file is responsible for bootstrapping your theme. Autoloads
 | composer packages, checks compatibility and loads theme files.
 | Most likely, you don't need to change anything in this file.
 | Your theme custom logic should be distributed across a
 | separated components in the `/app` directory.
 |
 */

// Require Composer's autoloading file
// if it's present in theme directory.
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    require $composer;
}

// Before running we need to check if everything is in place.
// If something went wrong, we will display friendly alert.
$ok = require_once __DIR__ . '/bootstrap/compatibility.php';

if ($ok) {
    // Now, we can bootstrap our theme.
    $theme = require_once __DIR__ . '/bootstrap/theme.php';

    // Autoload theme. Uses localize_template() and
    // supports child theme overriding. However,
    // they must be under the same dir path.
    (new Tonik\Gin\Foundation\Autoloader($theme->get('config')))->register();
}

// Register Custom Navigation Walker
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';


// quick way to get url of images in the assets folder
function get_image_asset($image_name = '') {
    $images_directory = get_template_directory_uri() . '/resources/assets/images/';
    return $images_directory . $image_name;
}

// Define custom shortcode callback functions
function dropcap_shortcode_function($atts, $content=null) {
    return $content; // nothing special happens to dropcaps for now
}
function pullquote_shortcode_function($atts, $content=null) {
    return '<div class="pullquote right">"'.$content.'"</div>';
}

// register custom footer nav menu position
register_nav_menu('footer', 'Footer');

// Register custom shortcodes
function register_shortcodes() {
    add_shortcode('dropcap', 'dropcap_shortcode_function');
    add_shortcode('pullquote', 'pullquote_shortcode_function');
}
add_action('init', 'register_shortcodes');

// Register custom scripts
function register_scripts() {
    $path = get_template_directory_uri() . '/resources/assets/js/scripts/';

    wp_deregister_script('jquery');
    wp_register_script('jquery', $path . 'jquery-3.4.1.min.js');
    wp_enqueue_script('jquery');

    wp_register_script('slick', $path . 'slick.min.js', array('jquery'));
    wp_enqueue_script('slick');

    wp_register_script('d3', $path . 'd3.v5.min.js');
    wp_enqueue_script('d3');

    wp_register_script('custom', $path . 'custom.js');
    wp_enqueue_script('custom');

    // wp_register_script('popper', $path . 'popper.min.js', array('jquery'));
    // wp_enqueue_script('popper');
}
add_action('wp_enqueue_scripts', 'register_scripts');

if(function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

// enable breadcrumbs function (used in single post template)
require_once __DIR__ . '/breadcrumbs.php' ;

// For enabling pagination in category template
ini_set('mysql.trace_mode', 0);

// comment form fields re-defined:
add_filter( 'comment_form_default_fields', 'mo_comment_fields_custom_html' );
function mo_comment_fields_custom_html( $fields ) {
    // first unset the existing fields:
    unset( $fields['comment'] );
    unset( $fields['author'] );
    unset( $fields['email'] );
    unset( $fields['url'] );
    // then re-define them as needed:
    $fields = [
        'author' => '<p class="comment-form-author"><label for="author">' . __( 'Name:', 'textdomain'  ) . ( ' <span class="required">*</span>' ) . '</label> ' .
        '<input id="author" name="author" type="text" size="30" maxlength="245"' . ' /></p>',
        'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email:', 'textdomain'  ) . ( ' <span class="required">*</span>' ) . '</label> ' .
        '<input id="email" name="email" ' . ( 'type="email"' ) . ' size="30" maxlength="100" aria-describedby="email-notes"/></p>',
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment:', 'noun', 'textdomain' ) . '</label> ' .
            '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required" value="<?echo esc_html(comment[\'comment\']); ?>"></textarea></p>',
    ];
    // done customizing, now return the fields:
    return $fields;
}

// remove default comment form so it won't appear twice
add_filter( 'comment_form_defaults', 'mo_remove_default_comment_field', 10, 1 ); 
function mo_remove_default_comment_field( $defaults ) { 
    if (!is_user_logged_in()) {  
        if ( isset( $defaults[ 'comment_field' ] ) ) { $defaults[ 'comment_field' ] = ''; } return $defaults;
    }  
}
