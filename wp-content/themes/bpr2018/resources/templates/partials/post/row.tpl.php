<?php $pic_url = get_the_post_thumbnail_url(); global $TEMPLATE_IS_CATEGORY; ?>
<div class="horizontal-rule faint"></div>
<div class="row post-row">
  <div class="col-sm-2 post-date font-size-18">
    <?php if (get_the_date()) { echo get_the_date(); } ?>
  </div>

  <div class="col-sm-7">
    <div class="post-title-small">
      <a href="<?php echo get_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </div>

    <?php if (!is_category()) the_category(); ?>

    <p class="font-size-20">
      <?php
      $content = apply_filters('the_content', get_the_content());
      echo substr(sanitize_text_field($content), 0, 250) . '...';
      ?>
    </p>

    <div class="post-author font-size-18"><?php the_author(); ?></div>
  </div>

  <div class="col-sm-3">
    <a href="<?php echo get_permalink(); ?>">
      <div class="img-10-wrapper">
        <div
          class="img-10"
          style="background-image: url(<?php echo $pic_url; ?>);">
        </div>
      </div>
    </a>
  </div>
</div>
