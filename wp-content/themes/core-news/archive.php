<?php
get_header();
?>
	<div class="container core_blog_container"  id="main">
		<?php
            $sidebar_position = get_theme_mod('core_blog_sidebar_position', esc_html__( 'right', 'core-news' ));
            if ($sidebar_position == 'left') {
                $sidebar_position = 'has-left-sidebar';
            } elseif ($sidebar_position == 'right') {
                $sidebar_position = 'has-right-sidebar';
            } elseif ($sidebar_position == 'no') {
                $sidebar_position = 'no-sidebar';
            }
          ?>
		<div class="row <?php echo esc_attr($sidebar_position); ?>">
			<?php if(is_active_sidebar( 'sidebar-1' )) { ?>
			<div class="col-lg-8 col-md-8 col-sm-12 blog-post">
				<?php
				}
				else{
					?>
					<div class="col-lg-12 col-md-12 col-sm-12 blog-single-post">
					<?php
				}
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
				<div class="pagination">
		            <ul class="nav-links">
		               <?php echo paginate_links(); ?>
		            </ul> 
	        	</div>
			</div>
			 <?php if (($sidebar_position == 'has-left-sidebar') || ($sidebar_position == 'has-right-sidebar')) { ?>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <?php get_sidebar();?>
            </div>
             <?php } ?>
		</div>
	</div>
	<?php
get_footer();