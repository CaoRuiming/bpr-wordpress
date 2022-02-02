<?php
/**
 * Hero section
 *
 * This is the template for the content of hero section
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */
if ( ! function_exists( 'magpaper_add_hero_section' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_add_hero_section() { 
		$options  = magpaper_get_theme_options();

		if ( ! $options['hero_section_enable'] ) {
			return;
		}
		?>
		<div id="hero-section" class="relative">
		    <div class="wrapper">
		    	<?php
		    	
		    		$page_id = ( ! empty( $options['hero_content_page'] ) ) ? $options['hero_content_page'] : '';
		    		$query = new WP_Query( array( 'posts_per_page' => 1, 'page_id' => $page_id ) );

		    	if ( $query->have_posts() ) {
		    		while ( $query->have_posts() ) { 
		    			$query->the_post();
		    			?>
				        <article>
				            <div class="entry-meta">
				            	<?php magpaper_posted_on(); ?>
				            	<span class="byline"><?php echo esc_html_e( 'by:', 'magpaper' ); ?>
				            	    <span class="author vcard"><a class="url fn n" href="<?php esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a></span>
				            	</span><!-- .byline -->
				            </div><!-- .entry-meta -->

				            <header class="entry-header">
				                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
				            </header>

				            <div class="entry-content">
				                <?php 
				                
				                	the_content();
				                
				                ?>
				            </div><!-- .entry-content -->

				            <?php if ( has_post_thumbnail() ) : ?>
					            <div class="featured-image">
					                <a href="<?php the_permalink();?>"><?php the_post_thumbnail( 'full' ); ?></a>
					            </div><!-- .featured-image -->
				            <?php endif; ?>
				        </article>
		        	<?php
		        	}
				}
				wp_reset_postdata(); ?>
		    </div><!-- .wrapper -->
		</div><!-- #hero-section -->
	<?php
	}
endif;
add_action( 'magpaper_primary_content', 'magpaper_add_hero_section', 10 );