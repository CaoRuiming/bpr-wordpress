<?php if(!function_exists('newsclick_frontpage_editor_post_section')):

/**
*
* @since Newsclick
*
*
*/
  function newsclick_frontpage_editor_post_section()
    {

        if(is_front_page() || is_home())
        { 
         $number_of_posts = '2';
         $newsup_editor_news_category = newsup_get_option('select_editor_news_category');
         $newsup_all_posts_main = newsup_get_posts($number_of_posts, $newsup_editor_news_category);
        ?>

        <div class="col-md-3">
            
            
               
                        <?php if ($newsup_all_posts_main->have_posts()) :
                        while ($newsup_all_posts_main->have_posts()) : $newsup_all_posts_main->the_post();
                        global $post;
                        $newsup_url = newsup_get_freatured_image_url($post->ID, 'newsup-slider-full'); ?>
                        <div class="mg-blog-post lg mins back-img mr-bot30" style="background-image: url('<?php echo esc_url($newsup_url); ?>'); ">
                                        <a class="link-div" href="<?php the_permalink(); ?>"> </a>
                                    <article class="bottom">
                                        <div class="mg-blog-category"> <?php newsup_post_categories(); ?> </div>
                                        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <?php newsup_post_meta(); ?>
                                    </article>
                                </div>
                        
                        
                            
                        <?php
    endwhile;
endif;
wp_reset_postdata();
?>
                        
                   
        </div>
       <?php }
    }

endif;

add_action('newsclick_action_front_page_editor_section', 'newsclick_frontpage_editor_post_section', 30);

//Front Page Banner
if (!function_exists('newsclick_front_page_banner_section')) :
    /**
     *
     * @since Newsclick
     *
     */
    function newsclick_front_page_banner_section()
    {
        if (is_front_page() || is_home()) {
        $newsup_enable_main_slider = newsup_get_option('show_main_news_section');
        $select_vertical_slider_news_category = newsup_get_option('select_vertical_slider_news_category');
        $vertical_slider_number_of_slides = newsup_get_option('vertical_slider_number_of_slides');
        $all_posts_vertical = newsup_get_posts($vertical_slider_number_of_slides, $select_vertical_slider_news_category);
        if ($newsup_enable_main_slider):  

            $main_banner_section_background_image = newsup_get_option('main_banner_section_background_image');
            $main_banner_section_background_image_url = wp_get_attachment_image_src($main_banner_section_background_image, 'full');
        if(!empty($main_banner_section_background_image)){ ?>
             <section class="mg-fea-area over" style="background-image:url('<?php echo esc_url($main_banner_section_background_image_url[0]); ?>');">
        <?php }else{ ?>
            <section class="mg-fea-area">
        <?php  } ?>
            <div class="overlay">
                <div class="container-fluid">
                    <div class="row">
                        
                        <div class="col-md-6 col-sm-6">
                            <div id="homemain"class="homemain owl-carousel mr-bot60 pd-r-10"> 
                                <?php newsup_get_block('list', 'banner'); ?>
                            </div>
                        </div> 
                        

                        <?php do_action('newsclick_action_front_page_editor_section');?>

                        <?php do_action('newsclick_action_banner_tabbed_posts');?>
                    </div>
                </div>
            </div>
        </section>
        <!--==/ Home Slider ==-->
        <?php endif; ?>
        <!-- end slider-section -->
        <?php }
    }
endif;
add_action('newsclick_action_front_page_main_section_1', 'newsclick_front_page_banner_section', 40);



//Banner Tabed Section
if (!function_exists('newsclick_banner_tabbed_posts')):
    /**
     *
     * @since Newsclick 1.0.0
     *
     */
    function newsclick_banner_tabbed_posts()
    {
        
            if(is_front_page() || is_home())
        {
        
            $number_of_posts_latest_news = '7';
            $newsup_latest_news_category = newsup_get_option('select_newsclick_latest_news_category');
            $newsup_all_posts_main = newsup_get_posts($number_of_posts_latest_news, $newsup_latest_news_category);         
        ?>
        <div class="small-list-post no-img-list col-md-3 col-sm-6">
            <ul>
                <?php if ($newsup_all_posts_main->have_posts()) :
                        while ($newsup_all_posts_main->have_posts()) : $newsup_all_posts_main->the_post();
                        global $post;
                         ?>
                <!-- small_post -->
                <li class="small-post clearfix">
                    <!-- // img-small-post -->
                    <div class="small-post-content">
                        <!-- small-post-content -->
                        <h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <?php newsup_post_meta(); ?>
                        <!-- // title_small_post -->
                    </div>
                    <!-- // small-post-content -->
                </li>
                <!-- // small_post -->
            <?php endwhile; endif; ?>
            </ul>
        </div>

     <?php  
    } }

endif;

add_action('newsclick_action_banner_tabbed_posts', 'newsclick_banner_tabbed_posts', 10);