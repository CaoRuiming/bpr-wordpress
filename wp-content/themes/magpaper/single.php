<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

get_header(); 

while ( have_posts() ) : the_post(); ?>
	<div id="page-site-header" class="relative" style="background-image: url('<?php (has_post_thumbnail()) ? the_post_thumbnail_url( 'full' ) : header_image(); ?>');">
        <div class="overlay"></div>
        <div class="wrapper">
            <header class="entry-header">
                <h2 class="page-title"><?php the_title(); ?></h2>
            </header>
            <?php  
	        /**
			 * magpaper_breadcrumb_action hook
			 *
			 * @hooked magpaper_add_breadcrumb -  10
			 *
			 */
			do_action( 'magpaper_breadcrumb_action' );
	        ?>
        </div><!-- .wrapper -->
    </div><!-- #page-header -->
<?php endwhile; ?>

 <div id="inner-content-wrapper" class="wrapper page-section">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="single-wrapper">
				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'single' );

					/**
					* Hook magpaper_action_post_pagination
					*  
					* @hooked magpaper_post_pagination 
					*/
					do_action( 'magpaper_action_post_pagination' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</div><!-- .single-post-wrapper -->
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php  
	if ( magpaper_is_sidebar_enable() ) {
		get_sidebar();
	}
	?>
</div><!-- .page-section -->
<?php
get_footer();
