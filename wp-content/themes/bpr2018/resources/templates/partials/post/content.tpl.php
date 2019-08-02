<article>
  <div class="row">
    <div class="col-lg-2"></div> <!-- Padding -->
    <div class="content col-lg-8">
      <a id="article-top" name="article-top"></a> <!-- For back to top -->
      <h1><?php the_title(); ?></h1>

      <div class="post-author post-date font-size-24">
        <a href="<?php get_author_posts_url(get_the_author_meta('ID')); ?>">
          <?php the_author(); ?>
        </a><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
      </div>

      <?php 
      $pic_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
      if ($pic_url):
      ?>
        <div
          class="featured-image"
          style="background-image: url(<?php echo $pic_url; ?>);">
        </div>
      <?php endif; ?>

      <div class="hline"></div>
    </div>

    <div class="col-lg-1"></div> <!-- Padding -->
  </div>

  <div class="row">
    <div class="col-lg-2"></div>

    <div class="content col-lg-8">
      <?php the_content(); ?>

      <div class="back-to-top text-center">
        <a href="#article-top" class="uppercase font-size-18">Back to Top</a>
      </div>

      <div class="article-bottom-wrapper container-fluid">
        <div class="article-bottom row">
          <div class="tags-and-author col-sm-9">
            <div class="post-tags">
              <?php
              the_tags(
                '<div class="post-tag uppercase font-size-16">',
                '</div><div class="post-tag uppercase font-size-16">',
                '</div>'
              );
              ?>
            </div>

            <?php if (get_the_author_meta('user_description')): ?>
              <div class="about-author">
                <p class="about-author-title uppercase">About the Author</p>
                <p class="about-author-bio">
                  <?php echo get_the_author_meta('user_description'); ?>
                </p>
              </div>
            <?php endif; ?>
          </div>

          <div class="social-and-sharing col-sm-3"></div>
        </div>
        <div class="row">
          <p class="suggested-articles-title">SUGGESTED ARTICLES</p>
        </div>
      </div>
    </div>

    <div class="col-lg-2"><?php the_category(); ?></div>
  </div>
  <div class="row suggested-articles">
    <?php 
    $suggested  = new WP_Query(array(
      'posts_per_page' => 3,
      'meta_key' => 'post_views_count',
      'orderby' => 'meta_value_num',
      'order' => 'DESC'
    ));
    $suggested_count = 0;
    while ($suggested->have_posts() && $suggested_count < 3): ?>
      <?php
      $suggested_count += 1;
      $post = $suggested->the_post();
      $pic_url = get_the_post_thumbnail_url();
      ?>
      <div class="col-md-4 suggested-article">
        <a href="<?php echo get_permalink(); ?>">
          <div
            class="img-30"
            style="background-image: url(<?php echo $pic_url; ?>);">
          </div>
        </a>

        <?php the_category(); ?>
        
        <div class="post-title-small">
          <a href="<?php echo get_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </div>

        <div class="post-author post-date font-size-18">
          <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
        </div>
      </div>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>

  <!-- Script to enable pull quotes on alternating sides -->
  <script>
    (function() {
      var highlightedItems = document.querySelectorAll(".pullquote");
      highlightedItems.forEach(function(el, index) {
        el.className = "pullquote " + ((index % 2) ? "right" : "left");
      });
    })()
  </script>
</article>