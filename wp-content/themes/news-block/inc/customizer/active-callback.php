<?php
/**
 * Manage active callback functions
 * 
 * @package News Block
 * @since 1.0.0
 */

// preloader option callback
function preloader_option_callback($control) {
    if ( $control->manager->get_setting( 'preloader_option' )->value() !== false ) {
        return true;
    }
    return false;
}

// breadcrumb option callback
function breadcrumb_option_callback($control) {
    if ( $control->manager->get_setting( 'breadcrumb_option' )->value() !== false ) {
        return true;
    }
    return false;
}

// top header date option callback
function top_header_date_option_callback($control) {
    if ( $control->manager->get_setting( 'top_header_date_option' )->value() !== false ) {
        return true;
    }
    return false;
}

// top header social icons option callback
function top_header_social_icons_option_callback($control) {
    if ( $control->manager->get_setting( 'top_header_social_icons_option' )->value() !== false ) {
        return true;
    }
    return false;
}

// post sidebar option callback
function post_sidebar_option_callback($control) {
    if ( $control->manager->get_setting( 'post_sidebar_option' )->value() !== false ) {
        return true;
    }
    return false;
}

// page sidebar option callback
function page_sidebar_option_callback($control) {
    if ( $control->manager->get_setting( 'page_sidebar_option' )->value() !== false ) {
        return true;
    }
    return false;
}

// archive sidebar option callback
function archive_sidebar_option_callback($control) {
    if ( $control->manager->get_setting( 'archive_sidebar_option' )->value() !== false ) {
        return true;
    }
    return false;
}

// top header settings general tab callback
function top_header_settings_tab_general_callback($control) {
    if ( $control->manager->get_setting( 'top_header_settings_tab' )->value() === 'general' ) {
        return true;
    }
    return false;
}

// header settings general tab callback
function header_settings_tab_general_callback($control) {
    if ( $control->manager->get_setting( 'header_settings_tab' )->value() === 'general' ) {
        return true;
    }
    return false;
}

// header settings style tab callback
function header_settings_tab_style_callback($control) {
    if ( $control->manager->get_setting( 'header_settings_tab' )->value() === 'style' ) {
        return true;
    }
    return false;
}

// bottom footer settings general tab callback
function bottom_footer_settings_tab_general_callback($control) {
    if ( $control->manager->get_setting( 'bottom_footer_settings_tab' )->value() === 'general' ) {
        return true;
    }
    return false;
}

// bottom footer settings style tab callback
function bottom_footer_settings_tab_style_callback($control) {
    if ( $control->manager->get_setting( 'bottom_footer_settings_tab' )->value() === 'style' ) {
        return true;
    }
    return false;
}