<?php get_header(); ?>

<div class="single-template content-wrapper container fluid">
    <div class="row">
        <div class="content col-lg-9">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post() ?>
                    <?php
                        /**
                         * Functions hooked into `theme/single/content` action.
                         *
                         * @hooked BPRWP\Theme\App\Structure\render_post_content - 10
                         */
                        do_action('theme/single/content');
                    ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <div class="sidebar col-lg-3">
            <?php if (apply_filters('theme/single/sidebar/visibility', true)) : ?>
                <?php
                    /**
                     * Functions hooked into `theme/single/sidebar` action.
                     *
                     * @hooked BPRWP\Theme\App\Structure\render_sidebar - 10
                     */
                    do_action('theme/single/sidebar');
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
