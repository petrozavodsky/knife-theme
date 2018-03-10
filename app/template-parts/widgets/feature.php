<?php
/**
 * Feature widget template
 *
 * Feature is an important single post with feature meta
 *
 * @package knife-theme
 * @since 1.1
 */
?>

<a class="widget__link" href="<?php echo get_query_var('widget_link', get_permalink()); ?>" data-action="Feature click" data-label="<?php echo get_query_var('widget_slug', '(not set)') ?>">
	<div class="widget__item block">
		<?php
			printf(
				'<p class="widget__title">%s</p>',
				get_query_var('widget_item', get_the_title())
			);

			knife_theme_post_meta([
				'item' => '<img class="widget__sticker" src="%s">',
				'meta' => '_knife-sticker',
				'post_id' => get_query_var('widget_post', 0)
			]);
		?>

		<span class="icon icon--right"></span>
	</div>
</a>
