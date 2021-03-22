<?php 
$pic_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large', NULL); 
$pic_id = get_post_thumbnail_id();
$pic_alt = get_post_meta($pic_id, '_wp_attachment_image_alt', true);
$pic_title = get_the_title($pic_id);
?>
<div class="horizontal-rule faint"></div>

<!-- For desktop, laptop, and tablet view -->
<article class="row post-row d-none d-block-md" itemscope itemtype="https://schema.org/Article">
  <div class="col-sm-2 post-date font-size-18">
    <?php
    if (get_the_date()) { echo '<time itemprop="datePublished">' . get_the_date() . '</time>'; }
    ?>
  </div>

  <div class="col-sm-7">
    <div class="post-title-small">
      <a
        itemprop="url"
        href="<?php echo esc_url(get_permalink()); ?>">
        <span itemprop="headline"><?php the_title(); ?></span>
      </a>
    </div>

    <?php if (!is_category()) the_category(); ?>

    <p class="font-size-20" itemprop="articleBody">
      <?php
      $content = apply_filters('the_content', get_the_content());
      echo substr(sanitize_text_field($content), 0, 250) . '...';
      ?>
    </p>

    <div class="post-author font-size-18">
      <span itemprop="author" hidden aria-hidden><?php the_author(); ?></span>
      <?php
      if (function_exists('coauthors_posts_links')) {
        coauthors_posts_links(', ', ', ', null, null, true);
      } else {
        the_author_posts_link();
      }
      ?>
    </div>
  </div>

  <div class="col-sm-3">
    <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo htmlentities(the_title(), ENT_QUOTES | ENT_SUBSTITUTE); ?>">
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
</article>

<!-- for phone view -->
<article class="row post-row d-none-md" itemscope itemtype="https://schema.org/Article">
  <div class="col-sm-3">
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

  <div class="col-sm-2 post-date font-size-18">
    <?php
    if (get_the_date()) { echo '<time itemprop="datePublished">' . get_the_date() . '</time>'; }
    ?>
  </div>

  <div class="col-sm-7">
    <div class="post-title-small">
      <a
        itemprop="name"
        href="<?php echo esc_url(get_permalink()); ?>">
        <?php the_title(); ?>
      </a>
    </div>

    <?php if (!is_category()) the_category(); ?>

    <p class="font-size-20" itemprop="articleBody">
      <?php
      $content = apply_filters('the_content', get_the_content());
      echo substr(sanitize_text_field($content), 0, 250) . '...';
      ?>
    </p>

    <div class="post-author font-size-18">
      <span itemprop="author" hidden aria-hidden><?php the_author(); ?></span>
      <?php
      if (function_exists('coauthors_posts_links')) {
        coauthors_posts_links(', ', ', ', null, null, true);
      } else {
        the_author_posts_link();
      }
      ?>
    </div>
  </div>
</article>
