<?php get_header(); ?>

<?php
// Get category
if ( is_single() ) {
  $categories =  get_the_category();
  $category = $cats[0];
} else {
  $category = get_category( get_query_var( 'cat' ) );
}
?>

<div id="category-page" class="container-fluid">
  <div class="container-fluid">
    <div class="category-title"><?php echo $category->name; ?></div>
    <div class="horizontal-rule"></div>
    <div class="section-title">Popular Articles</div>
  </div>

  <div id="popular-articles" class="row">
    <div class="carousel-wrapper container-fluid">
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

              <h1 class="post-title">
                  <a href="<?php echo get_permalink(); ?>">
                      <?php the_title(); ?>
                  </a>
              </h1>

              <p>
                <?php
                $content = apply_filters('the_content', get_the_content());
                echo substr(sanitize_text_field($content), 0, 250) . '...';
                ?>
              </p>

              <div class="post-author-date">
                  <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
              </div>
            </div>
          </div>
      <?php endwhile; ?>
    </div>
    <script>
      $('.carousel-wrapper').slick({
        infinite: true,
        autoplay: true,
        autoplaySpeed: 7000
      });
    </script>
  </div>

  <div class="container-fluid">
    <div class="horizontal-rule"></div>
    <div class="section-title">Latest</div>
    <?php
    $latest  = new WP_Query(array(
        'category_name' => $category->slug,
        'posts_per_page' => 5,
    ));

    while ($latest->have_posts()): ?>
        <?php
        $post = $latest->the_post();
        $pic_url = get_the_post_thumbnail_url();
        ?>
        <div class="horizontal-rule faint"></div>
        <div class="row latest-post">
          <div class="col-md-2 post-date">
            <?php if (get_the_date()) { echo get_the_date(); } ?>
          </div>

          <div class="col-md-8">
            <h1 class="post-title">
                <a href="<?php echo get_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h1>

            <p>
              <?php
              $content = apply_filters('the_content', get_the_content());
              echo substr(sanitize_text_field($content), 0, 250) . '...';
              ?>
            </p>

            <div class="post-author"><?php the_author(); ?></div>
          </div>

          <div class="col-md-2">
            <a href="<?php echo get_permalink(); ?>">
                <div
                    class="img-10"
                    style="background-image: url(<?php echo $pic_url; ?>);">
                </div>
            </a>
          </div>
        </div>
    <?php endwhile; ?>
    <div class="read-more">SHOW MORE</div>
  </div>
</div>

<?php get_footer(); ?>
