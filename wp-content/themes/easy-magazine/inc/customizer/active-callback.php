<?php
/**
 * Active callback functions.
 *
 * @package Easy Magazine
 */

function easy_magazine_breaking_news_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_breaking_news_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_magazine_breaking_news_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[breaking_news_content_type]' )->value();
    return ( easy_magazine_breaking_news_active( $control ) && ( 'breaking_news_page' == $content_type ) );
}

function easy_magazine_breaking_news_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[breaking_news_content_type]' )->value();
    return ( easy_magazine_breaking_news_active( $control ) && ( 'breaking_news_post' == $content_type ) );
}

function easy_magazine_highlighted_posts_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_highlighted_posts_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_magazine_highlighted_posts_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[highlighted_posts_content_type]' )->value();
    return ( easy_magazine_highlighted_posts_active( $control ) && ( 'highlighted_posts_page' == $content_type ) );
}

function easy_magazine_highlighted_posts_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[highlighted_posts_content_type]' )->value();
    return ( easy_magazine_highlighted_posts_active( $control ) && ( 'highlighted_posts_post' == $content_type ) );
}

function easy_magazine_featured_posts_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_posts_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_magazine_featured_posts_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_posts_content_type]' )->value();
    return ( easy_magazine_featured_posts_active( $control ) && ( 'featured_posts_page' == $content_type ) );
}

function easy_magazine_featured_posts_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_posts_content_type]' )->value();
    return ( easy_magazine_featured_posts_active( $control ) && ( 'featured_posts_post' == $content_type ) );
}

function easy_magazine_recent_posts_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_recent_posts_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_magazine_recent_posts_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[recent_posts_content_type]' )->value();
    return ( easy_magazine_recent_posts_active( $control ) && ( 'recent_posts_page' == $content_type ) );
}

function easy_magazine_recent_posts_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[recent_posts_content_type]' )->value();
    return ( easy_magazine_recent_posts_active( $control ) && ( 'recent_posts_post' == $content_type ) );
}

function easy_magazine_popular_posts_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_popular_posts_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_magazine_popular_posts_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[popular_posts_content_type]' )->value();
    return ( easy_magazine_popular_posts_active( $control ) && ( 'popular_posts_page' == $content_type ) );
}

function easy_magazine_popular_posts_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[popular_posts_content_type]' )->value();
    return ( easy_magazine_popular_posts_active( $control ) && ( 'popular_posts_post' == $content_type ) );
}

function easy_magazine_trending_posts_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_trending_posts_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function easy_magazine_trending_posts_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[trending_posts_content_type]' )->value();
    return ( easy_magazine_trending_posts_active( $control ) && ( 'trending_posts_page' == $content_type ) );
}

function easy_magazine_trending_posts_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[trending_posts_content_type]' )->value();
    return ( easy_magazine_trending_posts_active( $control ) && ( 'trending_posts_post' == $content_type ) );
}

function easy_magazine_blog_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_blog_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

/**
 * Active Callback for top bar section
 */
function easy_magazine_contact_info_ac( $control ) {

    $show_contact_info = $control->manager->get_setting( 'theme_options[show_header_contact_info]')->value();
    $control_id        = $control->id;
         
    if ( $control_id == 'theme_options[header_location]' && $show_contact_info ) return true;
    if ( $control_id == 'theme_options[header_email]' && $show_contact_info ) return true;
    if ( $control_id == 'theme_options[header_phone]' && $show_contact_info ) return true;

    return false;
}

function easy_magazine_social_links_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[show_header_social_links]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}