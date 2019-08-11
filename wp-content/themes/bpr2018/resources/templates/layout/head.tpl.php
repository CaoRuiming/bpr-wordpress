<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <main id="app" class="app">
      <nav id="main-menu" class="navbar navbar-expand-md navbar-light bg-light" role="navigation">
        <div class="container">
          <div id="header-icons">
            <div id="header-search-wrapper">
              <form
                id="header-search"
                name="header-search"
                method="get"
                action="<?php echo esc_url(home_url('/')); ?>"
              >
                <?php
                $search_icon_url = get_template_directory_uri() . '/resources/assets/images/search-icon.png';
                ?>
                <input
                  id="header-search-box"
                  type="text"
                  name="s"
                  placeholder="Search…"
                  style="background-image: url(<?php echo $search_icon_url ?>)"
                >
              </form>
            </div>
            <?php
            $images_directory = get_template_directory_uri() . '/resources/assets/images/';
            $facebook_icon_url = $images_directory . 'facebook_icon.png';
            $twitter_icon_url = $images_directory . 'twitter_icon.png';
            ?>
            <?php if (get_field('facebook_url', 'option')): ?>
              <a href="<?php echo get_field('facebook_url', 'option'); ?>">
                <div
                  class="header-social"
                  style="background-image: url(<?php echo $facebook_icon_url ?>)">
                </div>
              </a>
            <?php endif; ?>
            <?php if (get_field('twitter_url', 'option')): ?>
              <a href="<?php echo get_field('twitter_url', 'option'); ?>">
                <div
                  class="header-social"
                  style="background-image: url(<?php echo $twitter_icon_url ?>)">
                </div>
              </a>
            <?php endif; ?>
          </div>
          <!-- Brand and toggle get grouped for better mobile display -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="navbar-collapse-1" aria-controls="navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="<?= get_home_url(); ?>">
            <div class="logo" style="background-image: url(<?php echo get_template_directory_uri() . '/resources/assets/images/BPR_logo_black.png' ?>)"></div>
          </a>
          <?php
          wp_nav_menu(array(
            'theme_location'    => 'primary',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'navbar-collapse-1',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
            'walker'            => new WP_Bootstrap_Navwalker(),
          ));
          ?>
        </div>
      </nav>
      <script>
        // Allows dropdown parent elements to be clickable links
        $('li.dropdown :first-child').on('click', function() {
          var $dropdown = $(this).find('+ ul.dropdown-menu');
          var $el = $(this).parent();

          // navigate to dropdown trigger url if dropdown menu expanded
          if ($el.hasClass('open') || $dropdown.css('display') === 'block') {
            var $a = $el.children('a.dropdown-toggle');
            if ($a.length && $a.attr('href')) {
              location.href = $a.attr('href');
            }
          }
        });
      </script>
