<?php $pic_url = get_the_post_thumbnail_url(); ?>
<div class="post-block row">
  <div class="col-sm-5">
    <a href="<?php echo get_permalink(); ?>">
      <div class="img-10-wrapper">
        <div
          class="img-10"
          style="background-image: url(<?php echo $pic_url; ?>);">
        </div>
      </div>
    </a>
  </div>

  <div class="text col-sm-7">
    <div class="post-title-small">
      <a href="<?php echo get_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </div>

    <div class="post-author post-date font-size-18">
      <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
        <?php the_author(); ?>
      </a><?php if (get_the_date()) { echo ' | ' . get_the_date(); } ?>
    </div>
  </div>
</div>
