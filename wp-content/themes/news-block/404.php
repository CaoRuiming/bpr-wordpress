<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package News Block
 */

get_header();
?>
	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="blaze-main-content">
					<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php echo esc_html( get_theme_mod( 'error_page_page_title', esc_html__( 'Oops! That page can&rsquo;t be found.', 'news-block' ) ) ); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<?php
							$error_page_image = get_theme_mod( 'error_page_image' );
								if( !empty( $error_page_image ) ) :
									echo '<img src="' .esc_url( get_theme_mod( 'error_page_image' ) ). '" alt="' .esc_html__( '404 page', 'news-block' ). '" title="' .esc_html__( '404 page', 'news-block' ). '"/>';
								else :
							?>
									<p><?php echo esc_html( get_theme_mod( 'error_page_page_content', esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'news-block' ) ) ); ?></p>
							<?php
								endif;

								get_search_form();
							?>
						</div><!-- .page-content -->
					</section><!-- .error-404 -->
				</div>
				<div class="blaze-sidebar-content">
					<?php get_sidebar(); ?>
				</div>
			</div>
	</main><!-- #main -->
<?php
get_footer();