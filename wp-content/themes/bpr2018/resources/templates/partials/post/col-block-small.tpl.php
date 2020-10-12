<?php $pic_url = get_the_post_thumbnail_url(); ?>
<article class="post-block row" itemscope itemtype="https://schema.org/Article">
  <div class="col-sm-5">
    <a href="<?php echo esc_url(get_permalink()); ?>">
      <div class="img-10-wrapper">
        <?php $placeholder = get_image_asset('placeholder_dark.jpg'); ?>
        <?php $placeholder_dark = get_image_asset('placeholder_bright.jpg'); ?>
        <div
          class="img-10"
          itemprop="image"
          style="background-image: url(<?php echo $pic_url; ?>), url(<?php echo $placeholder; ?>);">
        </div>
        <!-- <div
          id="dark"
          class="img-10"
          itemprop="image"
          style="background-image: url(<?php echo $pic_url; ?>), url(<?php echo $placeholder_dark; ?>);">
        </div> -->
      </div>
    </a>
  </div>

  <div class="text col-sm-7">
    <div class="post-title-small">
      <a itemprop="url" href="<?php echo esc_url(get_permalink()); ?>">
      <span itemprop="headline"><?php the_title(); ?></span>
      </a>
    </div>

    <div class="post-author post-date font-size-18">
      <span itemprop="author" hidden aria-hidden><?php the_author(); ?></span>
      <?php
      if (function_exists('coauthors_posts_links')) {
        coauthors_posts_links(', ', ', ', null, null, true);
      } else {
        the_author_posts_link();
      }
      if (get_the_date()) { echo ' | <time itemprop="datePublished">' . get_the_date() . '</time>'; }
      ?>
    </div>
  </div>
</article>
