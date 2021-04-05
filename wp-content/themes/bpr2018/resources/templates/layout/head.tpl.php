<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
  <a id="skip-nav" class="sr-only" href="#top-of-content"> Skip Navigation </a> <!-- For screenreaders skipping nav -->
    <?php if (get_field('enable_alert', 'option')): ?>
      <header>
        <!-- Alert Banner Scripts are written elsewhere -->
        <div class="alert-banner">
          <?php the_field('alert_message', 'option'); ?>
        </div>
      </header>
    <?php endif; ?>
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
                name="header-search"
                role="search"
                method="get"
                action="<?php echo esc_url(home_url('/')); ?>"
              >
                <input
                  class="header-search-box"
                  aria-label="search"
                  type="search"
                  name="s"
                  placeholder="Search…"
                  autocomplete="off"
                >
              </form>
            </div>
            <?php
            $facebook_icon_url = get_image_asset('facebook_icon.png');
            $facebook_icon_inverted_url = get_image_asset('facebook_icon_inverted.png');
            $twitter_icon_url = get_image_asset('twitter_icon.png');
            $twitter_icon_inverted_url = get_image_asset('twitter_icon_inverted.png');
            $instagram_icon_url = get_image_asset('instagram_icon.png');
            $instagram_icon_inverted_url = get_image_asset('instagram_icon_inverted.png')
            ?>
            <?php if (get_field('facebook_url', 'option')): ?>
              <a
                title="Facebook"
                href="<?php echo esc_url(get_field('facebook_url', 'option')); ?>">
                <div
                  id="facebook-icon"
                  class="social-icon">
                  <span role="img" aria-label="Facebook Icon"> </span>
                </div>
              </a>
            <?php endif; ?>
            <?php if (get_field('twitter_url', 'option')): ?>
              <a
                title="Twitter"
                href="<?php echo esc_url(get_field('twitter_url', 'option')); ?>">
                <div
                  id="twitter-icon"
                  class="social-icon">
                  <span role="img" aria-label="Twitter Icon"> </span>
                </div>
              </a>
            <?php endif; ?>
            <?php if (get_field('instagram_url', 'option')): ?>
              <a
                title="Instagram"
                href="<?php echo esc_url(get_field('instagram_url', 'option')); ?>">
                <div
                  id="instagram-icon"
                  class="social-icon">
                  <span role="img" aria-label="Instagram Icon"> </span>
                </div>
              </a>
            <?php endif; ?>
          </div>
          <a
            title="Brown Political Review"
            class="navbar-brand"
            href="<?= get_home_url(); ?>">
            <div
              id="light"
              class="logo"
              style="background-image: url(<?php echo get_image_asset('BPR_logo_black.png'); ?>)">
              <span role="img" aria-label="Brown Political Review Logo"> </span>
            </div>
            <div
              id="dark"
              class="logo"
              style="background-image: url(<?php echo get_image_asset('BPR_logo_white.png'); ?>)">
              <span role="img" aria-label="Brown Political Review Logo"> </span>
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

        // Lazy load images using Intersection Observer API
        document.addEventListener("DOMContentLoaded", function() {
          let lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-image"));

          if ("IntersectionObserver" in window) {
            let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
              entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                  entry.target.classList.remove("lazy-image");
                  lazyBackgroundObserver.unobserve(entry.target);
                }
              });
            }, {
              root: null,
              rootMargin: '0px 0px 200px 0px'
            });

            lazyBackgrounds.forEach(function(lazyBackground) {
              lazyBackgroundObserver.observe(lazyBackground);
            });
          }
        });
      </script>
<div id="top-of-content" name="top-of-content"></div>

