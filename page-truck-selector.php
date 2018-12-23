<?php
/**
 * Template Name: Truck Selector
 */
get_header(); ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-select-truck" id="truck-search">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php
                $truck_selector_arr = [];
                $taxonomy = 'model_sizes';
                $sizes = get_terms($taxonomy, array('orderby' => 'term_order', 'hide_empty' => 0));

                if ( $sizes && is_array($sizes) && count($sizes) > 0 ) :
                    foreach ($sizes as $key => $size) {
                        $size_id        = trim($size->term_id);
                        $size_slug      = trim($size->slug);
                        $size_name      = trim($size->name);
                        $size_desc      = trim($size->description);
                        $size_photo_arr = get_field('photo', $taxonomy.'_'.$size_id);
                        $size_photo_url = $size_photo_arr['sizes']['medium_large'] ? $size_photo_arr['sizes']['medium_large'] : '';
                        $size_link      = get_term_link((int)$size_id, $taxonomy);
                        $parent_id      = $size->parent;


                        if ($parent_id == 0) {
                            //parent size
                            $truck_selector_arr[$size_id] = [
                                'size_slug'    => $size_slug,
                                'size_name'    => $size_name,
                                'size_desc'    => $size_desc,
                                'size_photo'   => $size_photo_url,
//                                'size_link'    => $size_link,
                            ];
                        } else {
                            //child size
                            $truck_selector_arr[$parent_id]['child_sizes'][$size_id] = [
                                'child_slug'  => $size_slug,
                                'child_name'  => $size_name,
                                'child_photo' => $size_photo_url,
                                'child_link'  => $size_link,
                            ];
                        }
                    }
                endif;

                if ( $truck_selector_arr && is_array($truck_selector_arr) && count($truck_selector_arr) > 0 ) :
                    echo '<ul class="select-truck-list">';
                        foreach ($truck_selector_arr as $size_id => $size) :
                            $size_slug      = $size['size_slug'];
                            $size_name      = $size['size_name'];
                            $size_desc      = $size['size_desc'];
                            $size_photo_url = $size['size_photo'];
                        ?>
                            <li>
                                <div class="select-truck-box">
                                    <input type="radio" id="truck-<?php echo esc_attr( $size_id ); ?>" name="your-truck" class="radio-truck" data-truck-type="<?php echo esc_attr( $size_slug ); ?>" value="<?php echo esc_attr( $size_slug ); ?>">
                                    <label for="truck-<?php echo esc_attr( $size_id ); ?>">
                                        <div class="select-truck-img-wrap">
                                            <?php if ( $size_photo_url ) : ?>
                                                <img src="<?php echo esc_url( $size_photo_url ); ?>" alt="<?php echo esc_attr( $size_name ); ?>">
                                            <?php endif; ?>
                                        </div>
                                        <?php if ( $size_name ) { ?>
                                            <h3 class="select-truck-name"><?php echo $size_name; ?></h3>
                                        <?php } ?>
                                    </label>
                                </div>
                            </li>
                        <?php
                        endforeach;
                    echo "</ul>";

                    foreach ($truck_selector_arr as $size_id => $size) :
                        $size_slug      = $size['size_slug'];
                        $size_desc      = $size['size_desc'];
                        $children_sizes = $size['child_sizes'];
                        ?>
                        <div class="choose-bed-length-box" data-truck-group="<?php echo esc_attr( $size_slug ); ?>">
                            <h2 class="section-title smaller line"><?php _e('Choose Bed Length', 'fw_campers'); ?></h2>
                            <?php if ($size_desc) : ?>
                                <div class="section-desc content">
                                    <p><?php echo $size_desc; ?></p>
                                </div>
                            <?php endif; ?>
                            <?php
                                if ($children_sizes && is_array($children_sizes) && count($children_sizes) > 0 ) :
                                    echo '<ul class="select-truck-list bed-length" >';
                                    foreach ($children_sizes as $child_id => $child) :
                                        $child_name          = $child['child_name'];
                                        $child_thumbnail_url = $child['child_photo'];
                                        $child_url           = $child['child_link'];
                                        ?>
                                            <li>
                                                <div class="select-truck-box">
                                                    <input type="radio" id="<?php echo $size_slug.'_'.$child_id; ?>" name="your-bed-length" class="radio-truck" data-truck-url="<?php echo esc_url($child_url); ?>" value="<?php echo esc_attr($child_name); ?>">
                                                    <label for="<?php echo $size_slug.'_'.$child_id; ?>">
                                                        <div class="select-truck-img-wrap">
                                                            <?php if ($child_thumbnail_url) { ?>
                                                                <img src="<?php echo esc_url($child_thumbnail_url); ?>" alt="<?php echo esc_attr($child_name); ?>">
                                                            <?php } ?>
                                                        </div>
                                                        <h3 class="select-truck-name"><?php echo $child_name; ?></h3>
                                                    </label>
                                                </div>
                                            </li>
                                        <?php
                                    endforeach;
                                    echo '</ul>';
                                endif;
                            ?>
                        </div>
                        <?php
                    endforeach;
                    ?>
                    <div class="select-truck-btn-box">
                        <a href="" class="btn blue" target="_self" title="<?php esc_attr_e('Find my Camper', 'fw_campers'); ?>" data-find-truck><?php _e('Find my Camper', 'fw_campers'); ?></a>
                        <a href="" class="btn blue" target="_self" title="<?php esc_attr_e('Build Now', 'fw_campers'); ?>" data-build-truck><?php _e('Build Now', 'fw_campers'); ?></a>
                    </div>
                    <?php

                endif;
            ?>
        </div>
    </section>

<?php get_footer(); ?>