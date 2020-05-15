<?php get_header(); ?>

<div id="author-page" class="container-fluid">
  <div id="author-header" class="row">
    <div class="col-md-3 col-xs-12">
      <div id="author-avatar-placeholder">
        <div id="author-avatar" style="background-image:
          url(<?php echo nl2br(get_avatar_url(get_the_author_meta('user_email'), array("size" => 175))); ?>)">
        </div>
      </div>
    </div>
    <div class="col-md-9 col-xs-12">
      <h1 class="archive-title font-size-100 header-font">
        <span itemprop="author"><?php the_author(); ?></span>
      </h1>
      <p>
        <?php echo nl2br(get_the_author_meta('description')); ?>
      </p>
    </div>
  </div>

  <section>
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
  </section>

  <script>
    // hide first faint horizontal rule in results list
    document.body
      .querySelector('.horizontal-rule.faint')
      .setAttribute('style', 'display: none;');
  </script>
</div>

<?php get_footer(); ?>
