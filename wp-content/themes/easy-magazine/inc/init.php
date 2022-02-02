<?php
/**
 * Load files.
 *
 * @package Easy Magazine
 */

/**
 * Include default theme options.
 */
require get_template_directory() . '/inc/customizer/default.php';

/**
 * Load hooks.
 */
require get_template_directory() . '/inc/hook/structure.php';
require get_template_directory() . '/inc/hook/custom.php'; 
require get_template_directory() . '/inc/hook/basic.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';