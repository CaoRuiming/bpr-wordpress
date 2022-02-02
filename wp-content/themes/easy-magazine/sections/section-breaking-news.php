<?php 
/**
 * Template part for displaying Breaking News Section
 *
 *@package Easy Magazine
 */
    $breaking_news_section_title           = easy_magazine_get_option( 'breaking_news_section_title' );
    $breaking_news_content_type            = easy_magazine_get_option( 'breaking_news_content_type' );
    $number_of_breaking_news_items         = easy_magazine_get_option( 'number_of_breaking_news_items' );

    if( $breaking_news_content_type == 'breaking_news_page' ) :
        for( $i=1; $i<=$number_of_breaking_news_items; $i++ ) :
            $breaking_news_posts[] = easy_magazine_get_option( 'breaking_news_page_'.$i );
        endfor;  
    elseif( $breaking_news_content_type == 'breaking_news_post' ) :
        for( $i=1; $i<=$number_of_breaking_news_items; $i++ ) :
            $breaking_news_posts[] = easy_magazine_get_option( 'breaking_news_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($breaking_news_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($breaking_news_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $breaking_news_content_type == 'breaking_news_page' ) : ?>
        <div class="section-content" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": false, "arrows":true, "autoplay": false, "fade": false, "vertical": true }'>
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_breaking_news_items ),
                'post__in'      => $breaking_news_posts,
                'orderby'       =>'post__in',
            );        

            $loop = new WP_Query($args);   

            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 

                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; 
                $class='';
                if ($i==0) {
                    $class='display-block';
                } else{
                    $class='display-none';}
                ?>             
                
                <article class="slick-item <?php echo esc_attr($class); ?>">
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    </header>
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": false, "arrows":true, "autoplay": false, "fade": false, "vertical": true }'>
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_breaking_news_items ),
                'post__in'      => $breaking_news_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; 
                $class='';
                if ($i==0) {
                    $class='display-block';
                } else{
                    $class='display-none';}
                ?>                
                
                <article class="slick-item <?php echo esc_attr($class); ?>">
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    </header>
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;