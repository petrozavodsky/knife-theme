<?php
/**
 * Script widget
 *
 * Widget custom html code
 *
 * @package knife-theme
 * @since 1.3
 * @version 1.5
 */


class Knife_Widget_Script extends WP_Widget {

    /**
     * Sets up a new custom script widget
     */
    public function __construct() {
        $widget_ops = [
            'classname' => 'script',
            'description' => __('Произвольный HTML-код для баннеров и скриптов.', 'knife-theme'),
            'customize_selective_refresh' => true
        ];

        $control_ops = [
            'width'  => 400,
            'height' => 350
        ];

        parent::__construct('knife_theme_script', __('[НОЖ] HTML-код', 'knife-theme'), $widget_ops, $control_ops);
    }


    /**
     * Outputs the content of the widget.
     */
    public function widget($args, $instance) {
        $defaults = [
            'title'   => '',
            'content' => ''
        ];

        $instance = wp_parse_args((array) $instance, $defaults);

        echo $args['before_widget'] . $instance['content'] . $args['after_widget'];
    }


    /**
     * Back-end widget form.
     */
    function form($instance) {
        $defaults = [
            'title'   => '',
            'content' => ''
        ];

        $instance = wp_parse_args((array) $instance, $defaults);

        // Widget title
        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr($this->get_field_id('title')),
            esc_attr($this->get_field_name('title')),
            __('Заголовок:', 'knife-theme'),
            esc_attr($instance['title']),
            __('Не будет отображаться на странице', 'knife-theme')
        );

        // Widget content
        printf(
            '<p><label for="%1$s">%3$s</label><textarea class="widefat" id="%1$s" name="%2$s" rows="10">%4$s</textarea></p>',
            esc_attr($this->get_field_id('content')),
            esc_attr($this->get_field_name('content')),
            __('HTML-код:', 'knife-theme'),
            esc_attr($instance['content'])
        );
    }


    /**
     * Sanitize widget form values as they are saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);

        if(current_user_can('unfiltered_html')) {
            $instance['content'] = $new_instance['content'];
        } else {
            $instance['content'] = wp_kses_post($new_instance['content']);
        }

        return $instance;
    }
}


/**
 * It is time to register widget
 */
add_action('widgets_init', function() {
    register_widget('Knife_Widget_Script');
});
