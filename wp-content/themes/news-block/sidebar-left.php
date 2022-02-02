<?php
/**
 * Left sidebar column for the blog and pages. 
 *
 * @package article
 */


if (   ! is_active_sidebar( 'pageleft'  )
	&& ! is_active_sidebar( 'blogleft' ) 
	)
	return;

if ( is_page() ) {
	
	echo '<div id="col-md-4">
		<aside id="page-sidebar-left" class="widget-area" itemscope="" itemtype="http://schema.org/WPSideBar">';    
		dynamic_sidebar( 'pageleft' );
	echo '</aside></div>';
	
} else {
	
	echo '<div class="col-md-4"><div id="blog-sidebar-left"><aside id="sidebar-left" class="widget-area" itemscope="" itemtype="http://schema.org/WPSideBar">';   
		dynamic_sidebar( 'blogleft' );
	echo '</aside></div></div>';
	
}