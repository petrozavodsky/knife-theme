<?php
/**
 * Single template sidebar
 *
 * Show last news and related posts
 *
 * @package knife-theme
 * @since 1.1
 */
?>

<?php if(is_active_sidebar('knife-inner-sidebar')) : ?>
<aside class="sidebar">
    <?php dynamic_sidebar('knife-inner-sidebar'); ?>
</aside>
<?php endif; ?>
