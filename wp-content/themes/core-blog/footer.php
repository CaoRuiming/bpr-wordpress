<?php 
    $copyright = get_theme_mod('core_blog_copyright',esc_html__('Proudly Powered By WordPress', 'core-blog'));
    $display_copyright = get_theme_mod('core_blog_footer_copyright_display',true);
?>	
	</div><!-- #wrapper -->
	<?php
		   if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4'))
        {
            ?>
            <footer class="footer-section">
            <?php
            $count = 0;
            for ($i = 1;$i <= 4;$i++)
            {
                if (is_active_sidebar('footer-' . $i))
                {
                    $count++;
                }
            }

            $footer_col = 4;
            if ($count == 4)
            {
                $footer_col = 3;
            }
            elseif ($count == 3)
            {
                $footer_col = 4;
            }
            elseif ($count == 2)
            {
                $footer_col = 6;
            }
            elseif ($count == 1)
            {
                $footer_col = 12;
            }
            ?>
                <div class="container-fluid plr-12">
                    <div class="footer-top">
                        <div class="row">
            <?php
            for ($i = 1;$i <= 4;$i++)
            {
                if (is_active_sidebar('footer-' . $i))
                {
            ?>
                <div class="col-md-<?php echo esc_html($footer_col); ?>">
                    <div class="footer-top-box wow fadeInUp">
                        <?php dynamic_sidebar('footer-' . $i); ?>
                    </div>
                </div>
                <?php
                }
            }
            ?>
                        </div>
                    </div>
                </div>
            </footer>
            <?php
            }

        if($display_copyright){
		?>
    	<section class="footer">
            <p class="copyright"><?php echo wp_kses_post($copyright); ?></p>
        </section>
        <?php } ?>
    
</div><!-- #page -->
<button onclick="topFunction()" id="myBtn" title="<?php echo esc_attr__("Go to top", 'core-blog') ?>">
        <i class="fa fa-angle-up"></i>
</button>
<?php wp_footer(); ?>

</body>
</html>