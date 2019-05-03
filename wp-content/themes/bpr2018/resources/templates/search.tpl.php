<?php
/**
 * Search results template
 *
 * @package Innovate New Albany 2014
 * @author Buckeye Interactive
 */

get_header(); ?>

<div class="search-results" id="content">

  <h1 class="post-title"><?php printf( __( 'Search results for "%s"', 'brown-political-review-2019' ), get_search_query() ); ?></h1>

  <div class="primary">
    <?php if ( have_posts() ) : ?>

      <form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <div class="search-wrap">
            <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'presentation' ); ?></label>
            <input type="search" placeholder="<?php echo esc_attr( 'Search…', 'presentation' ); ?>" name="s" id="search-input" value="<?php echo esc_attr( get_search_query() ); ?>" />
            <input class="screen-reader-text" type="submit" id="search-submit" value="Search" />
          </div>
      </form>

      <p class="search-status"><?php
        global $wp_query;

        if ( $wp_query->max_num_pages == 0 ) {
          printf( __( 'Showing %d results.', 'brown-political-review-2019' ), $wp_query->found_posts );
        } else {
          $page = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
          $start = ($page - 1) * get_query_var( 'posts_per_page' ) + 1;
          $end = $start - 1 + $wp_query->post_count;
          if ( $end - $start == 0 ) {
            printf( __( 'Showing result %d of %d.', 'brown-political-review-2019' ), $start, $wp_query->found_posts );
          } else {
            printf( __( 'Showing results %d&ndash;%d of %d.', 'brown-political-review-2019' ), $start, $end, $wp_query->found_posts );
          }
        }
      ?></p>

      <?php while ( have_posts() ) : the_post(); ?>

        <?php $thumbnail = get_the_post_thumbnail_url(); ?>

        <div class="result">
            <p class="date"><?php the_date(); ?></p>
            <div class="info">
                <a href="<?php the_permalink(); ?>"><p class="title"><?php the_title(); ?></p></a>
                <p class="tag spacing"><?php the_category( ' ' ); ?></p>
                <p class="description spacing"><?php the_content(); ?></p>
                <p class="author"><?php the_author(); ?></p> 
            </div>
            <div class="image" style="background-image: url(<?php echo $thumbnail; ?>);background-size: cover;"></div>
        </div>

      <?php endwhile; ?>

      <?php echo ina_post_nav_links(); ?>

    <?php else : ?>

      <p><?php printf( __( 'Our apologies but there\'s nothing that matches your search for "%s"', 'brown-political-review-2019' ), get_search_query() ); ?></p>
      <form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <div class="search-wrap">
          <label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'presentation' ); ?></label>
          <input type="search" placeholder="<?php echo esc_attr( 'Search…', 'presentation' ); ?>" name="s" id="search-input" value="<?php echo esc_attr( get_search_query() ); ?>" />
          <input class="screen-reader-text" type="submit" id="search-submit" value="Search" />
        </div>
      </form>

    <?php endif; ?>
  </div><!-- .primary -->

</div><!-- #content -->

<?php get_footer(); ?>