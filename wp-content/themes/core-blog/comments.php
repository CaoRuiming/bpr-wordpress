<?php
if (post_password_required())
{
    return;
}
?>
<div id="comments" class="comments-area">
	<?php
// You can start editing here -- including this comment!
if (have_comments()):
?>
		<h2 class="comments-title">
			<?php
    $core_blog_comment_count = get_comments_number();
    if ('1' === $core_blog_comment_count)
    {
        printf(
        /* translators: 1: title. */
        esc_html__('Comments', 'core-blog') , '<span>' . wp_kses_post(get_the_title()) . '</span>');
    }
    else
    {
        printf(
        /* translators: 1: comment count number, 2: title. */
        esc_html(_nx('%1$s Comments', '%1$s Comments', $core_blog_comment_count, 'comments title', 'core-blog')) , number_format_i18n($core_blog_comment_count) , // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        '<span>' . wp_kses_post(get_the_title()) . '</span>');
    }
?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
    wp_list_comments(array(
        'style' => 'ol',
        'short_ping' => true,
    ));
?>
		</ol><!-- .comment-list -->

		<?php
    the_comments_navigation();

    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open()):
?>
			<p class="no-comments"><?php esc_html__('Comments are closed.', 'core-blog'); ?></p>
			<?php
    endif;

endif; // Check for have_comments().
comment_form();
?>
</div><!-- #comments -->