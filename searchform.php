<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ) ?>">
    <label>
        <span class="screen-reader-text"><?php _e('Search for:', 'fw_campers'); ?></span>
        <input type="search" class="search-field" placeholder="Search …" value="<?php echo get_search_query() ?>" name="s">
    </label>
    <input type="submit" class="search-submit" value="<?php esc_attr_e('Search', 'fw_campers') ?>" />
</form>
