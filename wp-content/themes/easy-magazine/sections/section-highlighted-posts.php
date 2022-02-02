<?php 
/**
 * Template part for displaying Highlighted Posts Section
 *
 *@package Easy Magazine
 */
    $highlighted_posts_content_type            = easy_magazine_get_option( 'highlighted_posts_content_type' );
    $number_of_highlighted_posts_items         = easy_magazine_get_option( 'number_of_highlighted_posts_items' );

    if( $highlighted_posts_content_type == 'highlighted_posts_page' ) :
        for( $i=1; $i<=$number_of_highlighted_posts_items; $i++ ) :
            $highlighted_posts_posts[] = easy_magazine_get_option( 'highlighted_posts_page_'.$i );
        endfor;  
    elseif( $highlighted_posts_content_type == 'highlighted_posts_post' ) :
        for( $i=1; $i<=$number_of_highlighted_posts_items; $i++ ) :
            $highlighted_posts_posts[] = easy_magazine_get_option( 'highlighted_posts_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( $highlighted_posts_content_type == 'highlighted_posts_page' ) : ?>
        <div class="section-content col-4 clear grid">
            <?php $args = array (
                'post_type'     => 'page',
                'posts_per_page' => absint( $number_of_highlighted_posts_items ),
                'post__in'      => $highlighted_posts_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; ?>             
                
                <article class="grid-item">
                    <div class="highlighted-post-item">
                        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                            <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                        </div><!-- .featured-image -->

                        <div class="entry-container">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <?php easy_magazine_posted_on(); ?>
                        </div><!-- .entry-container -->
                    </div><!-- .highlighted-post-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content col-4 clear grid">
            <?php $args = array (
                'post_type'     => 'post',
                'posts_per_page' => absint( $number_of_highlighted_posts_items ),
                'post__in'      => $highlighted_posts_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
            if ( $loop->have_posts() ) :
            $i=-1; $j=0; 
                while ($loop->have_posts()) : $loop->the_post(); $i++; $j++; ?>                
                
                <article class="grid-item">
                    <div class="highlighted-post-item">
                        <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                            <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                        </div><!-- .featured-image -->

                        <div class="entry-container">
                            <div class="entry-meta">
                                <?php easy_magazine_entry_meta(); ?>
                            </div><!-- .entry-meta -->

                            <header class="entry-header">
                                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                            </header>

                            <?php easy_magazine_posted_on(); ?>
                        </div><!-- .entry-container -->
                    </div><!-- .highlighted-post-item -->
                </article>

                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;