<?php get_header(); ?>

<div id="front-page" class="container-fluid">
  <div id="popular-articles" class="row"></div>

  <div id="section-1" class="row category-row">
      <?php
      $category_object = get_category_by_slug( 'us' );
      ?>

      <div class="horizontal-rule"></div>

      <div class="category-title">
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
          <div class="col-md-4 recent-article">
              <a href="<?php echo get_permalink(); ?>">
                  <div
                      class="recent-img"
                      style="background-image: url(<?php echo $pic_url; ?>);">
                  </div>
              </a>

              <p class="recent-title">
                  <a href="<?php echo get_permalink(); ?>">
                      <?php the_title(); ?>
                  </a>
              </p>

              <div class="recent-author-date">
                  <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
              </div>
          </div>
      <?php endwhile; ?>

      <a class="read-more" href="<?php echo get_category_link($category_object); ?>">
        More from  <?php echo $category_object->name; ?> >
      </a>
  </div>

  <div id="section-2" class="row category-row">
      <?php
      $category_object = get_category_by_slug( 'us' );
      ?>

      <div class="horizontal-rule"></div>

      <div class="category-title">
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
          <div class="col-md-4 recent-article">
              <a href="<?php echo get_permalink(); ?>">
                  <div
                      class="recent-img"
                      style="background-image: url(<?php echo $pic_url; ?>);">
                  </div>
              </a>

              <p class="recent-title">
                  <a href="<?php echo get_permalink(); ?>">
                      <?php the_title(); ?>
                  </a>
              </p>

              <div class="recent-author-date">
                  <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
              </div>
          </div>
      <?php endwhile; ?>

      <a class="read-more" href="<?php echo get_category_link($category_object); ?>">
        More from  <?php echo $category_object->name; ?> >
      </a>
  </div>

  <div class="row category-cols">
    <div id="section-3" class="col-md-6 category-col">
      <div class="col-md-12">
        <?php
        $category_object = get_category_by_slug( 'us' );
        ?>

        <div class="horizontal-rule"></div>
  
        <div class="category-title">
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
                        class="recent-img"
                        style="background-image: url(<?php echo $pic_url; ?>);">
                    </div>
                </a>
  
                <p class="recent-title">
                    <a href="<?php echo get_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </p>
  
                <div class="recent-author-date">
                    <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
                </div>
            </div>
        <?php endwhile; ?>
  
        <a class="read-more" href="<?php echo get_category_link($category_object); ?>">
          More from  <?php echo $category_object->name; ?> >
        </a>
      </div>
    </div>
    <div id="section-4" class="col-md-6 category-col">
      <div class="col-md-12">
        <?php
        $category_object = get_category_by_slug( 'us' );
        ?>

        <div class="horizontal-rule"></div>
  
        <div class="category-title">
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
                        class="recent-img"
                        style="background-image: url(<?php echo $pic_url; ?>);">
                    </div>
                </a>
  
                <p class="recent-title">
                    <a href="<?php echo get_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </p>
  
                <div class="recent-author-date">
                    <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
                </div>
            </div>
        <?php endwhile; ?>
  
        <a class="read-more" href="<?php echo get_category_link($category_object); ?>">
          More from  <?php echo $category_object->name; ?> >
        </a>
      </div>
    </div>
  </div>

  <div class="row category-cols">
    <div id="section-5" class="col-md-6 category-col">
      <div class="col-md-12">
        <?php
        $category_object = get_category_by_slug( 'us' );
        ?>

        <div class="horizontal-rule"></div>
  
        <div class="category-title">
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
                        class="recent-img"
                        style="background-image: url(<?php echo $pic_url; ?>);">
                    </div>
                </a>
  
                <p class="recent-title">
                    <a href="<?php echo get_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </p>
  
                <div class="recent-author-date">
                    <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
                </div>
            </div>
        <?php endwhile; ?>
  
        <a class="read-more" href="<?php echo get_category_link($category_object); ?>">
          More from  <?php echo $category_object->name; ?> >
        </a>
      </div>
    </div>
    <div id="section-6" class="col-md-6 category-col-compact">
      <div class="col-md-12">
        <?php
        $category_object = get_category_by_slug( 'us' );
        ?>

        <div class="horizontal-rule"></div>
  
        <div class="category-title">
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
            <div class="recent-article row">
                <div class="col-sm-5">
                  <a href="<?php echo get_permalink(); ?>">
                      <div
                          class="recent-img"
                          style="background-image: url(<?php echo $pic_url; ?>);">
                      </div>
                  </a>
                </div>
    
                <div class="text col-sm-7">
                  <p class="recent-title">
                      <a href="<?php echo get_permalink(); ?>">
                          <?php the_title(); ?>
                      </a>
                  </p>
    
                  <div class="recent-author-date">
                      <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
                  </div>
                </div>
            </div>
        <?php endwhile; ?>
  
        <a class="read-more" href="<?php echo get_category_link($category_object); ?>">
          More from  <?php echo $category_object->name; ?> >
        </a>
      </div>
    </div>
  </div>

  <div class="row bpradio-row"></div>
  <div class="row magazine-row"></div>
</div>

<?php get_footer(); ?>