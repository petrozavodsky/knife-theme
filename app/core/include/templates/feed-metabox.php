<div id="knife-feed-box">
    <?php
        $zen_publish = get_post_meta(get_the_ID(), self::$zen_publish, true);
        $zen_exclude = get_post_meta(get_the_ID(), self::$zen_exclude, true);

        $zen_date = get_the_date("Y-m-d H:i:s", get_the_ID());

        if(strlen($zen_publish) > 0) {
            $zen_date = get_date_from_gmt($zen_publish);
        }

        printf(
            '<p><label><input type="checkbox" name="%1$s" class="checkbox"%3$s> %2$s</label></p>',
            esc_attr(self::$zen_exclude),
            __('Исключить из Яндекс.Дзен', 'knife-theme'),
            checked($zen_exclude, 1, false)
        );
    ?>

    <div style="line-height: 20px;">
        <span>
            <span class="dashicons dashicons-calendar" style="color:#82878c"></span>
            <?php _e('Републикация:', 'knife-theme'); ?>
        </span>

        <b id="knife-feed-display" class="publish-time">
            <?php echo date("d.m.Y G:i", strtotime($zen_date)); ?>
        </b>
    </div>

    <div style="display: flex; align-items: center; margin-top: 10px;">
        <?php
            printf(
                '<a href="#current-time" class="button" data-display="%s" data-publish="%s">%s</a>',
                date_i18n("d.m.Y G:i"),
                current_time('mysql', 1),
                __('Текущее время', 'knife-theme')
            );

            printf(
                '<a href="#reset-time" style="margin-left: 10px;" data-display="%s" data-publish="">%s</a>',
                get_the_date("d.m.Y G:i", get_the_ID()),
                __('Сбросить', 'knife-theme')
            );
        ?>
    </div>

    <?php
        printf(
            '<input id="knife-feed-publish" type="hidden" name="%1$s" value="%2$s">',
            esc_attr(self::$zen_publish),
            esc_attr($zen_publish)
        );

        wp_nonce_field('metabox', self::$metabox_nonce);
    ?>
</div>

