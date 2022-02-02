<?php
/**
 * Theme inline styles with theme dynamic field values
 * 
 * @package News Block
 * @since 1.0.0
 */
$preloader_background_color = get_theme_mod( 'preloader_background_color', '#fff' ); // preloader whole background image

$top_header_bg_color = get_theme_mod( 'top_header_bg_color', '#ffffff' );
$top_header_text_color = get_theme_mod( 'top_header_text_color', '#2c2c2c' );
$header_bg_color = get_theme_mod( 'header_bg_color', '#ffffff' );
$header_text_color = get_header_textcolor();

// bottom footer settings
$footer_text_color = get_theme_mod( 'footer_text_color', '#ffffff' );
$bottom_footer_bg_color = get_theme_mod( 'bottom_footer_bg_color', '#f7f7f7' );
$bottom_footer_text_color = get_theme_mod( 'bottom_footer_text_color', '#020202' );

// image bg color
$site_image_bg_color = get_theme_mod( 'site_image_bg_color', '#ffc72c' );

echo "#news-block-preloader { background-color: " .esc_attr( $preloader_background_color ). " }";
echo "#primary .bmm-post-thumb a:before, #primary .bmm-post-thumb a:after { background:".esc_attr($site_image_bg_color ).";}";

echo "/*------- Top Header color settings ------------*/\n";
echo "#blaze-top-header .container{ background-color: " . esc_attr($top_header_bg_color) . "; }";
echo "#blaze-top-header { color: " . esc_attr($top_header_text_color) . "; }";
echo "#top-header-menu li a { color: ". esc_attr($top_header_text_color)." }";
echo ".top-header-social-icons i { color: ". esc_attr($top_header_text_color)." }";

echo ".site-branding-section-wrap .container { background-color: ". esc_attr($header_bg_color)." }";
echo ".site-branding-section-wrap .container { color: ". esc_attr($header_text_color)." }";

if( get_header_image() ){
	echo ".site-branding-section-wrap .container{ background-image:url(" .esc_url( get_header_image() ). "); background-color: #575757;}";
}

echo "/*------- Footer color settings ------------*/\n";
echo ".site-footer .widget { color:". esc_attr($footer_text_color) ."; }";
echo ".site-footer .widget h2, .footer-inner .widget_nav_menu li a, .site-footer .widget p, .site-footer .widget a { color: ". esc_attr($footer_text_color). ";}";
echo ".footer-inner .footer-widget h2:after { background-color:". esc_attr($footer_text_color). ";}";
echo "#bottom-footer{ background-color: ".esc_attr($bottom_footer_bg_color).";}";
echo "#bottom-footer a,#bottom-footer .bottom-footer-inner .bottom-footer-menu ul li:after,  #bottom-footer a:after, #bottom-footer i, #bottom-footer .site-info { color: ".esc_attr($bottom_footer_text_color).";}";