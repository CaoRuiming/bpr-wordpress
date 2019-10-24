<?php $pic_url = get_the_post_thumbnail_url(); ?>
<article class="post-block row" itemscope itemtype="https://schema.org/Article">
  <div class="col-sm-5">
    <a href="<?php echo esc_url(get_permalink()); ?>">
      <div class="img-10-wrapper">
        <?php $placeholder = get_image_asset('placeholder_dark.jpg'); ?>
        <div
          class="img-10"
          itemprop="image"
          style="background-image: url(<?php echo $pic_url; ?>), url(<?php echo $placeholder; ?>);">
        </div>
      </div>
    </a>
  </div>

  <div class="text col-sm-7">
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
  </div>
</article>
