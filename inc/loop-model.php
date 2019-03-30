<?php
    $title = get_the_title();
    $model_price = trim(get_field('model_price')) ? get_field('model_price') : '';
    $model_bed_size = trim(get_field('model_bed_size')) ? get_field('model_bed_size') : '';
    $model_floor_plans = trim(get_field('model_floor_plans')) ? get_field('model_floor_plans') : '';
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
    <div class="model-wrap">
        <div class="left-box">
            <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                <div class="model-img-wrap centered-img">
                <?php if (has_post_thumbnail()) { ?>
                   <?php the_post_thumbnail('large', array('alt'   => esc_attr($title))); ?>
                <?php } ?>
                </div>
            </a>
        </div>
        <div class="right-box">
            <div class="model-box">
                <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                    <h3 class="model-title"><?php echo $title; ?></h3>
                </a>
                <div class="model-inner-box">
                    <?php if ($model_price || $model_bed_size || $model_floor_plans) { ?>
                        <div class="model-details">
                            <?php if ($model_price) { ?>
                                <span class="model-info"><?php _e('Starting at','fw_campers'); ?> <span><?php _e('$','fw_campers'); ?><?php echo number_format( $model_price, 2, '.', ',' ); ?></span> <?php _e('USD','fw_campers'); ?></span>
                            <?php } ?>
                            <?php if ($model_bed_size) { ?>
                                <span class="model-info"><?php _e('Bed size:','fw_campers'); ?> <span><?php echo $model_bed_size; ?></span></span>
                            <?php } ?>
                            <?php if ($model_floor_plans) { ?>
                                <span class="model-info"><?php _e('Floor plans:','fw_campers'); ?> <span><?php echo $model_floor_plans; ?></span></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ($general_list['short_description'] || $general_list['truck_examples']) : ?>
                        <div class="content small">
                        <?php
                            if ($general_list['short_description']) {
                                echo $general_list['short_description'];
                            }
                            if ($general_list['truck_examples']) {
                                echo '<br><b>'.__('Truck examples:', 'fw_campers').'</b>';
                                echo '<p>'.$general_list['truck_examples'].'</p>';
                            }
                        ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (is_tax($taxonomy)) : ?>
                    <?php if ($show_view && $type != 'build') : ?>
                        <a href="<?php echo esc_url($url); ?>" class="btn blue" title="<?php esc_attr_e('View Model & Floor Plans','fw_campers'); ?>"><?php _e('View Model & Floor Plans','fw_campers'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo esc_url($url); ?>" class="btn blue" title="<?php esc_attr_e('Build & Price','fw_campers'); ?>"><?php _e('Build & Price','fw_campers'); ?></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo esc_url($url); ?>" class="btn blue" title="<?php esc_attr_e('View Model & Floor Plans','fw_campers'); ?>"><?php _e('View Model & Floor Plans','fw_campers'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</li>
<?php /*
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
 */ ?>