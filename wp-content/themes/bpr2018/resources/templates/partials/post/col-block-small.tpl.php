<?php 
$pic_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large', NULL); 
$pic_id = get_post_thumbnail_id();
$pic_alt = get_post_meta($pic_id, '_wp_attachment_image_alt', true);
$pic_title = get_the_title($pic_id);
?>
<article class="post-block row" itemscope itemtype="https://schema.org/Article">
  <div class="col-sm-5">
    <a href="<?php echo esc_url(get_permalink()); ?>">
      <div class="img-10-wrapper">
        <?php $placeholder = get_image_asset('placeholder_dark.jpg'); ?>
        <div
          class="img-10"
          itemprop="image"
          style="background-image: url(<?php echo $pic_url; ?>), url(<?php echo $placeholder; ?>);">
          <span role="img" aria-label="<?php echo $pic_alt; ?>"> </span>
        </div>
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
