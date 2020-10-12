<?php get_header(); ?>

<div class="page-template content-wrapper container-fluid">
  <?php 
  $pic_url = get_template_directory_uri() . '/resources/assets/images/404.jpg';;
  if ($pic_url):
  ?>
    <div class-"row">
      <div
        class="featured-image"
        style="background-image: url(<?php echo $pic_url; ?>);">
      </div>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
