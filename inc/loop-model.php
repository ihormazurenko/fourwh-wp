<?php
    $title = get_the_title();
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    if ( $type == 'build' ) {
        $url = get_permalink().'build';
    } else {
        $url = get_permalink();
    }
    $general_list   = get_field('general_list');
    $taxonomy       = 'model_categories';
    $categories     = wp_get_post_terms(get_the_ID(), $taxonomy);
    $show_view      = 0;

    if ($categories && is_array($categories) && count($categories) > 0) {
        foreach ($categories as $category) {
            if (strpos($category->slug, 'flat-bed')) {
                $show_view = 1;
            }
        }
    }
?>
<li>
    <div class="product-wrap">
        <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
            <h3 class="product-title"><?php echo $title; ?></h3>
            <div class="product-box">
                <?php if (has_post_thumbnail()) { ?>
                    <div class="product-img-wrap centered-img">
                        <?php the_post_thumbnail('large', array(
                            'alt'   => esc_attr($title)
                        )); ?>
                    </div>
                <?php } ?>
                <?php if ( $general_list && is_array( $general_list ) && count( $general_list ) > 0 ) : ?>
                    <?php if ($general_list['short_description']) : ?>
                        <div class="see-improvement-box">
                            <span class="see-improvement"><?php _e('Details','fw_campers'); ?></span>
                        </div>
                        <div class="product-info-box content small">
                            <?php echo $general_list['short_description']; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (is_tax($taxonomy)) : ?>
                        <?php if ($show_view && $type != 'build') : ?>
                            <span class="view-more-btn"><?php _e('View Model','fw_campers'); ?></span>
                        <?php else: ?>
                            <span class="view-more-btn"><?php _e('Build & Price','fw_campers'); ?></span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="view-more-btn"><?php _e('View Model','fw_campers'); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </a>
    </div>
</li>