<?php 
/**
 * Template part for displaying Trending Posts Section
 *
 *@package Easy Magazine
 */
    $trending_posts_section_title           = easy_magazine_get_option( 'trending_posts_section_title' );
    $trending_posts_content_type            = easy_magazine_get_option( 'trending_posts_content_type' );
    $number_of_trending_posts_items         = easy_magazine_get_option( 'number_of_trending_posts_items' );

    if( $trending_posts_content_type == 'trending_posts_page' ) :
        for( $i=1; $i<=$number_of_trending_posts_items; $i++ ) :
            $trending_posts_posts[] = easy_magazine_get_option( 'trending_posts_page_'.$i );
        endfor;  
    elseif( $trending_posts_content_type == 'trending_posts_post' ) :
        for( $i=1; $i<=$number_of_trending_posts_items; $i++ ) :
            $trending_posts_posts[] = easy_magazine_get_option( 'trending_posts_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($trending_posts_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($trending_posts_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $trending_posts_content_type == 'trending_posts_page' ) : ?>
        <div class="section-content" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": false, "arrows":true, "autoplay": false, "fade": false }'>
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_trending_posts_items ),
                'post__in'      => $trending_posts_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; ?>             
                
                <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                    <div class="trending-post-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                                <?php easy_magazine_posted_on(); ?>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <div class="entry-content">
                                <?php
                                    $excerpt = easy_magazine_the_excerpt( 20 );
                                    echo wp_kses_post( wpautop( $excerpt ) );
                                ?>
                            </div><!-- .entry-content -->
                        </div><!-- .entry-container -->
                    </div><!-- .trending-post-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": false, "arrows":true, "autoplay": false, "fade": false }'>
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_trending_posts_items ),
                'post__in'      => $trending_posts_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; ?>                
                
                <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                    <div class="trending-post-item">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                                <?php easy_magazine_posted_on(); ?>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <div class="entry-meta">
                                <?php easy_magazine_entry_meta(); ?>
                            </div><!-- .entry-meta -->

                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <div class="entry-content">
                                <?php
                                    $excerpt = easy_magazine_the_excerpt( 20 );
                                    echo wp_kses_post( wpautop( $excerpt ) );
                                ?>
                            </div><!-- .entry-content -->
                        </div><!-- .entry-container -->
                    </div><!-- .trending-post-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;