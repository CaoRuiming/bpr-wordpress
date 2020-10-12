<?php get_header(); ?>

<div id="search-page" class="container-fluid">
  <div id="search-field" class="row">
    <?php
    $search_icon_url = get_template_directory_uri() . '/resources/assets/images/search-icon.png';
    ?>
    <div
      id="search-icon"
      style="background-image: url(<?php echo $search_icon_url ?>)">
    </div>
    <form
      id="search-form"
      aria-labelledby="search-field"
      class="col-xs-12"
      role="search"
      method="get"
      action="<?php echo esc_url(home_url('/')); ?>"
    >
      <input
        id="search-input"
        aria-labelledby="search-field"
        aria-label="search text"
        type="search"
        placeholder="Search…"
        name="s"
        value="<?php echo esc_attr( get_search_query() ); ?>"
      />
    </form>
  </div>

  <section>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <?php do_action('theme/single/row'); ?>
    <?php endwhile; ?>
      <?php if (!get_previous_posts_link()): ?>
        <div class="more-link text-center" aria-label="next-page">
          <?php next_posts_link('Next Page'); ?>
        </div>
      <?php elseif (!get_next_posts_link()): ?>
        <div class="more-link text-center" aria-label="previous-page">
          <?php previous_posts_link('Previous Page'); ?>
        </div>
      <?php else: ?>
        <div class="row">
          <div class="more-link col-xs-6 text-left" aria-label="previous-page">
            <?php previous_posts_link('Previous Page'); ?>
          </div>
          <div class="more-link col-xs-6 text-right" aria-label="next-page">
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
