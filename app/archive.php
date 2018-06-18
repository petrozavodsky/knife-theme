<?php
/**
 * The template for displaying archive pages
 *
 * @package knife-theme
 * @since 1.1
 */

get_header(); ?>

<main class="wrap">

    <?php if(have_posts()) : ?>
    <div class="caption block">
        <?php
            // archive title
            the_archive_title();

            // archive description
            the_archive_description();
        ?>
    </div>
    <?php endif; ?>


    <div class="content block">
    <?php
        if(have_posts()) :

            while (have_posts()) : the_post();

                knife_theme_widget_template([
                    'before' => '<div class="widget widget-%s">',
                    'after' => '</div>'
                ]);

            endwhile;

        else:

            // Include "no posts found" template
            get_template_part('template-parts/content/post', 'none');

        endif;
    ?>
    </div>


    <?php if(get_next_posts_link()) : ?>
    <div class="nav block">
        <?php next_posts_link(__('Больше статей', 'knife-theme')); ?>
    </div>
    <?php endif; ?>

</main>


<?php

get_footer();
