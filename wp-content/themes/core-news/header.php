<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); 
$search_icon = get_theme_mod('core_blog_header_search_icon_display',true);
$menu_sidebar = get_theme_mod('core_blog_header_menu_sidebar_display',true);
?>
<div id="page" class="site is-preload">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'core-news' ); ?></a>
	
		<!-- Header -->
		<header id="core-news-header" class="<?php if(is_user_logged_in() && is_customize_preview()) { ?> core-blog-customizer <?php } if(is_user_logged_in()) { ?>core-blog-header<?php }  ?>"> 
			<div class="container">
				<div class="row title_name">
					<div class="col-md-4 core-search">
						<nav class="main-search">
							
								<?php if($search_icon){ ?>
									
										<a class="fa-search search_f" href="javascript:void(0)"><?php esc_html_e('Search','core-news');?></a>
										<span class="core-blog-search">
										<?php get_search_form();?>
										</span>
									<?php }
								?> 
						
						</nav>
					
					</div>
					<div class="col-md-4 core-title">
						<div class="title_desc">
						<?php
								the_custom_logo();
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								endif;
								$core_blog_description = get_bloginfo( 'description', 'display' );
								if ( $core_blog_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo esc_html($core_blog_description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>
						</div>
						
					</div>
					<div class="col-md-4 core-menu">
						<?php if($search_icon!='' || $menu_sidebar!=''){?>
						<nav class="main">
						
								<?php
									if($menu_sidebar){
								?>
								
									<a class="fa-bars focus_search" href="#" data-target="#myModal2"  data-toggle="modal"><?php esc_html_e('Menu','core-news');?></a>
								
								<?php }?>
							</ul>
						</nav>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 core-toggle">
						<nav id="site-navigation" class="core-blog-main-navigation">
							<button class="toggle-button" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
							<div class="toggle-text"></div>
								<span class="toggle-bar"></span>
								<span class="toggle-bar"></span>
								<span class="toggle-bar"></span>
							</button>
							<div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
							<button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
								<div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'core-news' ); ?>">
									<?php
										wp_nav_menu( array(
										'theme_location' => 'menu-1',
										'menu_id'        => 'primary-menu',
										'menu_class'     => 'nav-menu main-menu-modal',
										
										) );
									?>
								</div>
							</div>
						</nav><!-- #site-navigation -->
					</div>
				</div>
			</div>
		</header>
		<!-- Modal -->
		<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-header">
						<a href="#" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
					</div>

					<div class="modal-body">
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
					</div>

				</div><!-- modal-content -->
			</div><!-- modal-dialog -->
		</div><!-- modal -->