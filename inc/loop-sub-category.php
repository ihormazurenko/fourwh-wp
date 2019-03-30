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
    <div class="product-wrap">
        <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
            <div class="product-box">
                <?php if (has_post_thumbnail()) { ?>
                    <div class="product-img-wrap centered-img">
                        <?php the_post_thumbnail('large', array(
                            'alt'   => esc_attr($title)
                        )); ?>
                    </div>
                <?php } ?>
                <?php if ($title || $model_price) { ?>
                    <div class="product-desc">
                        <?php if ($title) { ?>
                            <h3 class="product-title"><?php echo $title; ?></h3>
                        <?php } ?>
                        <?php if ( $model_price) { ?>
                            <span class="product-price"><?php _e('$','fw_campers'); ?><?php echo number_format( $model_price, 2, '.', ',' ); ?></span></span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </a>
    </div>
</li>