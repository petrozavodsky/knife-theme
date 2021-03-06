<?php
/**
 * Informer widget
 *
 * Informer line with optional emoji and custom colors
 *
 * @package knife-theme
 * @since 1.1
 * @version 1.7
 */


class Knife_Widget_Informer extends WP_Widget {
    public function __construct() {
        $widget_ops = [
            'classname' => 'informer',
            'description' => __('Выводит информер на всю ширину со стикером', 'knife-theme'),
            'customize_selective_refresh' => true
        ];

        parent::__construct('knife_widget_informer', __('[НОЖ] Информер', 'knife-theme'), $widget_ops);
    }


    /**
     * Outputs the content of the widget.
     */
    public function widget($args, $instance) {
        $defaults = [
            'title' => '',
            'link' => '',
            'emoji' => '',
            'color' => '#000000',
            'background' => '#ffe64e'
        ];

        $instance = wp_parse_args((array) $instance, $defaults);

        if(!empty($instance['title']) && !empty($instance['link'])) {
            echo $args['before_widget'];

            $post_id = url_to_postid($instance['link']);
            $options = $this->get_attributes($instance, $post_id);

            include(get_template_directory() . '/templates/widget-informer.php');

            echo $args['after_widget'];
        }
    }


    /**
     * Sanitize widget form values as they are saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['link'] = esc_url($new_instance['link']);
        $instance['emoji'] = wp_encode_emoji($new_instance['emoji']);
        $instance['color'] = sanitize_hex_color($new_instance['color']);
        $instance['background'] = sanitize_hex_color($new_instance['background']);

        return $instance;
    }


    /**
     * Back-end widget form.
     */
    function form($instance) {
        $defaults = [
            'title' => '',
            'link' => '',
            'emoji' => '',
            'color' => '#000000',
            'background' => '#ffe64e'
        ];

        $instance = wp_parse_args((array) $instance, $defaults);

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"><small>%5$s</small></p>',
            esc_attr($this->get_field_id('title')),
            esc_attr($this->get_field_name('title')),
            __('Заголовок информера', 'knife-theme'),
            esc_attr($instance['title']),
             __('Отобразится на странице', 'knife-theme')
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr($this->get_field_id('link')),
            esc_attr($this->get_field_name('link')),
            __('Ссылка с информера', 'knife-theme'),
            esc_attr($instance['link'])
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr($this->get_field_id('emoji')),
            esc_attr($this->get_field_name('emoji')),
            __('Эмодзи', 'knife-theme'),
            esc_attr($instance['emoji'])
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="color-picker" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr($this->get_field_id('color')),
            esc_attr($this->get_field_name('color')),
            __('Цвет текста', 'knife-theme'),
            esc_attr($instance['color'])
        );

        printf(
            '<p><label for="%1$s">%3$s</label><input class="color-picker" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
            esc_attr($this->get_field_id('background')),
            esc_attr($this->get_field_name('background')),
            __('Цвет фона', 'knife-theme'),
            esc_attr($instance['background'])
        );
    }


    /**
     * Generate link attributes
     */
    private function get_attributes($instance, $post_id, $attributes = []) {
        $options = [
            'href' => esc_url($instance['link']),
            'target' => '_blank',
            'data-action' => __('Informer click', 'knife-theme'),
            'data-label' => $instance['link']
        ];

        $options['style'] = implode('; ', [
            'color: ' . $instance['color'],
            'background-color: ' . $instance['background']
        ]);

        if($post_id > 0) {
            unset($options['target']);
            $options['data-label'] = get_post_field('post_name', $post_id);
        }

        foreach($options as $key => $value) {
            $attributes[] = $key . '="' . esc_attr($value) . '"';
        }

        return $attributes;
    }

}


/**
 * It is time to register widget
 */
add_action('widgets_init', function() {
    register_widget('Knife_Widget_Informer');
});
