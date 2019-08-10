<?php

namespace BPRWP\Theme\App\Structure;

/*
|-----------------------------------------------------------
| Theme Templates Actions
|-----------------------------------------------------------
|
| This file purpose is to include your templates rendering
| actions hooks, which allows you to render specific
| partials at specific places of your theme.
|
*/

use function BPRWP\Theme\App\template;

/**
 * Renders post thumbnail by its formats.
 *
 * @see resources/templates/index.tpl.php
 */
function render_post_thumbnail()
{
    template(['partials/post/thumbnail', get_post_format()]);
}
add_action('theme/index/post/thumbnail', 'BPRWP\Theme\App\Structure\render_post_thumbnail');

/**
 * Renders empty post content where there is no posts.
 *
 * @see resources/templates/index.tpl.php
 */
function render_empty_content()
{
    template(['partials/index/content', 'none']);
}
add_action('theme/index/content/none', 'BPRWP\Theme\App\Structure\render_empty_content');

/**
 * Renders post contents by its formats.
 *
 * @see resources/templates/single.tpl.php
 */
function render_post_content()
{
    template(['partials/post/content', get_post_format()]);
}
add_action('theme/single/content', 'BPRWP\Theme\App\Structure\render_post_content');

/**
 * Renders sidebar content.
 *
 * @uses resources/templates/partials/sidebar.tpl.php
 * @see resources/templates/index.tpl.php
 * @see resources/templates/single.tpl.php
 */
function render_sidebar()
{
    get_sidebar();
}
add_action('theme/index/sidebar', 'BPRWP\Theme\App\Structure\render_sidebar');
add_action('theme/single/sidebar', 'BPRWP\Theme\App\Structure\render_sidebar');

/**
 * Renders [button] shortcode after homepage content.
 *
 * @uses resources/templates/shortcodes/button.tpl.php
 * @see resources/templates/partials/header.tpl.php
 */
function render_documentation_button()
{
    echo do_shortcode("[button href='https://github.com/tonik/tonik']Checkout documentation →[/button]");
}
add_action('theme/header/end', 'BPRWP\Theme\App\Structure\render_documentation_button');


// Front Page content

/**
 * Renders a block preview of a post. Meant to be used in a row on front page.
 *
 * @see resources/templates/single.tpl.php
 */
function render_post_row_block()
{
    template(['partials/post/row-block', get_post_format()]);
}
add_action('theme/single/row-block', 'BPRWP\Theme\App\Structure\render_post_row_block');

/**
 * Renders a block preview of a post. Meant to be used in a column on front page.
 *
 * @see resources/templates/single.tpl.php
 */
function render_post_col_block()
{
    template(['partials/post/col-block', get_post_format()]);
}
add_action('theme/single/col-block', 'BPRWP\Theme\App\Structure\render_post_col_block');

/**
 * Renders a block preview of a post. Meant to be used in a column on front page.
 *
 * @see resources/templates/single.tpl.php
 */
function render_post_col_block_small()
{
    template(['partials/post/col-block-small', get_post_format()]);
}
add_action('theme/single/col-block-small', 'BPRWP\Theme\App\Structure\render_post_col_block_small');
