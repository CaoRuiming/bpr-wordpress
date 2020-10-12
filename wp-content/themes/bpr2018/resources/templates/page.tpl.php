<?php get_header(); ?>

<div id="page-template" class="content-wrapper container-fluid">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post() ?>
      <article>
        <div class="row">
          <div class="col-lg-2"></div> <!-- Padding -->
          <div class="content col-lg-8">
            <h1><?php the_title(); ?></h1>

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

          <div class="col-lg-2"></div> <!-- Padding -->
        </div>

        <div class="row">
          <div class="col-lg-2"></div>
          <div class="content col-lg-8">
            <?php the_content(); ?>
          </div>
          <div class="col-lg-2"></div>
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
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
