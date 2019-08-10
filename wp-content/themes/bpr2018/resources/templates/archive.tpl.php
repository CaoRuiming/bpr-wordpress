<?php get_header(); ?>

<div id="archive-page" class="container-fluid">

  <?php if (get_the_archive_title()): ?>
    <div class="archive-title font-size-100">
      <?php echo get_the_archive_title(); ?>
    </div>
  <?php endif; ?>

  <div class="horizontal-rule"></div>
  <div class="section-title">Latest</div>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php do_action('theme/single/row'); ?>
  <?php endwhile; ?>
    <?php if (!get_previous_posts_link()): ?>
      <div class="more-link text-center">
        <?php next_posts_link('Next Page'); ?>
      </div>
    <?php elseif (!get_next_posts_link()): ?>
      <div class="more-link text-center">
        <?php previous_posts_link('Previous Page'); ?>
      </div>
    <?php else: ?>
      <div class="row">
        <div class="more-link col-xs-6 text-left">
          <?php previous_posts_link('Previous Page'); ?>
        </div>
        <div class="more-link col-xs-6 text-right">
          <?php next_posts_link('Next Page'); ?>
        </div>
      </div>
    <?php endif; ?>
  <?php else: ?>
    <p><?php esc_html_e( 'Sorry, no posts matched your search.' ); ?></p>
  <?php endif; ?>

  <script>
    // hide first faint horizontal rule in results list
    document.body
      .querySelector('.horizontal-rule.faint')
      .setAttribute('style', 'display: none;');
  </script>
</div>

<?php get_footer(); ?>
