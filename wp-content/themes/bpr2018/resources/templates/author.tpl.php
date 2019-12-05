<?php get_header(); ?>

<div id="author-page" class="container-fluid">
  <div id="author-header" class="container-fluid">
  <div class="col-xs-3">
    <img src="https://static01.nyt.com/images/2018/11/06/multimedia/author-nicholas-fandos/author-nicholas-fandos-thumbLarge-v2.png" style="width: 20rem; float:right">
  </div>
  <div class="col-xs-9">
    <?php if (get_the_archive_title()): ?>
      <h1 class="archive-title font-size-100 header-font">
        <?php echo get_the_archive_title(); ?>
      </h1>
    <?php endif; ?>
    <p>
    Sloop gunwalls lanyard Corsair Spanish Main avast spyglass rum parrel Privateer. Sutler gabion rum boom weigh anchor scurvy draught gibbet ballast bowsprit. Prow poop deck tack Spanish Main barkadeer grog Shiver me timbers swing the lead Buccaneer nipperkin.
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
