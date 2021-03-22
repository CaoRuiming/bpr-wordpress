<?php get_header(); ?>

<?php
// Get category
if (is_single()) {
  $categories =  get_the_category();
  $category = $categories[0];
} else {
  $category = get_category(get_query_var('cat'));
}
?>

<div id="category-page" class="container-fluid">
  <?php if ($category->parent > 0): ?>
    <?php
    $parent = get_category($category->parent);
    $parent_link = get_category_link($parent);
    ?>
    <div class="parent-category-title post-categories">
      <a href="<?php echo esc_url($parent_link); ?>"><?php echo $parent->name; ?></a>
    </div>
  <?php endif; ?>

  <h1 class="category-title font-size-100 header-font">
    <?php echo $category->name; ?>
  </h1>

  <section>
    <div class="horizontal-rule"></div>
    <h2 class="section-title header-font">Popular Articles</h2>
  
    <div id="popular-articles" class="container-fluid">
      <div class="carousel-wrapper row">
        <div class="carousel">
          <?php
          $recent  = new WP_Query(array(
            'category_name' => $category->slug,
            'posts_per_page' => 3,
          ));
  
          while ($recent->have_posts()): ?>
            <?php
            $post = $recent->the_post();
            $pic_url = get_the_post_thumbnail_url();
            $pic_id = get_post_thumbnail_id();
            $pic_alt = get_post_meta($pic_id, '_wp_attachment_image_alt', true);
            $pic_title = get_the_title($pic_id);
            ?>
            <div class="container-fluid">
              <div class="row">
                <article class="row featured-post">
                  <div class="col-sm-6">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                      <div
                        class="img-40"
                        style="background-image: url(<?php echo $pic_url; ?>);">
                        <span role="img" aria-label="<?php echo $pic_alt; ?>"> </span>
                      </div>
                    </a>
                  </div>
      
                  <div class="col-sm-6">
                    <div class="d-none"><?php the_category(); ?></div>
      
                    <h1 class="post-title-large">
                      <a href="<?php echo esc_url(get_permalink()); ?>">
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
                      <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php the_author(); ?>
                      </a>
                      <?php
                      if (get_the_date()) { echo ' | <time>' . get_the_date() . '</time>'; }
                      ?>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
        <div
          class="carousel-arrow carousel-prev"
          style="background-image: url(<?php echo get_image_asset('carousel-left.png'); ?>);"
          aria-controls="carousel"
          aria-label="previous-slide">
        </div>
        <div
          class="carousel-arrow carousel-next"
          style="background-image: url(<?php echo get_image_asset('carousel-right.png'); ?>);"
          aria-controls="carousel"
          aria-label="next-slide">
        </div>
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
  </section>

  <section>
    <div class="horizontal-rule"></div>
    <h2 class="section-title header-font">Latest</h2>
  
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
  
    while ($query->have_posts()) {
      $query->the_post();
      do_action('theme/single/row');
    }

    wp_reset_postdata();
    ?>
  </section>
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

  <script>
    // hide first faint horizontal rule in search results list
    document.body
      .querySelector('.horizontal-rule.faint')
      .setAttribute('style', 'display: none;');
  </script>
</div>

<?php get_footer(); ?>
