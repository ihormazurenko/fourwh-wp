<?php
    $title = get_the_title();
    $url = get_permalink();
    $description = get_field('description');
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
                <?php if ( $description && is_array( $description ) && count( $description ) > 0 ) : ?>
                    <?php if ($description['short_description']) : ?>
                        <div class="see-improvement-box">
                            <span class="see-improvement"><?php _e('See Improvement','fw_campers'); ?></span>
                        </div>
                        <div class="product-info-box content small">
                            <?php echo $description['short_description']; ?>
                        </div>
                    <?php endif; ?>
                    <span class="more-info-btn"><?php _e('View Model','fw_campers'); ?></span>
                <?php endif; ?>
            </div>
        </a>
    </div>
</li>