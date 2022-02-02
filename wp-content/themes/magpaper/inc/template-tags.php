<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

if ( ! function_exists( 'magpaper_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function magpaper_posted_on( $id = '' ) {
		if ( false === magpaper_archive_meta_option( 'hide_date' ) ) {
			return;
		}

		$id = ! empty( $id ) ? $id : get_the_id();

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U', $id ) !== get_the_modified_time( 'U', $id ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr(get_the_date( DATE_W3C, $id )),
			esc_html(get_the_date( '', $id )),
			esc_attr(get_the_modified_date( DATE_W3C, $id )),
			esc_html(get_the_modified_date( '', $id ))
		);

		$year = get_the_date( 'Y', $id );
		$month = get_the_date( 'm', $id );

		// Wrap the time string in a link, and preface it with 'Posted on'.
		printf(
			/* translators: %s: post date */
			__( '<span class="posted-on"><span class="screen-reader-text">Posted on</span> %s', 'magpaper' ),
			'<a href="' . esc_url( get_month_link( $year, $month ) ) . '" rel="bookmark">' . $time_string . '</a></span>'
		);
	}
endif;

if ( ! function_exists( 'magpaper_single_author' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function magpaper_single_author() {
		$options = magpaper_get_theme_options();

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr(get_the_date( DATE_W3C )),
			esc_html(get_the_date( '' )),
			esc_attr(get_the_modified_date( DATE_W3C )),
			esc_html(get_the_modified_date( '' ))
		);

		$year = get_the_date( 'Y' );
		$month = get_the_date( 'm' );

		$byline = '';

		if ( ! $options['single_post_hide_author'] ) :
			// Get the author name; wrap it in a link.
			$author = sprintf(
				/* translators: %s: post author */
				__( 'By: %s', 'magpaper' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
			);
			$byline .= '<span class="byline"> ' . $author . ' </span>';
		endif;

		if ( ! $options['single_post_hide_date'] ) :
			// Wrap the time string in a link, and preface it with 'Posted on'.
			$byline .= sprintf(
				/* translators: %s: post date */
				__( '<span class="posted-on"><span class="screen-reader-text">Posted on</span> %s', 'magpaper' ),
				'<a href="' . esc_url( get_month_link( $year, $month ) ) . '" rel="bookmark">' . $time_string . '</a></span>'
			);
		endif;

		// Finally, let's write all of this to the page.
		echo $byline;
	}
endif;

if ( ! function_exists( 'magpaper_single_categories' ) ) :
	/**
	 * Prints HTML with meta information for the categories,
	 */
	function magpaper_single_categories() {
		$options = magpaper_get_theme_options();

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			if ( ! $options['single_post_hide_category'] ) :
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'magpaper' ) );
				if ( $categories_list && magpaper_categorized_blog() ) {
					printf( '<span class="cat-links"><span class="tags-title">' . esc_html__( 'Categories: %1$s ', 'magpaper' ) . '</span></span>', $categories_list ); // WPCS: XSS OK.
				}
			endif;
		}

	}
endif;

if ( ! function_exists( 'magpaper_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the tags and comments.
	 */
	function magpaper_entry_footer() {
		$options = magpaper_get_theme_options();

		magpaper_single_categories();
		
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			if ( ! $options['single_post_hide_tags'] ) :
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html__( ', ', 'magpaper' ) );
				if ( $tags_list ) {
					printf( '<span class="tags-links"><span class="tags-title">' . esc_html__( 'Tags: %1$s %2$s ', 'magpaper' ) . '</span>', '</span>', $tags_list ); // WPCS: XSS OK.
				}
			endif;
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( ' Edit %s', 'magpaper' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * articles meta
 *  @param [id] $id post id
 *  @param [html] $authro author template
 */
function magpaper_article_categories_meta( $id = '' ) { 
	$id = ! empty( $id ) ? $id : get_the_id();

	if ( 'post' !== get_post_type( $id ) ) { 
		return;
	}

	$output = '';
	
	if ( true === magpaper_archive_meta_option( 'hide_category' ) ) {
	    $categories_list = get_the_category_list(  ', ', 'magpaper', '', $id );
		if ( $categories_list && magpaper_categorized_blog() ) {
			$output .= $categories_list;
		}
	}

    echo $output;
}

if ( ! function_exists( 'magpaper_author' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function magpaper_author($id) {
		if ( false === magpaper_archive_meta_option( 'hide_author' ) ) {
			return;
		}

		// Get the author name; wrap it in a link.
		$byline = sprintf(
			/* translators: %s: post author */
			__( 'by %s', 'magpaper' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $id ) ) . '">' . get_the_author() . '</a></span>'
		);

		// Finally, let's write all of this to the page.
		return '<span class="byline"> ' . $byline . '</span>';
	}
endif;

/**
 * Checks to see if meta option is hide enabled in archive/blog
 */
function magpaper_archive_meta_option( $option = '' ) {
	$options = magpaper_get_theme_options();
	if ( is_archive() || is_search() || is_home() ) :
		if ( true === $options[$option] )
			return false;
		else
			return true;
	else :
		return true;
	endif;
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function magpaper_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'magpaper_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'magpaper_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so magpaper_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so magpaper_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in magpaper_categorized_blog.
 */
function magpaper_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'magpaper_categories' );
}
add_action( 'edit_category', 'magpaper_category_transient_flusher' );
add_action( 'save_post',     'magpaper_category_transient_flusher' );
