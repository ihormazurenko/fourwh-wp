<?php
    $title = get_the_title();
    $url = get_permalink();
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_class = '';
    $thumbnail_url = '';

    if( ! is_null( $thumbnail_id ) ) {
        $thumbnail_arr = image_downsize($thumbnail_id, 'full');
        $thumbnail_url = $thumbnail_arr[0];
        $thumbnail_class = ($thumbnail_arr[1] > $thumbnail_arr[2]) ? 'wider' : '';
    }
?>
<li>
    <a href="<?php echo $url; ?>" title="<?php echo esc_attr($title); ?>">
        <div class="related-box">
            <div class="related-img-wrap centered-img <?php echo $thumbnail_class; ?>">
                <?php
                    if ($thumbnail_url) {
                        echo '<img src="'.$thumbnail_url.'" alt="'.esc_attr($title).'">';
                    }
                ?>
            </div>
            <div class="related-info">
                <h3 class="related-title"><?php echo $title; ?></h3>
                <p class="desc">
                    <?php the_excerpt_max_charlength(130); ?>
                </p>
                <div class="btn-box">
                    <span class="read-more"><?php _e('Read More', 'fw_campers'); ?></span>
                </div>
            </div>
        </div>
    </a>
</li>