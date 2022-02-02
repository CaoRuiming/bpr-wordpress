<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage Magpaper
 * @since Magpaper 1.0.0
 */

$options = magpaper_get_theme_options();
$readmore = ! empty( $options['read_more_text'] ) ? $options['read_more_text'] : esc_html__( 'Read More', 'magpaper' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'grid-item' ); ?>>
    <div class="post-item-wrapper">
        <div class="entry-meta">
            <?php magpaper_posted_on(); 

                if( $options['hide_author'] === false ):
            ?>

            <span class="byline"><?php echo esc_html_e( 'by:', 'magpaper' ); ?>
                <span class="author vcard"><a class="url fn n" href="<?php esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a></span>
            </span><!-- .byline -->
        <?php endif; ?>
        </div><!-- .entry-meta -->

        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image">
                <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( get_the_post_thumbnail_url( '', 'medium_large' ) ); ?>" alt=""></a>
            </div><!-- .featured-image -->
        <?php endif; ?>

        <div class="entry-content">
            <p><?php the_excerpt(); ?></p>
        </div><!-- .entry-content -->

        <div class="read-more">
            <a href="<?php the_permalink(); ?>" class="more-link">
                <?php   
                    echo esc_html( $readmore );
                    echo magpaper_get_svg( array( 'icon' => 'right' ) );
                ?>
            </a>
        </div><!-- .read-more -->
    </div><!-- .post-item-wrapper -->
</article>
