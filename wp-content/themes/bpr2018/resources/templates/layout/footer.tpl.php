            <footer class="footer">
              <div id="background">
                <div class="content-wrapper container-fluid">
                  <div class="row">
                    <div class="footer-heading content col-lg-3">
                      <div class="footer-logo" style="background-image: url(<?php echo get_template_directory_uri() . '/resources/assets/images/BPR_logo_white.png' ?>)"></div>
                    </div>
                    <div class="content col-lg-3">
                      <!-- <div id="media_links">
                          <?php wp_nav_menu( array(
                              'menu' => 'social-media',
                              // 'theme_location' => 'top',
                              'menu_id' => '4',
                          ) ); ?>
                      </div> -->
                    </div>
                    <div class="content col-lg-3">
                      <p id="sub_heading">Brown Political Review</p>
                      <hr/>
                      <div class="internal_links left">
                        <?php wp_nav_menu( array(
                            'menu' => 'footer-menu',
                            // 'theme_location' => 'top',
                            'menu_id' => 'footer-menu',
                        ) ); ?>
                      </div>
                      <div class="internal_links center">
                        <?php wp_nav_menu( array(
                            'menu' => 'footer-menu',
                            // 'theme_location' => 'top',
                            'menu_id' => 'footer-menu',
                        ) ); ?>
                      </div>
                      <div class="internal_links right">
                        <?php wp_nav_menu( array(
                            'menu' => 'footer-menu',
                            // 'theme_location' => 'top',
                            'menu_id' => 'footer-menu',
                        ) ); ?>
                      </div>
                    </div>
                    <div class="content col-lg-3"></div>
                  </div>
                </div>
              </div>
            </footer>
        </main>

        <?php wp_footer(); ?>
    </body>
</html>
