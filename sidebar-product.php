<?php
if ( function_exists('dynamic_sidebar') ) {
    if (is_active_sidebar('product-sidebar')) {
        ?>
        <div class="sidebar woo-sidebar">
            <div class="woo-inner-sidebar-box">
                <?php dynamic_sidebar('product-sidebar'); ?>
            </div>
        </div><!--/sidebar-->
        <?php
    }
}
