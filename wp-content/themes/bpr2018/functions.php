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


// Define custom shortcode callback functions
function dropcap_shortcode_function($atts, $content=null) {
    return $content; // nothing special happens for dropcaps for now
}
function pullquote_shortcode_function($atts, $content=null) {
    return '<div class="pullquote">"'.$content.'"</div>';
}


// Register custom shortcodes
function register_shortcodes(){
    add_shortcode('dropcap', 'dropcap_shortcode_function');
    add_shortcode('pullquote', 'pullquote_shortcode_function');
}


// Actually run register_shortcodes
add_action('init', 'register_shortcodes');