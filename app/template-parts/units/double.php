<?php
/**
 * Unit template with 1/2 screen width
 *
 * @package knife-theme
 * @since 1.1
 */
?>

<article class="unit unit--double">
	<?php echo knife_theme_category_link('unit__head') ?>

	<a class="unit__link" href="<?php the_permalink(); ?>">
		<div class="unit__image">
			<?php the_post_thumbnail('double-thumbnail', ['class' => 'unit__image-thumbnail']); ?>
		</div>

		<footer class="unit__footer">
			<?php the_title('<p class="unit__title">', '</p>'); ?>

			<div class="unit__meta">
				<time class="unit__meta-item" datetime="<?php the_time(DATE_W3C); ?>"><?php echo get_the_date(); ?></time>

 				<span class="unit__meta-item"><?php knife_theme_authors(); ?></span>
			</div>
		</footer>
	</a>
</article>