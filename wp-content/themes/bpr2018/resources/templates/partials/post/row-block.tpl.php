<?php $pic_url = get_the_post_thumbnail_url(); ?>
<article class="col-sm-4 post-block" itemscope itemtype="https://schema.org/Article">
  <a href="<?php echo esc_url(get_permalink()); ?>">
    <div class="img-30-wrapper">
      <?php $placeholder = get_image_asset('placeholder_dark.jpg'); ?>
      <div
        class="img-30"
        itemprop="image"
        style="background-image: url(<?php echo $pic_url; ?>), url(<?php echo $placeholder; ?>);">
      </div>
    </div>
  </a>

  <?php if (!is_front_page()) the_category(); ?>

  <div class="post-title-small">
    <a itemprop="url" href="<?php echo esc_url(get_permalink()); ?>">
      <span itemprop="headline"><?php the_title(); ?></span>
    </a>
  </div>

  <div class="post-author post-date font-size-18">
    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
      <span itemprop="author"><?php the_author(); ?></span>
    </a>
    <?php
    if (get_the_date()) { echo ' | <time itemprop="datePublished">' . get_the_date() . '</time>'; }
    ?>
  </div>
</article>
