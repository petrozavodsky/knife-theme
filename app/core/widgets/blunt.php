<?php
/**
 * Blunt widget
 *
 * Posts with bluntmedia tag
 *
 * @package knife-theme
 * @since 1.7
 */


class Knife_Widget_Blunt extends WP_Widget {
    /**
     * Widget post types
     */
    private $post_type = ['post', 'quiz'];


    /**
     * Blunt posts tag
     */
    private $tag = 'bluntmedia';


    /**
     * Widget constructor
     */
    public function __construct() {
        $widget_ops = [
            'classname' => 'blunt',
            'description' => __('Ссылки на статьи с тегом тупого ножа', 'knife-theme'),
            'customize_selective_refresh' => true
        ];

        parent::__construct('knife_widget_blunt', __('[НОЖ] Тупой нож', 'knife-theme'), $widget_ops);
    }


    /**
     * Outputs the content of the widget.
     */
    public function widget($args, $instance) {
        $defaults = [
            'title' => '',
            'posts_per_page' => 8
        ];

        $instance = wp_parse_args((array) $instance, $defaults);

        $query = new WP_Query([
            'tag' => $this->tag,
            'post_type' => $this->post_type,
            'posts_per_page' => $instance['posts_per_page'],
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1
        ]);

        if($query->have_posts()) {
            echo $args['before_widget'];

            while($query->have_posts()) {
                $query->the_post();

                include(get_template_directory() . '/templates/widget-blunt.php');
            }

            wp_reset_query();

            echo $args['after_widget'];
        }
    }


    /**
     * Back-end widget form.
     */
    function form($instance) {
        $defaults = [
            'title' => '',
            'posts_per_page' => 8
        ];

        $instance = wp_parse_args((array) $instance, $defaults);

        // Widget title
        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr($this->get_field_id('title')),
            esc_attr($this->get_field_name('title')),
            __('Заголовок:', 'knife-theme'),
            esc_attr($instance['title'])
        );

        // Posts per page option
         printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr($this->get_field_id('posts_per_page')),
            esc_attr($this->get_field_name('posts_per_page')),
            __('Количество постов:', 'knife-theme'),
            esc_attr($instance['posts_per_page'])
        );
    }


    /**
     * Sanitize widget form values as they are saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['posts_per_page'] = absint($new_instance['posts_per_page']);
        $instance['title'] = sanitize_text_field($new_instance['title']);

        return $instance;
    }
}


/**
 * It is time to register widget
 */
add_action('widgets_init', function() {
    register_widget('Knife_Widget_Blunt');
});
