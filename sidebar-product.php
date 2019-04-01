<?php
if ( function_exists('dynamic_sidebar') ) {
    if (is_active_sidebar('product-sidebar')) {
        ?>
        <div class="sidebar">
            <?php dynamic_sidebar('product-sidebar'); ?>
        </div><!--/sidebar-->
        <?php
    }
}
