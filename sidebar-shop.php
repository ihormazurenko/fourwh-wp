<?php
if ( function_exists('dynamic_sidebar') ) {
    if (is_active_sidebar('shop-sidebar')) {
        ?>
        <div class="sidebar">
            <?php dynamic_sidebar('shop-sidebar'); ?>
        </div><!--/sidebar-->
        <?php
    }
}
