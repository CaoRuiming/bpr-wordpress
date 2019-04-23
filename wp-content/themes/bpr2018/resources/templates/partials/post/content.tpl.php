<article>
    <div class="row">
        <div class="col-lg-2"></div> <!-- Padding -->

        <div class="content col-lg-8">
            <a id="article-top" name="article-top"></a> <!-- For back to top -->
            <h1><?php the_title(); ?></h1>

            <div class="byline">
                <a href="<?php get_author_posts_url(get_the_author_meta('ID')); ?>">
                    <?php the_author(); ?>
                </a> | <?php the_date(); ?>
            </div>

            <?php 
            $url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
            if ($url):
            ?>
                <img class="featured-image" src="<?php echo $url; ?>">
            <?php endif; ?>

            <div class="hline"></div>
        </div>

        <div class="col-lg-1"></div> <!-- Padding -->
    </div>

    <div class="row">
        <div class="col-lg-2">
            <!-- Part of some issue -->
        </div>

        <div class="content col-lg-8">
            <p><?php the_content(); ?></p>

            <div class="back-to-top">
                <a href="#article-top">Back to Top</a>
            </div>

            <div class="article-bottom-wrapper container-fluid">
                <div class="article-bottom row">
                    <div class="tags-and-author col-sm-9">
                        <div class="article-tags">
                            <?php 
                            $tags = wp_get_post_tags(get_the_ID());
                            foreach($tags as $tag) {
                                echo '<div class="tag">'.$tag->name.'</div>';
                            }
                            ?>
                        </div>

                        <div class="about-author">
                            <p class="about-author-title">About the Author</p>
                            <p class="about-author-bio">
                                <?php echo get_the_author_meta('user_description'); ?>
                            </p>
                        </div>
                    </div>

                    <div class="social-and-sharing col-sm-3"></div>
                </div>
                <div class="row">
                    <p class="suggested-articles-title">SUGGESTED ARTICLES</p>
                </div>
            </div>
        </div>

        <div class="col-lg-2 post-category">
            <?php the_category(); ?>
        </div>
    </div>
    <div class="row suggested-articles">
        <?php 
        $suggested  = new WP_Query(array(
            'posts_per_page' => 3,
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        ));
        while ($suggested->have_posts()): ?>
            <?php
            $post = $suggested->the_post();
            $pic_url = get_the_post_thumbnail_url();
            ?>
            <div class="col-md-4 suggested-article">
                <a href="<?php echo get_permalink(); ?>">
                    <div
                        class="suggested-img"
                        style="background-image: url(<?php echo $pic_url; ?>);">
                    </div>
                </a>

                <?php the_category(); ?>
                
                <p class="suggested-title">
                    <a href="<?php echo get_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </p>

                <div class="suggested-author-date">
                    <?php the_author(); ?> | <?php the_date(); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Script to enable pull quotes on alternating sides -->
    <script>
        (function() {
            var highlightedItems = document.querySelectorAll(".pullquote");
            highlightedItems.forEach(function(el, index) {
                el.className = "pullquote " + ((index % 2) ? "right" : "left");
            });
        })()
    </script>
</article>