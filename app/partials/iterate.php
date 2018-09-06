<?php
/**
 * Default archive loop partial template
 *
 * @package knife-theme
 * @since 1.1
 * @version 1.4
 */
?>

<article class="unit unit--<?php echo get_query_var('widget_size', 'triple'); ?>">
    <div class="unit__inner">
        <?php
            the_info(
                '<div class="unit__head">', '</div>',
                ['tag']
            );
        ?>

        <div class="unit__image">
            <?php
                the_post_thumbnail(
                    get_query_var('widget_size', 'triple'),
                    ['class' => 'unit__image-thumbnail']
                );
            ?>
        </div>

        <div class="unit__content">
            <?php
                printf(
                    '<a class="unit__content-link" href="%1$s">%2$s</a>',
                    esc_html(get_permalink()),
                    get_the_title()
                );

                the_info(
                    '<div class="unit__content-meta meta">', '</div>',
                    ['author', 'date']
                );
            ?>
        </div>
    </div>
</article>