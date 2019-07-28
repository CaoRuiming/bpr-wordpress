<?php get_header(); $page_id = get_option('page_on_front'); ?>

<div id="front-page" class="container-fluid">
  <div id="popular-articles">
    <div class="section-title">Popular Articles</div>
    <div class="carousel-wrapper">
      <div class="carousel">
        <?php 
        $category_object = get_category_by_slug( 'us' );
        $recent  = new WP_Query(array(
            'category_name' => $category_object->slug,
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

              <div class="post-title-large">
                <a href="<?php echo get_permalink(); ?>">
                  <?php the_title(); ?>
                </a>
              </div>

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

  <div id="section-1" class="category-row">
    <?php
    $slug = get_field('section_1', $page_id)[0]->slug;
    $category_object = get_category_by_slug($slug);
    ?>

    <div class="horizontal-rule"></div>

    <div class="section-title">
      <?php echo $category_object->name; ?>
    </div>

    <div class="row">
      <?php 
      $recent  = new WP_Query(array(
        'category_name' => $category_object->slug,
        'posts_per_page' => 3,
      ));

      while ($recent->have_posts()): ?>
        <?php
        $post = $recent->the_post();
        $pic_url = get_the_post_thumbnail_url();
        ?>
        <div class="col-md-4 recent-article">
          <a href="<?php echo get_permalink(); ?>">
            <div
              class="img-30"
              style="background-image: url(<?php echo $pic_url; ?>);">
            </div>
          </a>

          <div class="post-title-small">
            <a href="<?php echo get_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </div>

          <div class="post-author post-date font-size-18">
            <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <a class="more-link" href="<?php echo get_category_link($category_object); ?>">
      More from  <?php echo $category_object->name; ?> >
    </a>
  </div>

  <div id="section-2" class="category-row">
    <?php
    $slug = get_field('section_2', $page_id)[0]->slug;
    $category_object = get_category_by_slug($slug);
    ?>

    <div class="horizontal-rule"></div>

    <div class="section-title">
      <?php echo $category_object->name; ?>
    </div>

    <div class="row">
      <?php 
      $recent  = new WP_Query(array(
        'category_name' => $category_object->slug,
        'posts_per_page' => 3,
      ));

      while ($recent->have_posts()): ?>
        <?php
        $post = $recent->the_post();
        $pic_url = get_the_post_thumbnail_url();
        ?>
        <div class="col-md-4 recent-article">
          <a href="<?php echo get_permalink(); ?>">
            <div
              class="img-30"
              style="background-image: url(<?php echo $pic_url; ?>);">
            </div>
          </a>

          <div class="post-title-small">
            <a href="<?php echo get_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </div>

          <div class="post-author post-date font-size-18">
            <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <a class="more-link" href="<?php echo get_category_link($category_object); ?>">
      More from  <?php echo $category_object->name; ?> >
    </a>
  </div>

  <div class="row category-cols">
    <div id="section-3" class="col-md-6 category-col">
      <?php
      $slug = get_field('section_3', $page_id)[0]->slug;
      $category_object = get_category_by_slug($slug);
      ?>

      <div class="horizontal-rule"></div>

      <div class="section-title">
        <?php echo $category_object->name; ?>
      </div>

      <?php 
      $recent  = new WP_Query(array(
        'category_name' => $category_object->slug,
        'posts_per_page' => 3,
      ));

      while ($recent->have_posts()): ?>
        <?php
        $post = $recent->the_post();
        $pic_url = get_the_post_thumbnail_url();
        ?>
        <div class="recent-article">
          <a href="<?php echo get_permalink(); ?>">
            <div
              class="img-30"
              style="background-image: url(<?php echo $pic_url; ?>);">
            </div>
          </a>

          <div class="post-title-small">
            <a href="<?php echo get_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </div>

          <div class="post-author post-date font-size-18">
            <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
          </div>
        </div>
      <?php endwhile; ?>

      <a class="more-link" href="<?php echo get_category_link($category_object); ?>">
        More from  <?php echo $category_object->name; ?> >
      </a>
    </div>
    <div id="section-4" class="col-md-6 category-col">
      <?php
      $slug = get_field('section_4', $page_id)[0]->slug;
      $category_object = get_category_by_slug($slug);
      ?>

      <div class="horizontal-rule"></div>

      <div class="section-title">
        <?php echo $category_object->name; ?>
      </div>

      <?php 
      $recent  = new WP_Query(array(
        'category_name' => $category_object->slug,
        'posts_per_page' => 3,
      ));

      while ($recent->have_posts()): ?>
        <?php
        $post = $recent->the_post();
        $pic_url = get_the_post_thumbnail_url();
        ?>
        <div class="recent-article">
          <a href="<?php echo get_permalink(); ?>">
            <div
              class="img-30"
              style="background-image: url(<?php echo $pic_url; ?>);">
            </div>
          </a>

          <div class="post-title-small">
            <a href="<?php echo get_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </div>

          <div class="post-author post-date font-size-18">
            <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
          </div>
        </div>
      <?php endwhile; ?>

      <a class="more-link" href="<?php echo get_category_link($category_object); ?>">
        More from  <?php echo $category_object->name; ?> >
      </a>
    </div>
  </div>

  <div class="row category-cols">
    <div id="section-5" class="col-md-6 category-col">
      <?php
      $slug = get_field('section_5', $page_id)[0]->slug;
      $category_object = get_category_by_slug($slug);
      ?>

      <div class="horizontal-rule"></div>

      <div class="section-title">
        <?php echo $category_object->name; ?>
      </div>

      <?php 
      $recent  = new WP_Query(array(
        'category_name' => $category_object->slug,
        'posts_per_page' => 3,
      ));

      while ($recent->have_posts()): ?>
        <?php
        $post = $recent->the_post();
        $pic_url = get_the_post_thumbnail_url();
        ?>
        <div class="recent-article">
          <a href="<?php echo get_permalink(); ?>">
            <div
              class="img-30"
              style="background-image: url(<?php echo $pic_url; ?>);">
            </div>
          </a>

          <div class="post-title-small">
            <a href="<?php echo get_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </div>

          <div class="post-author post-date font-size-18">
            <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
          </div>
        </div>
      <?php endwhile; ?>

      <a class="more-link" href="<?php echo get_category_link($category_object); ?>">
        More from  <?php echo $category_object->name; ?> >
      </a>
    </div>
    <div id="section-6" class="col-md-6 category-col-compact">
      <?php
      $slug = get_field('section_6', $page_id)[0]->slug;
      $category_object = get_category_by_slug($slug);
      ?>

      <div class="horizontal-rule"></div>

      <div class="section-title">
        <?php echo $category_object->name; ?>
      </div>

      <?php 
      $recent  = new WP_Query(array(
        'category_name' => $category_object->slug,
        'posts_per_page' => 6,
      ));

      while ($recent->have_posts()): ?>
        <?php
        $post = $recent->the_post();
        $pic_url = get_the_post_thumbnail_url();
        ?>
        <div class="recent-article row">
          <div class="col-sm-5">
            <a href="<?php echo get_permalink(); ?>">
              <div
                class="img-10"
                style="background-image: url(<?php echo $pic_url; ?>);">
              </div>
            </a>
          </div>

          <div class="text col-sm-7">
            <div class="post-title-small">
              <a href="<?php echo get_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </div>

            <div class="post-author post-date font-size-18">
              <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>

      <a class="more-link" href="<?php echo get_category_link($category_object); ?>">
        More from  <?php echo $category_object->name; ?> >
      </a>
    </div>
  </div>

  <div class="row bpradio-row"></div>
  <div class="row magazine-row"></div>
</div>

<?php get_footer(); ?>
