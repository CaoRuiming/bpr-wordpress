<?php get_header(); $page_id = get_option('page_on_front'); ?>

<div id="front-page" class="container-fluid">
  <div id="popular-articles">
    <div class="section-title">Popular Articles</div>
    <div class="carousel-wrapper row">
      <div class="carousel">
        <?php while (have_rows('featured_posts', $page_id)): the_row(); ?>
          <?php
          $post = get_sub_field('featured_post');
          $id = $post->ID;
          $pic_url = get_the_post_thumbnail_url($post);
          ?>
          <div class="container-fluid featured-post">
            <div class="row">
              <div class="col-sm-6">
                <a href="<?php echo get_permalink($id); ?>">
                  <div
                    class="img-40"
                    style="background-image: url(<?php echo $pic_url; ?>);">
                  </div>
                </a>
              </div>
  
              <div class="col-sm-6">
                <?php the_category(null, null, $id); ?>
  
                <div class="post-title-large">
                  <a href="<?php echo get_permalink($id); ?>">
                    <?php echo get_the_title($id); ?>
                  </a>
                </div>
  
                <p class="font-size-24">
                  <?php
                  $content = apply_filters('the_content', get_post_field('post_content', $id));
                  echo substr(sanitize_text_field($content), 0, 250) . '...';
                  ?>
                </p>
  
                <div class="post-author post-date font-size-20">
                  <?php echo get_the_author_meta('display_name', $post->post_author); ?>
                  <?php if (get_the_date('', $id)) { echo ' | ' . get_the_date('', $id); } ?>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <?php
      $left_arrow = get_template_directory_uri() . '/resources/assets/images/carousel-left.png';
      $right_arrow = get_template_directory_uri() . '/resources/assets/images/carousel-right.png';
      ?>
      <div
        class="carousel-arrow carousel-prev"
        style="background-image: url(<?php echo $left_arrow; ?>);">
      </div>
      <div
        class="carousel-arrow carousel-next"
        style="background-image: url(<?php echo $right_arrow; ?>);">
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
        <div class="col-sm-4 recent-article">
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
        <div class="col-sm-4 recent-article">
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
    <div id="section-3" class="col-sm-6 category-col">
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
            <div class="img-30-wrapper">
              <div
                class="img-30"
                style="background-image: url(<?php echo $pic_url; ?>);">
              </div>
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
    <div id="section-4" class="col-sm-6 category-col">
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
            <div class="img-30-wrapper">
              <div
                class="img-30"
                style="background-image: url(<?php echo $pic_url; ?>);">
              </div>
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
    <div id="section-5" class="col-sm-6 category-col">
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
            <div class="img-30-wrapper">
              <div
                class="img-30"
                style="background-image: url(<?php echo $pic_url; ?>);">
              </div>
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
    <div id="section-6" class="col-sm-6 category-col-compact">
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
