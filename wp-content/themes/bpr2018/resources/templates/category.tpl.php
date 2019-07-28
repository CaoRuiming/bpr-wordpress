<?php get_header(); ?>

<?php
// Get category
if (is_single()) {
  $categories =  get_the_category();
  $category = $cats[0];
} else {
  $category = get_category( get_query_var( 'cat' ) );
}
?>

<div id="category-page" class="container-fluid">
  <div class="container-fluid">
    <?php if ($category->parent > 0): ?>
      <?php
      $parent = get_category($category->parent);
      $parent_link = get_category_link($parent);
      ?>
      <div class="parent-category-title post-categories">
        <a href="<?php echo $parent_link; ?>"><?php echo $parent->name; ?></a>
      </div>
    <?php endif; ?>

    <div class="category-title font-size-100"><?php echo $category->name; ?></div>
    <div class="horizontal-rule"></div>
    <div class="section-title">Popular Articles</div>
  </div>

  <div id="popular-articles" class="row">
    <div class="carousel-wrapper">
      <div class="carousel container-fluid">
        <?php
        $recent  = new WP_Query(array(
          'category_name' => $category->slug,
          'posts_per_page' => 3,
        ));

        while ($recent->have_posts()): ?>
          <?php
          $post = $recent->the_post();
          $pic_url = get_the_post_thumbnail_url();
          ?>
          <div class="row featured-post">
            <div class="col-md-6">
              <a href="<?php echo get_permalink(); ?>">
                <div
                  class="img-40"
                  style="background-image: url(<?php echo $pic_url; ?>);">
                </div>
              </a>
            </div>

            <div class="col-md-6">
              <?php the_category(); ?>

              <h1 class="post-title-large">
                <a href="<?php echo get_permalink(); ?>">
                  <?php the_title(); ?>
                </a>
              </h1>

              <p class="font-size-24">
                <?php
                $content = apply_filters('the_content', get_the_content());
                echo substr(sanitize_text_field($content), 0, 250) . '...';
                ?>
              </p>

              <div class="post-author post-date font-size-20">
                <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="carousel-arrow carousel-prev">&#11139;</div>
      <div class="carousel-arrow carousel-next">&#11137;</div>
    </div>
    <script>
      $('.carousel').slick({
        infinite: true,
        autoplay: true,
        autoplaySpeed: 10000,
        arrows: true,
        prevArrow: $('.carousel-prev'),
        nextArrow: $('.carousel-next')
      });
    </script>
  </div>

  <div class="container-fluid">
    <div class="horizontal-rule"></div>
    <div class="section-title">Latest</div>
    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $query  = new WP_Query(array(
      'category_name' => $category->slug,
      'paged' => $paged,
      'posts_per_page' => get_option('posts_per_page'),
      'orderby' => 'date',
      'order' => 'desc',
      'post_type' => 'post',
      'post_status' => 'publish',
    ));

    while ($query->have_posts()): ?>
      <?php
      $post = $query->the_post();
      $pic_url = get_the_post_thumbnail_url();
      ?>
      <div class="horizontal-rule faint"></div>
      <div class="row latest-post">
        <div class="col-sm-2 post-date font-size-18">
          <?php if (get_the_date()) { echo get_the_date(); } ?>
        </div>

        <div class="col-sm-8">
          <div class="post-title-small">
            <a href="<?php echo get_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </div>

          <p class="font-size-20">
            <?php
            $content = apply_filters('the_content', get_the_content());
            echo substr(sanitize_text_field($content), 0, 250) . '...';
            ?>
          </p>

          <div class="post-author font-size-18"><?php the_author(); ?></div>
        </div>

        <div class="col-sm-2">
          <a href="<?php echo get_permalink(); ?>">
            <div
              class="img-10"
              style="background-image: url(<?php echo $pic_url; ?>);">
            </div>
          </a>
        </div>
      </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
    <?php if ($paged === 1): ?>
      <div class="more-link text-center">
        <?php next_posts_link('Show Older', $query->max_num_pages); ?>
      </div>
    <?php elseif (!get_next_posts_link()): ?>
      <div class="more-link text-center">
        <?php previous_posts_link('Show Newer', $query->max_num_pages); ?>
      </div>
    <?php else: ?>
      <div class="row">
        <div class="more-link col-xs-6 text-left">
          <?php previous_posts_link('Show Newer', $query->max_num_pages); ?>
        </div>
        <div class="more-link col-xs-6 text-right">
          <?php next_posts_link('Show Older', $query->max_num_pages); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
