<?php get_header(); ?>

<div id="author-page" class="container-fluid">
  <div id="author-header" class="row">
    <div class="col-md-3 col-xs-12">
    <!-- Change this to a div with the right size, cropped -->
      <img src= <?php echo nl2br(get_avatar_url(get_the_author_meta('user_email'))); ?> >
      <img src="https://scontent.fzty2-1.fna.fbcdn.net/v/t1.0-1/p240x240/55857544_786541738384415_6524938221871169536_n.jpg?_nc_cat=106&_nc_eui2=AeHUNJpb-gAiCutFawQ6chCMibH7mxiLiEhfLNR-MkPEYn6_8lfpfz7YOzIMC-rHJDhpPiNyrgYI-HrNipF8hMM9lggNz5t-1k7ZjddkXySESw&_nc_ohc=6Q9OkWSYSH8AQm0J93-0mxVsp1Xx2-F_OQkdsbHRGDckQLwhGOiR0ms8w&_nc_ht=scontent.fzty2-1.fna&oh=5b9b98b541abbd1c2260fce2ca846902&oe=5E3F8409" style="width: 20rem; margin: 10px 0">
    </div>
    <div class="col-md-9 col-xs-12">
      <?php if (get_the_archive_title()): ?>
        <h1 class="archive-title font-size-100 header-font">
          <!-- <?php echo get_the_archive_title(); ?> -->
          <?php the_author(); ?>
        </h1>
      <?php endif; ?>
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
