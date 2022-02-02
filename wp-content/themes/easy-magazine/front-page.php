<?php
/**
 * The template for displaying home page.
 * @package Easy Magazine
 */

if ( 'posts' != get_option( 'show_on_front' ) ){ 
    get_header(); ?>
    <?php $enabled_sections = easy_magazine_get_sections();
    if( is_array( $enabled_sections ) ) {
        foreach( $enabled_sections as $section ) {

            if( $section['id'] == 'breaking-news' ) { ?>
                <?php $enable_breaking_news_section = easy_magazine_get_option( 'enable_breaking_news_section' );
                if(true ==$enable_breaking_news_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

        <?php } elseif( $section['id'] == 'highlighted-posts' ) { ?>
                <?php $enable_highlighted_posts_section = easy_magazine_get_option( 'enable_highlighted_posts_section' );
                if(true ==$enable_highlighted_posts_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'featured-posts' ) { ?>
                <?php $enable_featured_posts_section = easy_magazine_get_option( 'enable_featured_posts_section' );
                if(true ==$enable_featured_posts_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

        <?php } elseif( $section['id'] == 'recent-posts' ) { ?>
                <?php $enable_recent_posts_section = easy_magazine_get_option( 'enable_recent_posts_section' );
                if(true ==$enable_recent_posts_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'popular-posts' ) { ?>
                <?php $enable_popular_posts_section = easy_magazine_get_option( 'enable_popular_posts_section' );
                if(true ==$enable_popular_posts_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'trending-posts' ) { ?>
                <?php $enable_trending_posts_section = easy_magazine_get_option( 'enable_trending_posts_section' );
                if(true ==$enable_trending_posts_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif;

            }
            elseif( ( $section['id'] == 'blog' ) ){ ?>
                <?php $enable_blog_section = easy_magazine_get_option( 'enable_blog_section' );
                if(true ==$enable_blog_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="blog-posts-wrapper page-section">
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
                <?php endif;
            }
        }
    }
    if( true == easy_magazine_get_option('enable_frontpage_content') ) { ?>
        <div class="wrapper page-section">
            <?php include( get_page_template() ); ?>
        </div>
    <?php }
    get_footer();
} 
elseif ('posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} 