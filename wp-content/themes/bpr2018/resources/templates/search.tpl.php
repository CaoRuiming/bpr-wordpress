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
      class="col-xs-12"
      role="search"
      method="get"
      action="<?php echo esc_url(home_url('/')); ?>"
    >
      <input
        id="search-input"
        type="search"
        placeholder="Search…"
        name="s"
        value="<?php echo esc_attr( get_search_query() ); ?>"
      />
    </form>
  </div>

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php $pic_url = get_the_post_thumbnail_url(); ?>
    <div class="horizontal-rule faint"></div>
    <div class="row search-result">
      <div class="col-sm-2 post-date font-size-18">
        <?php if (get_the_date()) { echo get_the_date(); } ?>
      </div>

      <div class="col-sm-7">
        <div class="post-title-small">
          <a href="<?php echo get_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </div>

        <?php the_category(); ?>

        <p class="font-size-20">
          <?php
          $content = apply_filters('the_content', get_the_content());
          echo substr(sanitize_text_field($content), 0, 250) . '...';
          ?>
        </p>

        <div class="post-author font-size-18"><?php the_author(); ?></div>
      </div>

      <div class="col-sm-3 overflow-hidden">
        <a href="<?php echo get_permalink(); ?>">
          <div class="img-10-wrapper">
            <div
              class="img-10"
              style="background-image: url(<?php echo $pic_url; ?>);">
            </div>
          </div>
        </a>
      </div>
    </div>
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
</div>

<?php get_footer(); ?>
