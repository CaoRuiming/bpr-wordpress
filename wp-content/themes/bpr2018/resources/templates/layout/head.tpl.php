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
          <!-- Brand and toggle get grouped for better mobile display -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
            <div id="nav-icon">
              <span id="nav-icon-1"></span>
              <span id="nav-icon-2"></span>
              <span id="nav-icon-3"></span>
              <span id="nav-icon-4"></span>
            </div>
            </span>
          </button>
          <div id="header-icons">
            <div id="header-search-wrapper">
              <form
                id="header-search-light"
                name="header-search"
                method="get"
                action="<?php echo esc_url(home_url('/')); ?>"
              >
                <?php $search_icon_url = get_image_asset('search-icon.png'); ?>
                <?php $search_icon_url_dark = get_image_asset('search-icon-dark.png'); ?>
                <input
                  id="light"
                  class="header-search-box"
                  type="text"
                  name="s"
                  placeholder="Search…"
                  style="background-image: url(<?php echo $search_icon_url ?>)"
                >
              </form>
              <form
                id="header-search-dark"
                name="header-search"
                method="get"
                action="<?php echo esc_url(home_url('/')); ?>"
              >
                <?php $search_icon_url = get_image_asset('search-icon.png'); ?>
                <?php $search_icon_url_dark = get_image_asset('search-icon-dark.png'); ?>
                <input
                  id="dark"
                  class="header-search-box"
                  type="text"
                  name="s"
                  placeholder="Search…"
                  style="background-image: url(<?php echo $search_icon_url_dark ?>)"
                >
              </form>
            </div>
            <?php
            $facebook_icon_url = get_image_asset('facebook_icon.png');
            $facebook_icon_inverted_url = get_image_asset('facebook_icon_inverted.png');
            $twitter_icon_url = get_image_asset('twitter_icon.png');
            $twitter_icon_inverted_url = get_image_asset('twitter_icon_inverted.png');
            ?>
            <?php if (get_field('facebook_url', 'option')): ?>
              <a href="<?php echo esc_url(get_field('facebook_url', 'option')); ?>">
                <div
                  id="light"
                  class="social-icon"
                  style="background-image: url(<?php echo $facebook_icon_url ?>)">
                </div>
                <div
                  id="dark"
                  class="social-icon"
                  style="background-image: url(<?php echo $facebook_icon_inverted_url ?>)">
                </div>
              </a>
            <?php endif; ?>
            <?php if (get_field('twitter_url', 'option')): ?>
              <a href="<?php echo esc_url(get_field('twitter_url', 'option')); ?>">
                <div
                  id="light"
                  class="social-icon"
                  style="background-image: url(<?php echo $twitter_icon_url ?>)">
                </div>
                <div
                  id="dark"
                  class="social-icon"
                  style="background-image: url(<?php echo $twitter_icon_inverted_url ?>)">
                </div>
              </a>
            <?php endif; ?>
          </div>
          <a class="navbar-brand" tabindex="0" href="<?= get_home_url(); ?>">
            <div
              id="light"
              class="logo"
              style="background-image: url(<?php echo get_image_asset('BPR_logo_black.png'); ?>)">
            </div>
            <div
              id="dark"
              class="logo"
              style="background-image: url(<?php echo get_image_asset('BPR_logo_white.png'); ?>)">
            </div>
          </a>
          <?php
          wp_nav_menu(array(
            'theme_location'    => 'primary',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'navbar-collapse-mobile',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
            'walker'            => new WP_Bootstrap_Navwalker(),
          ));
          ?>
        </div>
        <?php
          wp_nav_menu(array(
            'theme_location'    => 'primary',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'navbar-collapse',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
            'walker'            => new WP_Bootstrap_Navwalker(),
          ));
          ?>
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
        // On nav-icon click, displays animation and applies class open to all children.
        $(document).ready(function(){
          $('#nav-icon').click(function(){
            $(this).toggleClass('open');
          });
          $('.dropdown-toggle').click(function(){
            if ($(this).hasClass("open")) {
              location.href = $(this).attr('href');
            }
            else {
              $(this).toggleClass("open");
            }
          })
        });
      </script>
