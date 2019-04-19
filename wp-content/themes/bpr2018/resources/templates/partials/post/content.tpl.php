<article>
    <div class="row">
        <div class="col-lg-1"></div> <!-- Padding -->

        <div class="content col-lg-10">
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
        <div class="col-lg-1">
            Part of some issue
        </div>

        <div class="content col-lg-10">
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
                                echo '<div class="tag">'. $tag->name . '</div>';
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
            </div>
        </div>

        <div class="col-lg-1 post-category">
            <?php the_category(); ?>
        </div>
    </div>
</article>