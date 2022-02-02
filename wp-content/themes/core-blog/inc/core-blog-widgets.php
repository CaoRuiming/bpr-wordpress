<?php
class Core_Blog_Widget_style extends WP_Widget
{

    public function __construct()
    {
        parent::__construct('Core_Blog_Widget_style_1', // Base ID
        'Core Blog Widget', // Name
        array(
            'description' => __('User Details', 'core-blog') ,
        ) // Args
        );

    }
    public function form($instance)
    {
        // outputs the options form in the admin
        $defaults = array(
            'posts_style' => 'posts',
            'num_posts' => '3',
            'posts_title' => ''
        );
        $instance = wp_parse_args((array)$instance, $defaults);
        $num_posts = !empty($instance['num_posts']) ? absint($instance['num_posts']) : 3;
        $posts_title = !empty($instance['posts_title']) ? esc_attr($instance['posts_title']) : 'Latest Posts';
        $category = !empty($instance['cat']) ? $instance['cat'] : '';
        $category_type = !empty($instance['category_type']) ? $instance['category_type'] : '';
?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('posts_style')); ?>"> <?php echo esc_html__('Posts Style:', 'core-blog') ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_style')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_style')); ?>">
                <option value="posts1" <?php selected($instance['posts_style'], 'posts1'); ?>> <?php echo esc_html__('Style 1', 'core-blog') ?> </option>
                <option value="posts2" <?php selected($instance['posts_style'], 'posts2'); ?>> <?php echo esc_html__('Style 2', 'core-blog'); ?> </option>
                 <option value="posts3" <?php selected($instance['posts_style'], 'posts3'); ?>> <?php echo esc_html__('Style 3', 'core-blog'); ?> </option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('cat')); ?>"><?php esc_html_e('Category:', 'core-blog'); ?></label> 
            <?php wp_dropdown_categories(Array(
            'orderby' => 'ID',
            'order' => 'ASC',
            'show_count' => 1,
            'hide_empty' => 1,
            'hide_if_empty' => true,
            'echo' => 1,
            'selected' => $category,
            'hierarchical' => 1,
            'name' => $this->get_field_name('cat') ,
            'id' => $this->get_field_id('cat') ,
            'taxonomy' => 'category',
        )); ?>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num_posts')); ?>"><?php echo esc_html__('Number of posts:', 'core-blog'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('num_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('num_posts')); ?>" type="text" value="<?php echo esc_attr($num_posts); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('posts_title')); ?>"><?php echo esc_html__('Title:', 'core-blog'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_title')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_title')); ?>" type="text" value="<?php echo esc_attr($posts_title); ?>">
        </p>
        <?php
    }
    public function widget($args, $instance)
    {
        // outputs the content of the widget
        extract($args);
        $posts_style = !empty($instance['posts_style']) ? esc_attr($instance['posts_style']) : 'posts';
        $num_posts = !empty($instance['num_posts']) ? absint($instance['num_posts']) : 3;
        $posts_title = !empty($instance['posts_title']) ? esc_attr($instance['posts_title']) : 'Latest Posts';
        $category = !empty($instance['cat']) ? $instance['cat'] : '';
        $category_type = !empty($instance['category_type']) ? $instance['category_type'] : '';

        $post_args = array(
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $num_posts,
            'post_status' => 'publish',
            'orderby' => 'comment_count',
            'order' => 'asc'
        );

        if ($category) $post_args['cat'] = $category;

        $qry = new WP_Query($post_args);

        echo $before_widget;
?>
       
            <h3><?php echo esc_html($posts_title); ?></h3>
            <?php
        /*
         $popular = new WP_Query( $args );*/
        if ($qry->have_posts()):
            while ($qry->have_posts()):
                $qry->the_post();
                if ($posts_style == 'posts1')
                { ?>
                <div class="mini-post">
                    <header>
                        <?php
                    printf('<h3><a href="%1$s" title="%2$s">%3$s</a></h3>', esc_url(get_permalink()) , esc_attr(get_the_title()) , wp_trim_words(get_the_title() , 5));

                    printf('<time class="published">%1$s</time>', esc_html(get_the_time(get_option('date_format'))));

                    printf(get_avatar(get_the_author_meta('email') , '30'));
?>
                    </header>

                    <?php
                    if (has_post_thumbnail())
                    {

                        the_post_thumbnail();

                    }

?>
                </div>
                <?php
                }
                elseif ($posts_style == 'posts2')
                {
?>
                    <div class="single-widget_style_2">
                        <div class="post-image">
                            <?php
                    if (has_post_thumbnail())
                    {

                        the_post_thumbnail();

                    }

?>
                        </div>
                        <div class="post-description">
                            <div class="post-title">
                            <?php
                    printf('<h5><a href="%1$s" title="%2$s">%3$s</a></h5>', esc_url(get_permalink()) , esc_attr(get_the_title()) , wp_trim_words(get_the_title() , 5));
?>
                            </div>
                            <ul>
                                <?php
                    printf('<li class="date">%1$s</li>', esc_html(get_the_time(get_option('date_format'))));
?>
                            </ul>
                        </div>
                    </div>

                    <?php
                }
                elseif ($posts_style == 'posts3')
                {
?>

                <div class="single-widget_style_3">
                    <div class="post-image">
                    <?php
                    if (has_post_thumbnail())
                    {

                        the_post_thumbnail();

                    }

?>
                   </div>
                    <div class="post-description">
                        <div class="post-title">
                           <?php
                    printf('<h5><a href="%1$s" title="%2$s">%3$s</a></h5>', esc_url(get_permalink()) , esc_attr(get_the_title()) , wp_trim_words(get_the_title() , 5));
?>
                        </div>
                        
                    </div>
                </div>

            <?php
                }
            endwhile;
            wp_reset_postdata();
        endif;

        echo $after_widget;
    }
    public function update($new_instance, $old_instance)
    {
        // processes widget options to be saved
        $instance = $old_instance;
        $instance['num_posts'] = absint($new_instance['num_posts']);
        $instance['posts_style'] = strip_tags($new_instance['posts_style']);
        $instance['posts_title'] = sanitize_text_field($new_instance['posts_title']);
        $instance['cat'] = !empty($new_instance['cat']) ? sanitize_text_field($new_instance['cat']) : '';
        $instance['category_type'] = !empty($new_instance['category_type']) ? sanitize_text_field($new_instance['category_type']) : '';
        return $instance;

    }
}