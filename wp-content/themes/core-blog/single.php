<?php get_header();  ?>
      
    <section class="core-blog-wp-blog-section" id="main">
        <div class="container-fluid core_blog_container">
            <?php
            $sidebar_position = get_theme_mod('core_blog_sidebar_position', esc_html__( 'right', 'core-blog' ));
            if ($sidebar_position == 'left') {
                $sidebar_position = 'has-left-sidebar';
            } elseif ($sidebar_position == 'right') {
                $sidebar_position = 'has-right-sidebar';
            } elseif ($sidebar_position == 'no') {
                $sidebar_position = 'no-sidebar';
            }
            
            core_blog_breadcrumb_trail(); ?>
            
            <div class="row <?php echo esc_attr($sidebar_position); ?>">
                 <?php if(is_active_sidebar( 'sidebar-1' )) { ?>
                <div class="col-lg-8 col-md-8 col-sm-12 blog-single-post">
                    <?php 
                    }
                    else{
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 blog-single-post">
                        <?php
                    }
                        while ( have_posts() ) :
                            the_post();

                            get_template_part( 'template-parts/content', 'single' );
                        
                        // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;                         
                        endwhile; // End of the loop.
                    ?>
                </div>
                <?php if (($sidebar_position == 'has-left-sidebar') || ($sidebar_position == 'has-right-sidebar')) { ?>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <?php get_sidebar();?>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php
get_footer(); ?>