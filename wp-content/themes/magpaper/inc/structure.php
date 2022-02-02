<?php
/**
 * Theme Palace basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

$options = magpaper_get_theme_options();


if ( ! function_exists( 'magpaper_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since Magpaper 1.0.0
	 */
	function magpaper_doctype() {
	?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
	<?php
	}
endif;

add_action( 'magpaper_doctype', 'magpaper_doctype', 10 );


if ( ! function_exists( 'magpaper_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif;
	}
endif;
add_action( 'magpaper_before_wp_head', 'magpaper_head', 10 );

if ( ! function_exists( 'magpaper_page_start' ) ) :
	/**
	 * Page starts html codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_page_start() {
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'magpaper' ); ?></a>

		<?php
	}
endif;
add_action( 'magpaper_page_start_action', 'magpaper_page_start', 10 );

if ( ! function_exists( 'magpaper_page_end' ) ) :
	/**
	 * Page end html codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'magpaper_page_end_action', 'magpaper_page_end', 10 );

if ( ! function_exists( 'magpaper_header_start' ) ) :
	/**
	 * Header start html codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_header_start() {
		$options = magpaper_get_theme_options();
		?>
		<header id="masthead" class="site-header" role="banner">
		<?php
	}
endif;
add_action( 'magpaper_header_action', 'magpaper_header_start', 10 );

if ( ! function_exists( 'magpaper_left_side_post' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_left_side_post() { ?>
		<div class="wrapper">

		<?php
		$options  = magpaper_get_theme_options();

		if ( ! $options['header_section_enable'] ) {
			return;
		}
		
			$page_id = ( ! empty( $options['header_content_page'] ) ) ? $options['header_content_page'] : '';
			$query = new WP_Query( array( 'posts_per_page' => 1,  'page_id' => $page_id ) );
		

		if ( $query->have_posts() ) { ?>
			<div id="left-side-post">
				<?php while ( $query->have_posts() ) { 
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
			                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>  
			                </header>
			            </article>
				<?php } ?>
			</div><!-- #left-side-post -->
		<?php } 
		wp_reset_postdata();

	}
endif;
add_action( 'magpaper_header_action', 'magpaper_left_side_post', 15 );

if ( ! function_exists( 'magpaper_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_site_branding() {
		$options  = magpaper_get_theme_options();
		$header_txt_logo_extra = $options['header_txt_logo_extra'];		
		?>
		<div class="site-branding">
			<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-tagline' ) )  ) { ?>
				<div class="site-logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php } 
			if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title', 'show-all', 'tagline-only', 'logo-tagline' ) ) ) : ?>
				<div id="site-identity">
					<?php
					if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'logo-title' ) )  ) { ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php } 
					
					if ( in_array( $header_txt_logo_extra, array( 'show-all', 'tagline-only', 'logo-tagline' ) ) ) {
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
						<?php
						endif; 
					}?>
				</div>
			<?php endif; ?>
		</div><!-- .site-branding -->
		<?php
	}
endif;
add_action( 'magpaper_header_action', 'magpaper_site_branding', 20 );

if ( ! function_exists( 'magpaper_right_side_post' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_right_side_post() {
			$options  = magpaper_get_theme_options();
			if ( $options['header_right_section_enable'] ) {
				
					$page_id = ( ! empty( $options['header_right_content_page'] ) ) ? $options['header_right_content_page'] : '';
					$query = new WP_Query( array( 'posts_per_page' => 1, 'page_id' => $page_id ) );
				
				if ( $query->have_posts() ) { ?>
					<div id="right-side-post">
					<?php while ( $query->have_posts() ) { 
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
				                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>  
				                </header>
				            </article>
					<?php } ?>
					</div><!-- #left-side-post -->
				<?php }

				wp_reset_postdata();?>

			<?php } ?>
		<?php
	}
endif;
add_action( 'magpaper_header_action', 'magpaper_right_side_post', 25 );

if ( ! function_exists( 'magpaper_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_site_navigation() { ?>
		</div><!-- .wrapper -->
		<?php
		$options = magpaper_get_theme_options();
		if ( has_nav_menu( 'primary' ) ) :
			?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
                <div class="wrapper">
                	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                	    <span class="menu-label">Menu</span>
                	    <?php echo magpaper_get_svg( array( 'icon' => 'menu' ) ); 
							echo magpaper_get_svg( array( 'icon' => 'close' ) ); 
                	    ?>
                	</button>
					<?php  
		        	
		        		wp_nav_menu( array(
		        			'theme_location' => 'primary',
		        			'container' => false,
		        			'menu_class' => 'menu nav-menu',
		        			'menu_id' => 'primary-menu',
		        			'echo' => true,
		        			'fallback_cb' => 'magpaper_menu_fallback_cb',
		        		) );
		        	?>
	        	</div>
			</nav><!-- #site-navigation -->
	    <?php endif; ?>
		<?php
	}
endif;
add_action( 'magpaper_header_action', 'magpaper_site_navigation', 30 );


if ( ! function_exists( 'magpaper_header_end' ) ) :
	/**
	 * Header end html codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_header_end() {
		?>
		</header><!-- #masthead -->
		<?php
	}
endif;
add_action( 'magpaper_header_action', 'magpaper_header_end', 40 );

if ( ! function_exists( 'magpaper_social_menu' ) ) :
	/**
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_social_menu() { 
		if ( ! has_nav_menu( 'social' ) ) {
			return;
		}

		wp_nav_menu( array(
			'theme_location' => 'social',
			'container' => 'div',
			'container' => 'social-menu',
			'menu_class' => 'menu',
			'echo' => true,
			'fallback_cb' => false,
			'depth' => 1,
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>' . magpaper_get_svg( array( 'icon' => 'chain' ) ),
		) );
	}
endif;

if ( ! function_exists( 'magpaper_content_start' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_content_start() {
		?>
		<div id="content" class="site-content">
		<?php
	}
endif;
add_action( 'magpaper_header_action', 'magpaper_content_start', 50 );

if ( ! function_exists( 'magpaper_add_breadcrumb' ) ) :
	/**
	 * Add breadcrumb.
	 *
	 * @since Magpaper 1.0.0
	 */
	function magpaper_add_breadcrumb() {
		$options = magpaper_get_theme_options();
		// Bail if Breadcrumb disabled.
		$breadcrumb = $options['breadcrumb_enable'];
		if ( false === $breadcrumb ) {
			return;
		}
		
		// Bail if Home Page.
		if ( magpaper_is_frontpage() ) {
			return;
		}

		echo '<div id="breadcrumb-list" >';
				/**
				 * magpaper_simple_breadcrumb hook
				 *
				 * @hooked magpaper_simple_breadcrumb -  10
				 *
				 */
				do_action( 'magpaper_simple_breadcrumb' );
		echo '</div><!-- #breadcrumb-list -->';
		return;
	}
endif;
add_action( 'magpaper_breadcrumb_action', 'magpaper_add_breadcrumb', 20 );

if ( ! function_exists( 'magpaper_content_end' ) ) :
	/**
	 * Site content codes
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_content_end() {
		?>
			<div class="menu-overlay"></div>
		</div><!-- #content -->
		<?php
	}
endif;
add_action( 'magpaper_content_end_action', 'magpaper_content_end', 10 );

if ( ! function_exists( 'magpaper_footer_start' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_footer_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
	}
endif;
add_action( 'magpaper_footer', 'magpaper_footer_start', 10 );

if ( ! function_exists( 'magpaper_footer_site_info' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_footer_site_info() {
		$theme_data = wp_get_theme();
		$options = magpaper_get_theme_options();
		$search = array( '[the-year]', '[site-link]' );

        $replace = array( date( 'Y' ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );

        $options['copyright_text'] = str_replace( $search, $replace, $options['copyright_text'] );

		$copyright_text = $options['copyright_text']; 
		$powered_by_text = esc_html__( 'All Rights Reserved | ', 'magpaper' ) . esc_html( $theme_data->get( 'Name') ) . '&nbsp;' . esc_html__( 'by', 'magpaper' ). '&nbsp;<a target="_blank" href="'. esc_url( $theme_data->get( 'AuthorURI' ) ) .'">'. esc_html( ucwords( $theme_data->get( 'Author' ) ) ) .'</a>';

		?>
		<div class="site-info col-2">
                <div class="wrapper">
                	<div class="footer-copyright">
	                    <span><?php echo magpaper_santize_allow_tag( $copyright_text ); ?></span>
	                    <span>
	                    	<?php 
	                    	echo magpaper_santize_allow_tag( $powered_by_text ); 
	                    	if ( function_exists( 'the_privacy_policy_link' ) ) {
							    the_privacy_policy_link( ' | ' );
							} 
	                    	?>
	                    </span>
                    </div>
                </div><!-- .wrapper -->    
            </div><!-- .site-info -->

		<?php
	}
endif;
add_action( 'magpaper_footer', 'magpaper_footer_site_info', 40 );

if ( ! function_exists( 'magpaper_footer_scroll_to_top' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_footer_scroll_to_top() {
		$options  = magpaper_get_theme_options();
		if ( true === $options['scroll_top_visible'] ) : ?>
			<div class="backtotop"><?php echo magpaper_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php endif;
	}
endif;
add_action( 'magpaper_footer', 'magpaper_footer_scroll_to_top', 40 );

if ( ! function_exists( 'magpaper_footer_end' ) ) :
	/**
	 * Footer starts
	 *
	 * @since Magpaper 1.0.0
	 *
	 */
	function magpaper_footer_end() {
		?>
		</footer>
		<div class="popup-overlay"></div>
		<?php
	}
endif;
add_action( 'magpaper_footer', 'magpaper_footer_end', 100 );