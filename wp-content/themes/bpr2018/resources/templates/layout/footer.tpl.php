            <footer class="footer">
              <ul>
                  <li><a href="<?= get_home_url(); ?>">Index</a></li>
                  <li><a href="https://github.com/tonik/tonik/wiki">Documentation</a></li>
                  <li><a href="https://github.com/tonik/tonik">Github</a></li>
              </ul>
              <div id="background">
                <div class="content-wrapper container-fluid">
                  <div class="row">
                    <div class="content col-lg-3">
                      <div>
                        <img class="top_element" id="logo" src="http://www.brownpoliticalreview.org/wp-content/uploads/2016/03/SQ_Logo.jpg" width="25%"/>
                      </div>
                      <div id="media_links">
                          <?php wp_nav_menu( array(
                              'menu' => 'social-media',
                              // 'theme_location' => 'top',
                              'menu_id' => '4',
                          ) ); ?>
                      </div>
                    </div>
                    <div class="content col-lg-3">
                      <div class="internal_links">
                        <p>Brown Political Review</p>
                        <hr/>
                        <?php wp_nav_menu( array(
                            'menu' => 'footer-menu',
                            // 'theme_location' => 'top',
                            'menu_id' => 'footer-menu',
                        ) ); ?>
                      </div>
                    </div>
                    <div class="content col-lg-3">
                      <div class="tags">
                        <p>Tags</p>
                        <hr/>
                        <select class="category">

                        </select>
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
