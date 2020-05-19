<?php
if ( function_exists('dynamic_sidebar') ) {
    if (is_active_sidebar('shop-sidebar')) {
        ?>
        <div class="sidebar woo-sidebar">
            <div class="woo-inner-sidebar-box">
                <?php dynamic_sidebar('shop-sidebar'); ?>
            </div>
        </div><!--/sidebar-->
        <?php
    }
}
