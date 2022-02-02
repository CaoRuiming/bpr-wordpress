<?php
/**
 * Displays the searchform
 *
 * @package Theme Freesia
 * @subpackage Magbook
 * @since Magbook 1.0
 */
?>
<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<?php
		$magbook_settings = magbook_get_theme_options();
		$magbook_search_form = $magbook_settings['magbook_search_text'];?>
		<label class="screen-reader-text"><?php echo esc_html($magbook_search_form);?></label>
		<input type="search" name="s" class="search-field" placeholder="<?php echo esc_attr($magbook_search_form); ?>" autocomplete="off" />
		<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
</form> <!-- end .search-form -->