<ul class="comment-list">
  <?php comment_form(); ?>
  <?php
    wp_list_comments( array(
      'style' => 'ul',
      'short_ping'  => true,
      'avatar_size' => 50,
    ) );
  ?>
</ul>