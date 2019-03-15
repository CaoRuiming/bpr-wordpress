<?php get_header(); ?>

<div class="single-template content-wrapper container fluid">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="content col-lg-8">
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
        <div class="col-lg-2"></div>
    </div>
</div>

<?php get_footer(); ?>
