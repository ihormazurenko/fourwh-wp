<?php
    $title = get_the_title();
    $model_id = get_the_ID();
//    if (get_current_user_id() == 1) {
        $childrens = get_children( array(
            'post_parent' => $model_id,
            'post_type'   => 'model',
            'numberposts' => -1,
            'post_status' => 'publish'
        ) );

//        var_dump($childrens);

        if ($childrens && is_array($childrens) && count($childrens) > 0 ) {
            $taxonomy = 'model_categories';
            $term_id = wp_get_post_terms($model_id, $taxonomy, array('fields' => 'ids'));
            $url = get_term_link((int)$term_id[0], $taxonomy);
        } else {
            $url = get_permalink();
        }
//    }

?>
<li>
    <div class="product-wrap">
        <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
            <h3 class="product-title"><?php echo $title; ?></h3>
            <div class="product-box">
                <?php if (has_post_thumbnail()) { ?>
                    <div class="product-img-wrap centered-img">
                        <?php the_post_thumbnail('medium_large', array(
                            'alt'   => esc_attr($title)
                        )); ?>
                    </div>
                <?php } ?>
                <?php if ( $general_list && is_array( $general_list ) && count( $general_list ) > 0 ) : ?>
                    <?php if ($general_list['short_description']) : ?>
                        <div class="see-improvement-box">
                            <span class="see-improvement"><?php _e('See Improvement','fw_campers'); ?></span>
                        </div>
                        <div class="product-info-box content small">
                            <?php echo $general_list['short_description']; ?>
                        </div>
                    <?php endif; ?>
                    <span class="view-more-btn"><?php _e('View Model','fw_campers'); ?></span>
                <?php endif; ?>
            </div>
        </a>
    </div>
</li>