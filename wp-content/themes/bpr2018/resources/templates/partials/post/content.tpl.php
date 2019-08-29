<article itemscope itemtype="https://schema.org/Article">
  <div class="row">
    <div class="col-lg-2"></div> <!-- Padding -->
    <div class="content col-lg-8">
      <?php custom_breadcrumbs(); ?>

      <a id="article-top" name="article-top"></a> <!-- For back to top -->
      <h1 itemprop="name"><?php the_title(); ?></h1>

      <div class="post-author post-date font-size-24">
        <a
          itemprop="author"
          href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
          <?php the_author(); ?>
        </a>
        <?php
        if (get_the_date()) { echo ' | <time itemprop="datePublished">' . get_the_date() . '</time>'; }
        ?>
      </div>

      <?php 
      $pic_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
      if ($pic_url):
      ?>
        <figure itemprop="image">
          <img class="featured-image" src="<?php echo $pic_url; ?>">
        </figure>
      <?php endif; ?>

      <div class="hline"></div>
    </div>

    <div class="col-lg-2"></div> <!-- Padding -->
  </div>

  <div class="row">
    <div class="col-lg-2"></div>

    <div class="content col-lg-8">
      <div itemprop="articleBody"><?php the_content(); ?></div>

      <div class="back-to-top text-center">
        <a href="#article-top" class="uppercase font-size-18">Back to Top</a>
      </div>

      <section class="article-bottom">
        <div class="row">
          <div class="post-tags col-sm-10" itemprop="keywords">
            <?php
            the_tags(
              '<div class="post-tag uppercase font-size-16">',
              '</div><span style="display: none;">,</span><div class="post-tag uppercase font-size-16">',
              '</div>'
            );
            ?>
          </div>
          <div class="col-sm-2 social-icons d-none d-flex-md">
            <?php
            $facebook_icon_url = get_image_asset('facebook_icon.png');
            $twitter_icon_url = get_image_asset('twitter_icon.png');
            ?>
            <?php if (get_field('facebook_url', 'option')): ?>
              <a href="<?php echo get_field('facebook_url', 'option'); ?>">
                <div
                  class="social-icon"
                  style="background-image: url(<?php echo $facebook_icon_url ?>)">
                </div>
              </a>
            <?php endif; ?>
            <?php if (get_field('twitter_url', 'option')): ?>
              <a href="<?php echo get_field('twitter_url', 'option'); ?>">
                <div
                  class="social-icon"
                  style="background-image: url(<?php echo $twitter_icon_url ?>)">
                </div>
              </a>
            <?php endif; ?>
          </div>
        </div>

        <?php if (get_the_author_meta('user_description')): ?>
          <div class="about-author row">
            <p class="about-author-title uppercase">About the Author</p>
            <p class="about-author-bio">
              <?php echo get_the_author_meta('user_description'); ?>
            </p>
          </div>
        <?php endif; ?>
      </section>
    </div>

    <div class="col-lg-2 d-none d-md-block"><?php the_category(); ?></div>
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

<!-- Suggested Aritcles -->
<section>
  <div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
      <p class="suggested-articles-title">SUGGESTED ARTICLES</p>
    </div>
    <div class="col-lg-2"></div>
  </div>

  <div class="row suggested-articles">
    <?php 
    $suggested  = new WP_Query(array(
      'posts_per_page' => 3,
      'cat' => array_map(function($c) { return $c->cat_ID; }, get_the_category()),
      'post__not_in' => array(get_the_ID()), // exclude current post
    ));
    $suggested_count = 0;
    while ($suggested->have_posts() && $suggested_count < 3): ?>
      <?php
      $suggested_count += 1;
      $suggested->the_post();
      do_action('theme/single/row-block');
      ?>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
</section>
