<?php $pic_url = get_the_post_thumbnail_url(); ?>
<div class="post-block">
  <a href="<?php echo get_permalink(); ?>">
    <div class="img-35-wrapper">
      <div
        class="img-35"
        style="background-image: url(<?php echo $pic_url; ?>);">
      </div>
    </div>
  </a>

  <div class="post-title-small">
    <a href="<?php echo get_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </div>

  <div class="post-author post-date font-size-18">
    <?php the_author(); ?><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
  </div>
</div>
