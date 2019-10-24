<?php $pic_url = get_the_post_thumbnail_url(); ?>
<article class="col-sm-4 post-block" itemscope itemtype="https://schema.org/Article">
  <a href="<?php echo esc_url(get_permalink()); ?>">
    <div class="img-30-wrapper">
      <?php $placeholder = get_image_asset('placeholder_dark.jpg'); ?>
      <?php $placeholder_dark = get_image_asset('placeholder_bright.jpg'); ?>
      <div
        id="light"
        class="img-30"
        itemprop="image"
        style="background-image: url(<?php echo $pic_url; ?>), url(<?php echo $placeholder; ?>);">
      </div>
      <div
        id="dark"
        class="img-30"
        itemprop="image"
        style="background-image: url(<?php echo $pic_url; ?>), url(<?php echo $placeholder_dark; ?>);">
      </div>
    </div>
  </a>

  <?php if (!is_front_page()) the_category(); ?>

  <div class="post-title-small">
    <a itemprop="name" href="<?php echo esc_url(get_permalink()); ?>">
      <?php the_title(); ?>
    </a>
  </div>

  <div class="post-author post-date font-size-18">
    <a 
      itemprop="author"
      href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
      <?php the_author(); ?>
    </a>
    <?php
    if (get_the_date()) { echo ' | <time itemprop="datePublished">' . get_the_date() . '</time>'; }
    ?>
  </div>
</article>
