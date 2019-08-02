<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <main id="app" class="app">
      <nav id="main-menu" class="navbar navbar-expand-md navbar-light bg-light" role="navigation">
        <div class="container">
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
              <!-- <div
                id="header-search-icon"
                style="background-image: url(<?php echo $search_icon_url ?>)">
              </div> -->
              <input
                id="header-search-box"
                type="text"
                name="s"
                placeholder="Search…"
                style="background-image: url(<?php echo $search_icon_url ?>)"
              >
            </form>
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
          var $el = $(this).parent();
          if ($el.hasClass('open')) {
            var $a = $el.children('a.dropdown-toggle');
            if ($a.length && $a.attr('href')) {
              location.href = $a.attr('href');
            }
          }
        });
      </script>
