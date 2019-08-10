<?php $pic_url = get_the_post_thumbnail_url(); ?>
<div class="col-sm-4 post-block">
  <a href="<?php echo get_permalink(); ?>">
    <div class="img-30-wrapper">
      <div
        class="img-30"
        style="background-image: url(<?php echo $pic_url; ?>);">
      </div>
    </div>
  </a>

  <?php if (!is_front_page()) the_category(); ?>

  <div class="post-title-small">
    <a href="<?php echo get_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </div>

  <div class="post-author post-date font-size-18">
    <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
  </div>
</div>
