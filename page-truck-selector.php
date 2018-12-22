<?php
/**
 * Template Name: Truck Selector
 */
get_header(); ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-select-truck">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php
                global $wp_query;
                $truck_selector_arr = [];
                $taxonomy = 'model_category';

                $args = array(
                    'post_type'         => 'model',
                    'post_status'       => 'publish',
                    'posts_per_page'    => -1,
                    'orderby'           => 'id',
                    'order'             => 'ASC',
                );
                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {

                    while ( $new_query->have_posts() ) : $new_query->the_post();
                        $model_id               = get_the_ID();
                        $model_name             = get_the_title();
                        $model_thumbnail_id     = get_post_thumbnail_id();
                        $model_thumbnail_arr    = $model_thumbnail_id ? image_downsize($model_thumbnail_id, 'medium_large') : '';
                        $model_thumbnail_url    = $model_thumbnail_arr[0] ? $model_thumbnail_arr[0] : '';
                        $truck_category         = get_the_terms($model_id, $taxonomy);

                        if (is_array($truck_category)) {
                            $category_id   = trim($truck_category[0]->term_id);
                            $category_slug = trim($truck_category[0]->slug);
                            $category_name = trim($truck_category[0]->name);
                            $category_desc = trim($truck_category[0]->description);
                            $category_photo_arr = get_field('photo', $taxonomy.'_'.$category_id);
                            $category_photo_url = $category_photo_arr['sizes']['medium_large'] ? $category_photo_arr['sizes']['medium_large'] : '';


                            if (array_key_exists($category_id, $truck_selector_arr)) {
                                $truck_selector_arr[$category_id]['models'][$model_id] = [
                                            'model_name'             => $model_name,
                                            'model_thumbnail_url'    => $model_thumbnail_url
                                ];
                            } else {
                                $truck_selector_arr[$category_id] = [
                                    'category_slug'    => $category_slug,
                                    'category_name'    => $category_name,
                                    'category_desc'    => $category_desc,
                                    'category_photo'   => $category_photo_url,
                                    'models' => [
                                        $model_id => [
                                            'model_name'             => $model_name,
                                            'model_thumbnail_url'    => $model_thumbnail_url,
                                        ]
                                    ],
                                ];
                            }
                        }

                    endwhile;

                } else {
                    $truck_selector_arr = [];
                }

                wp_reset_query();

                if ( $truck_selector_arr && is_array($truck_selector_arr) && count($truck_selector_arr) > 0 ) :
                    echo '<ul class="select-truck-list">';
                        foreach ($truck_selector_arr as $category_id => $category) :
                            $category_slug      = $category['category_slug'];
                            $category_name      = $category['category_name'];
                            $category_desc      = $category['category_desc'];
                            $category_photo_url = $category['category_photo'];
                        ?>
                            <li>
                                <div class="select-truck-box">
                                    <input type="radio" id="truck-<?php echo esc_attr( $category_id ); ?>" name="your-truck" class="radio-truck" data-truck-type="<?php echo esc_attr( $category_slug ); ?>" value="<?php echo esc_attr( $category_slug ); ?>">
                                    <label for="truck-<?php echo esc_attr( $category_id ); ?>">
                                        <div class="select-truck-img-wrap">
                                            <?php if ( $category_photo_url ) : ?>
                                                <img src="<?php echo esc_url( $category_photo_url ); ?>" alt="<?php echo esc_attr( $category_name ); ?>">
                                            <?php endif; ?>
                                        </div>
                                        <?php if ( $category_name ) { ?>
                                            <h3 class="select-truck-name"><?php echo $category_name; ?></h3>
                                        <?php } ?>
                                    </label>
                                </div>
                            </li>
                        <?php
                        endforeach;
                    echo "</ul>";

                    foreach ($truck_selector_arr as $category_id => $category) :
                        $category_slug      = $category['category_slug'];
                        $category_desc      = $category['category_desc'];
                        $models             = $category['models'];
                        ?>
                        <div class="choose-bed-length-box" data-truck-group="<?php echo esc_attr( $category_slug ); ?>">
                            <h2 class="section-title smaller line"><?php _e('Choose Bed Length', 'fw_campers'); ?></h2>
                            <?php if ($category_desc) : ?>
                                <div class="section-desc content">
                                    <p><?php echo $category_desc; ?></p>
                                </div>
                            <?php endif; ?>
                            <?php
                                if ($models && is_array($models) && count($models) > 0 ) :
                                    echo '<ul class="select-truck-list bed-length" >';
                                    foreach ($models as $model_id => $model) :
                                        $model_name          = $model['model_name'];
                                        $model_thumbnail_url = $model['model_thumbnail_url'];
                                        $model_url           = get_permalink($model_id);
                                        ?>
                                            <li>
                                                <div class="select-truck-box">
                                                    <input type="radio" id="<?php echo $category_slug.'_'.$model_id; ?>" name="your-bed-length" class="radio-truck" data-truck-url="<?php echo esc_url($model_url); ?>" value="<?php echo esc_attr($model_name); ?>">
                                                    <label for="<?php echo $category_slug.'_'.$model_id; ?>">
                                                        <div class="select-truck-img-wrap">
                                                            <?php if ($model_thumbnail_url) { ?>
                                                                <img src="<?php echo esc_url($model_thumbnail_url); ?>" alt="<?php echo esc_attr($model_name); ?>">
                                                            <?php } ?>
                                                        </div>
                                                        <h3 class="select-truck-name"><?php echo $model_name; ?></h3>
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