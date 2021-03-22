<?php get_header(); ?>

<h1 class="sr-only">Sorry, this page doesn't seem to exist!</h1>
<div class="page-template content-wrapper container-fluid" style="margin-top:50px">
  <?php 
  $pic_url = get_template_directory_uri() . '/resources/assets/images/404.jpg';;
  if ($pic_url):
  ?>
    <div class="row">
    <img src="<?php echo $pic_url; ?>" class="featured-image" alt="Cat unsuccessfully hiding under a stack of papers">
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
