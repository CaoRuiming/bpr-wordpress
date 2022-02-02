<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package News Block
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<div class="row">
				<div class="blaze-main-content blaze-mag-modules-post-list-block bmm-block bmm-block-post-list--layout-one bmm-block-image-hover--none overflow--show">
					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title">
								<?php
									/* translators: %s: search query. */
									printf( esc_html__( '%1$s %2$1s', 'news-block' ), get_theme_mod( 'search_page_title', esc_html__( 'Search Results for:', 'news-block' ) ), '<span>' . get_search_query() . '</span>' );
								?>
							</h1>
						</header><!-- .page-header -->

						<div class="bmm-post-wrapper">
							<?php
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									/**
									 * Run the loop for the search to output the results.
									 * If you want to overload this in a child theme then include a file
									 * called content-search.php and that will be used instead.
									 */
									get_template_part( 'template-parts/content', 'list' );

									/**
									 * hook - news_block_archive_single_post_after_hook
									 * 
									 * @hooked - news_block_archive_read_more_button
									 */
									if( has_action( 'news_block_archive_single_post_after_hook' ) ) {
										do_action( 'news_block_archive_single_post_after_hook' );
									}
								endwhile;

								/**
							 * hook - news_block_pagination_link_hook
							 * 
							 * @hooked - news_block_pagination_fnc
							 */
							do_action( 'news_block_pagination_link_hook' );
							?>
						</div>
						<?php

							else :
							?>
								<div class="bmm-post-wrapper">
									<?php
									get_template_part( 'template-parts/content', 'none' );
								?>
								</div>
							<?php

								endif;

							?>
					</div>
					<div class="blaze-sidebar-content">
						<?php get_sidebar(); ?>
					</div>
				</div><!-- row -->
		</div> <!-- container -->
	</main><!-- #main -->

<?php
get_footer();