<?php
function core_news_enqueue_scripts(){

    wp_enqueue_style( 'core-blog-parent-style', get_template_directory_uri() . '/style.css');  
    wp_enqueue_script( 'core-news-main', get_stylesheet_directory_uri() . '/assets/js/core-news-main.js',array('jquery'),true);
    wp_enqueue_style('core-news-style',get_stylesheet_uri());
     wp_enqueue_style('fontawesome-css-all', get_stylesheet_directory_uri() . '/assets/css/fontawesome-all.css');
    wp_enqueue_style('core-news-font-Hind', 'https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500&display=swap');
    wp_enqueue_style('core-news-font-Montserrat', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap');
}
add_action('wp_enqueue_scripts','core_news_enqueue_scripts');