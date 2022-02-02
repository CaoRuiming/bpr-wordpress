<?php
/**
 * Default theme options.
 *
 * @package Newsclick
 */

if (!function_exists('newsclick_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function newsclick_get_default_theme_options() {

    $defaults = array();

    $defaults['select_editor_news_category'] = 0;

    $defaults['select_newsclick_latest_news_category'] = 0;

	return $defaults;

}
endif;