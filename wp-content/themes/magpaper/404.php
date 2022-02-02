<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

get_header(); ?>
<div id="page-site-header" class="relative" style="background-image: url('');">
    <div class="overlay"></div>
    <div class="wrapper">
        <header class="entry-header">
            <h2 class="page-title"><?php esc_html_e( 'Oops! That page can\'t be found.', 'magpaper' ); ?></h2>
        </header>
        <section class="error-404 not-found">
        	<header class="page-header">
        		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/uploads/404.png' ); ?>" alt="<?php esc_attr_e( '404', 'magpaper' ); ?>">
        	</header><!-- .page-header -->

        	<div class="page-content">
        		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'magpaper' ); ?></p>
        		<div class="widget">
        			<?php get_search_form(); ?>
        		</div>
        	</div><!-- .page-content -->
        </section><!-- .error-404 -->
    </div><!-- .wrapper -->
</div><!-- #page-header -->
<?php
get_footer();
