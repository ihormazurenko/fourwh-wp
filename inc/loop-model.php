<?php
    $title                          = get_the_title();
    $id                             = get_the_ID();
    $parent_id                      = wp_get_post_parent_id($id);
    $model_price                    = trim(get_field('model_price')) ? get_field('model_price') : '';
    $model_bed_size                 = trim(get_field('model_bed_size')) ? get_field('model_bed_size') : '';
    $model_floor_plans              = trim(get_field('model_floor_plans')) ? get_field('model_floor_plans') : '';
    $type                           = isset($_GET['type']) ? $_GET['type'] : '';
    $floorplans                     = get_field('floorplans_parent_data') ? get_field('floorplans', $parent_id) : get_field('floorplans', $id);

    if ( $type == 'build' ) {
        $url = get_permalink().'build/';
    } else {
        $url = get_permalink();
    }

    $general_list   = get_field('general_list');
    $taxonomy       = 'model_categories';
    $categories     = wp_get_post_terms(get_the_ID(), $taxonomy);
    $show_view      = 0;

    if ($categories && is_array($categories) && count($categories) > 0) {
//        foreach ($categories as $category) {
//            if (strpos($category->slug, 'flat-bed') || $category->slug === 'swift') {

//            if (strpos($category->slug, 'flat-bed')) {
                $show_view = 1;
//                $url = get_permalink().'build/';
//            }
//        }
    }


    $model_shell_price = trim(get_field('model_shell_price')) ? number_format( get_field('model_shell_price'), 0, '.', ',' ) : '' ;
    $model_full_price = trim(get_field('model_full_price')) ? number_format( get_field('model_full_price'), 0, '.', ',' ) : '' ;
?>
<li>
    <div class="model-wrap">
        <div class="left-box">
            <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                <div class="model-img-wrap centered-img">
                <?php if (has_post_thumbnail()) { ?>
                   <?php the_post_thumbnail('large', array('alt'   => esc_attr($title))); ?>
                   <div class="title-wrapper">
                        <h3 class="model-title model-custom-title"><?php echo $title; ?></h3>
                       <?php
                           //if (current_user_can('editor') || current_user_can('administrator')) {
                            if (!is_tax($taxonomy)) {
                               if ($model_shell_price || $model_full_price) {
                                   ?>
                                   <div class="model-prices-box">
                                       <?php if ($model_shell_price) { ?>
                                           <div class="model-info-box">
                                               <div class="inner-box">
                                                   <span class="model-name"><?php _e('Shell Models','fw_campers'); ?></span>
                                                   <span class="model-text"><?php _e('Starting at','fw_campers'); ?></span>
                                               </div>
                                               <div class="inner-box">
                                                   <span class="model-price"><?php echo __('$','fw_campers') . $model_shell_price; ?></span>
                                               </div>
                                           </div>
                                       <?php } ?>
                                       <?php if ($model_full_price) { ?>
                                           <div class="model-info-box">
                                               <div class="inner-box">
                                                   <span class="model-name"><?php _e('Full Camper','fw_campers'); ?></span>
                                                   <span class="model-text"><?php _e('Models Starting at','fw_campers'); ?></span>
                                               </div>
                                               <div class="inner-box">
                                                   <span class="model-price"><?php echo __('$','fw_campers') . $model_full_price; ?></span>
                                               </div>
                                           </div>
                                       <?php } ?>
                                   </div>
                                   <?php
                               }
                           } elseif ($model_price) { ?>
                            <span class="model-info"><?php _e('From at','fw_campers'); ?> <span><?php _e('$','fw_campers'); ?><?php echo number_format( $model_price, 0, '.', ',' ); ?>
                            <?php
                           }
                       ?>
                    </div>
                    <div class="info-custom">
                        <?php if ($model_bed_size) { ?>
                            <span class="model-info"><span><?php echo $model_bed_size; ?></span> <?php _e('bed size','fw_campers'); ?></span>
                        <?php } ?>
                        <?php if ($model_floor_plans) { ?>
                            <span class="model-info"><span><?php echo $model_floor_plans; ?></span> <?php _e('floor plans','fw_campers'); ?></span>
                        <?php } ?>
                    </div>
                <?php } ?>
                </div>
            </a>
            <?php
                //if (current_user_can('editor') || current_user_can('administrator')) {
                if (!is_tax($taxonomy)) {
                    if ($model_shell_price || $model_full_price) {
                        $line_class =  ($model_shell_price & $model_full_price) ? 'middle-line' : '';
                        ?>
                        <div class="model-prices-box <?php echo $line_class; ?>">
                            <?php if ($model_shell_price) { ?>
                            <div class="model-info-box">
                                <span class="model-name"><?php _e('Shell Models','fw_campers'); ?></span>
                                <span class="model-text"><?php _e('Starting at','fw_campers'); ?></span>
                                <span class="model-price"><?php echo __('$','fw_campers') . $model_shell_price; ?></span>
                            </div>
                            <?php } ?>
                            <?php if ($model_full_price) { ?>
                            <div class="model-info-box">
                                <span class="model-name"><?php _e('Full Camper Models','fw_campers'); ?></span>
                                <span class="model-text"><?php _e('Starting at','fw_campers'); ?></span>
                                <span class="model-price"><?php echo __('$','fw_campers') . $model_full_price; ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <?php
                    }
                }
            ?>

            <?php if ($floorplans['slider'] && count($floorplans['slider']) > 0) { ?>
            <div class="swiper-inner-images-box_carousel ">
                <?php
                $floorplans_slider  = $floorplans['slider'];
                $limit_count        = 1;

                foreach ( $floorplans_slider as $slide ) {

                    $slide_inner_images = $slide['inner_images'];
                    $inner_slide_count = count($slide_inner_images);
                    if ($slide_inner_images && is_array($slide_inner_images) && count($slide_inner_images) > 0 ) {
                        foreach ($slide_inner_images as $image) {

                            $image_url          = $image['sizes']['max-width-2800'] ? $image['sizes']['max-width-2800'] : $image['url'];
                            $image_title        = $image['title'] ? $image['title'] : '';
                            $image_thumb_url    = $image['sizes']['medium'] ? $image['sizes']['medium'] : $image['sizes']['medium_large'];

                            //if($inner_slide_count > 1) { //if more than one inner slide image
                                echo '<div class="m_thumb_img"><a href="' . esc_url($image_url) . '" class="plan-slide-img_carousel"></a>';
                                echo '<div class="plan-slide-img-modal"><div class="plan-slide-img-inner">';
                                echo wp_get_attachment_image( $image['ID'], 'medium', false, array('data-floorplan-id' => $image['ID'], 'class' => 'thumb_img'));
                                echo '</div></div></div>';
                            //}

                        }
                    }
                }
                ?>
            </div>
            <?php } ?>

            <?php if (is_tax($taxonomy)) : ?>
                <?php if ($show_view && $type != 'build') : ?>
                    <a href="<?php echo esc_url($url); ?>" class="btn blue btn_viewModel_plans" title="<?php esc_attr_e('View Model & Floor Plans','fw_campers'); ?>"><?php _e('View Model & Floor Plans','fw_campers'); ?></a>
                <?php else: ?>
                    <a href="<?php echo esc_url($url); ?>" class="btn blue btn_viewModel_plans" title="<?php esc_attr_e('Build &amp; Price'.$show_view,'fw_campers'); ?>"><?php _e('Build &amp; Price','fw_campers'); ?></a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo esc_url($url); ?>" class="btn blue btn_viewModel_plans" title="<?php esc_attr_e('View Model & Floor Plans','fw_campers'); ?>"><?php _e('View Model & Floor Plans','fw_campers'); ?></a>
            <?php endif; ?>
        </div>
      <?php /*
        <!--
        <div class="right-box">
            <div class="model-box">
                <a href="<?php echo esc_url($url); ?>/" title="<?php echo esc_attr($title); ?>">
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
                        <a href="<?php echo esc_url($url); ?>/" class="btn blue" title="<?php esc_attr_e('View Model & Floor Plans','fw_campers'); ?>"><?php _e('View Model & Floor Plans','fw_campers'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo esc_url($url); ?>/" class="btn blue note-beta" title="<?php esc_attr_e('Build &amp; Price','fw_campers'); ?>"><?php _e('Build &amp; Price','fw_campers'); ?><span>beta</span></a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo esc_url($url); ?>/" class="btn blue" title="<?php esc_attr_e('View Model & Floor Plans','fw_campers'); ?>"><?php _e('View Model & Floor Plans','fw_campers'); ?></a>
                <?php endif; ?>
            </div>
        </div>
                        -->
 */ ?>
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
