<?php
/**
 * Details widget
 *
 * Recent posts widget showing as bright links
 *
 * @package knife-theme
 * @since 1.1
 */


class Knife_Details_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = [
            'classname' => 'details',
            'description' => __('Выводит список контрастных ссылок на посты по критерию.', 'knife-theme'),
			'customize_selective_refresh' => true
        ];

        parent::__construct('knife_theme_details', __('[НОЖ] Микроформаты', 'knife-theme'), $widget_ops);
    }


    /**
     * Outputs the content of the widget
     */
    public function widget($args, $instance) {
		$defaults = ['title' => '', 'posts_per_page' => 10, 'cat' => 0];
		$instance = wp_parse_args((array) $instance, $defaults);

		extract($instance);

		// Check cache before creating WP_Query object
		$q = get_transient($this->id);

		if($q === false) :

			$q = new WP_Query([
				'cat' => $cat,
				'posts_per_page' => $posts_per_page,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
			]);

			set_transient($this->id, $q, 24 * HOUR_IN_SECONDS);

		endif;


		if($q->have_posts()) :
			echo $args['before_widget'];

 			while($q->have_posts()) : $q->the_post();

				get_template_part('template-parts/widgets/details');

 			endwhile;

			wp_reset_query();

			echo $args['after_widget'];
		endif;
    }


    /**
     * Outputs the options form on admin
     */
    function form($instance) {
		$defaults = ['title' => '', 'posts_per_page' => 10, 'cat' => 0];
		$instance = wp_parse_args((array) $instance, $defaults);

		$dropdown = wp_dropdown_categories([
 			'id' => esc_attr($this->get_field_id('cat')),
			'name' => esc_attr($this->get_field_name('cat')),
			'selected' => esc_attr($instance['cat']),
			'class' => 'widefat',
			'echo' => false,
		]);

		printf(
			'<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
			esc_attr($this->get_field_id('title')),
			esc_attr($this->get_field_name('title')),
			__('Заголовок:', 'knife-theme'),
			esc_attr($instance['title'])
		);

 		printf(
			'<p><label for="%1$s">%3$s</label><input class="widefat" id="%1$s" name="%2$s" type="text" value="%4$s"></p>',
			esc_attr($this->get_field_id('posts_per_page')),
			esc_attr($this->get_field_name('posts_per_page')),
			__('Количество постов:', 'knife-theme'),
			esc_attr($instance['posts_per_page'])
		);

		printf(
			'<p><label for="%1$s">%2$s</label>%3$s</p>',
			esc_attr($this->get_field_id('cat')),
			__('Рубрика записей:', 'knife-theme'),
			$dropdown
		);
	}


    /**
     * Processing widget options on save
     */
    public function update($new_instance, $old_instance) {
		$instance = $old_instance;

 		$instance['cat'] = (int) $new_instance['cat'];
		$instance['posts_per_page'] = (int) $new_instance['posts_per_page'];
		$instance['title'] = sanitize_text_field($new_instance['title']);

 		$this->remove_cache();

        return $instance;
    }


	/**
	 * Remove transient on widget update
	 */
 	private function remove_cache() {
		delete_transient($this->id);
	}
}


/**
 * It is time to register widget
 */
add_action('widgets_init', function() {
	register_widget('Knife_Details_Widget');
});