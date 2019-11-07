<?php $pic_url = get_the_post_thumbnail_url(); ?>
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
      <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
        <span itemprop="author"><?php the_author(); ?></span>
      </a>
    </div>
  </div>

  <div class="col-sm-3">
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
      <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
        <span itemprop="author"><?php the_author(); ?></span>
      </a>
    </div>
  </div>
</article>
