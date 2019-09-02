        </main>
        <footer>
          <div id="footer-background">
            <div id="footer-content" class="container-fluid">
              <div class="row">
                <div class="footer-heading content col-sm-3">
                  <div
                    class="logo"
                    style="background-image: url(<?php echo get_image_asset('BPR_logo_white.png'); ?>)">
                  </div>
                </div>
                <div class="content col-sm-3">
                  <?php
                  wp_nav_menu(array(
                    'theme_location'    => 'footer',
                    'depth'             => 1,
                    'container'         => 'div',
                    'container_class'   => 'footer-menu',
                    'container_id'      => 'footer-menu',
                  ));
                  ?>
                </div>
                <div class="content col-sm-3"></div>
                <div class="content col-sm-3"></div>
              </div>
            </div>
          </div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
