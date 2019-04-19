<?php
/**
 * Search results template
 *
 * @package Innovate New Albany 2014
 * @author Buckeye Interactive
 */

get_header(); ?>

<div id="content">

  <h1 class="post-title"><?php printf( __( 'Search results for "%s"', 'brown-political-review-2019' ), get_search_query() ); ?></h1>

  <div class="primary">
    <?php if ( have_posts() ) : ?>

      <?php get_search_form(); ?>

      <p class="search-status"><?php
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

        <?php get_template_part( 'content', get_post_type() ); ?>

      <?php endwhile; ?>

      <?php echo ina_post_nav_links(); ?>

    <?php else : ?>

      <p><?php printf( __( 'Our apologies but there\'s nothing that matches your search for "%s"', 'brown-political-review-2019' ), get_search_query() ); ?></p>
      <?php get_search_form(); ?>

    <?php endif; ?>
  </div><!-- .primary -->

</div><!-- #content -->

<?php get_footer(); ?>