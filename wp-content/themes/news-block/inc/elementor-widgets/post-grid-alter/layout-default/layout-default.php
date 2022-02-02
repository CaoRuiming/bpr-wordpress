<?php
/**
 * Post Grid Alter block layout default - php render.
 */
?>
    <div class="bmm-post-wrapper">
        <?php
            $taxonomies = get_taxonomies( array( 'object_type' => array( $posttype ) ) );
            foreach( $taxonomies as $news_block_taxonomy ) {
                $taxonomy_name = $news_block_taxonomy;
                break;
            }
            
            $grid_alter_post_args = array(
                'post_type'     => esc_html( $posttype ),
                'posts_per_page' => esc_attr( $postCount ),
                'order'         => esc_html( $order ),
                'post_status'   => 'publish'
            );
            if( !empty( $postCategory ) && ( $posttype == 'post' ) ) {
                $grid_alter_post_args['category_name'] = implode( ',', $postCategory );
            } elseif( !empty( $postCategory ) ) {
                $grid_alter_post_args['tax_query'] = array(
                    array( 'taxonomy' => esc_html( $taxonomy_name ),
                            'terms' => array( implode( ',', $postCategory ) )
                ));
            }

            $grid_alter_post_query = new WP_Query( $grid_alter_post_args );
            if( !( $grid_alter_post_query->have_posts() ) ) {
                esc_html_e( 'No posts found', 'news-block' );
            }

            while( $grid_alter_post_query->have_posts() ) : $grid_alter_post_query->the_post();
                $postid = get_the_ID();
                $author_id  = get_post_field( 'post_author', $postid );
                $author_thumb = get_avatar_url( $author_id, ['size' => 48] );
                $author_url = get_author_posts_url( $author_id );

                if( $posttype == 'post' ) {
                    $categories = get_the_category( $postid );
                } else {
                    if( isset( $taxonomy_name ) ) {
                        $categories = get_the_terms( $postid, $taxonomy_name );
                    } else {
                        $categories = '';
                    }
                }

                $tags = get_the_tags( $postid );
                $comments_number = get_comments_number( $postid );
        ?>
                <article post-id="post-<?php echo esc_attr( $postid ); ?>" class="bmm-post" itemscope itemtype="<?php echo esc_url( 'http://schema.org/articleBody' ); ?>">
                    <?php
                        if( $categoryOption && $categories ) {
                            echo '<span class="bmm-post-cats-wrap bmm-post-meta-item">';
                            foreach( $categories as $category ) :
                                echo '<span class="bmm-post-cat bmm-cat-'.absint( $category->term_id ).'"><a href="'.esc_url( get_term_link( $category->term_id ) ).'" target="'.esc_html( $permalinkTarget ).'">'.esc_html( $category->name ).'</a></span>';
                            endforeach;
                            echo '</span>';
                        }

                        if( $tagsOption && $tags ) {
                            echo '<span class="bmm-post-tags-wrap bmm-post-meta-item">';
                            foreach( $tags as $customtag ) :
                                echo '<span class="bmm-post-tag"><a href="'.esc_url( get_tag_link( $customtag->term_id ) ).'" target="'.esc_html( $permalinkTarget ).'">'.esc_html( $customtag->name ).'</a></span>';
                            endforeach;
                            echo '</span>';
                        }
                    ?>
                        
                    <div class="title-wrap">
                        <?php

                            if( $titleOption ) :
                        ?>
                                <h2 class="bmm-post-title">
                                    <a href="<?php the_permalink(); ?>" target="<?php echo esc_html( $permalinkTarget ); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                        <?php
                            endif;

                            if( $authorOption ) {
                                echo '<span class="bmm-post-author-name bmm-post-meta-item" itemprop="author">';
                                    echo '<a href="'.esc_url( $author_url ).'" target="'.esc_html( $permalinkTarget ).'">';
                                        echo '<img src="' .esc_url( $author_thumb ). '"/>';
                                    echo '</a>';
                                echo '</span>';
                            }
                        ?>
                    </div><!-- .title-wrap -->

                    <?php
                        if( $contentOption === true ) {
                            echo '<div class="bmm-post-content" itemprop="description">';
                                if( $contentType == 'content' ) {
                                    the_content();
                                } else {
                                    the_excerpt();
                                }
                            echo '</div>';
                        }

                        if( $thumbOption ) :
                            if( has_post_thumbnail() ) {
                                $image_url = get_the_post_thumbnail_url( $postid, 'full' );
                            } else {
                                $image_url = NEWS_BLOCKS_DEFAULT_POST_IMAGE;
                            }
                    ?>
                            <div class="bmm-post-thumb">
                                <a href="<?php the_permalink(); ?>" target="<?php echo esc_html( $permalinkTarget ); ?>">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>"/>
                                </a>
                            </div>
                    <?php
                        endif;
                    ?>

                    <div class="bmm-post-meta">
                        <?php
                            if( $dateOption ) {
                                echo '<span class="bmm-post-date bmm-post-meta-item" itemprop="datePublished">';
                                    echo '<a href="'.esc_url( get_the_permalink() ).'" target="'.esc_html( $permalinkTarget ).'">'.get_the_date().'</a>';
                                echo '</span>';
                            }

                            if( $commentOption ) {
                                echo '<span class="bmm-post-comments-wrap bmm-post-meta-item">';
                                    echo '<a href="'.esc_url( get_the_permalink() ).'/#comments" target="'.esc_html( $permalinkTarget ).'">';
                                        echo esc_attr( $comments_number );
                                        echo '<span class="bmm-comment-txt">'.esc_html__( "Comments", "news-block" ).'</span>';
                                    echo '</a>';
                                echo '</span>';
                            }
                        ?>
                    </div>
                    <?php
                        if( $buttonOption && !empty( $buttonLabel ) ) {
                            echo '<div class="bmm-read-more"><a href="'.esc_url( get_the_permalink() ).'" target="'.esc_html( $permalinkTarget ).'">'.esc_html( $buttonLabel ). '</a></div>';
                        }
                    ?>
                </article>
        <?php
            endwhile;
            wp_reset_postdata();
        ?>
    </div>