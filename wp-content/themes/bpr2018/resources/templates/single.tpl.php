<?php get_header(); ?>

<div class="single-template content-wrapper container-fluid">
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

<?php get_footer(); ?>
