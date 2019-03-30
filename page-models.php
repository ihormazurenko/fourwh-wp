<?php
/**
 * Template Name: Campers List
 */
get_header();
$id                     = get_the_ID();
$all_model_id           = 1236;
$flat_bad_model_id      = 2554;
$taxonomy               = 'model_categories';
$categories             = get_terms(array('taxonomy' => $taxonomy, 'orderby' => 'term_order', 'parent' => 0));
$flat_bad_page          = wp_get_post_parent_id($id);

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-products">
        <div id="content"></div>
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <div class="categories">
                <ul>
                    <li>
                        <a class="btn blue small <?php echo $all_model_id == get_the_ID() ? '' : 'inverse'; ?>" href="<?php echo get_permalink($all_model_id); ?>" title="<?php esc_attr_e('Slide-In', 'fw_campers'); ?>"><?php _e('Slide-In', 'fw_campers'); ?></a>
                    </li>
                    <li>
                        <a class="btn blue small <?php echo $flat_bad_model_id == get_the_ID() ? '' : 'inverse'; ?>" href="<?php echo get_permalink($flat_bad_model_id); ?>" title="<?php esc_attr_e('Flat Bed', 'fw_campers'); ?>"><?php _e('Flat Bed', 'fw_campers'); ?></a>
                    </li>
                </ul>
            </div>

            <?php if (get_current_user_id() == 1) {
                /*?>
                <ul class="models-list">
                    <li>
                        <div class="model-wrap">
                            <div class="left-box">
                                <a href="https://acsdm.com/fwc/model/raven-model/"  title="">
                                    <div class="model-img-wrap centered-img">
                                        <img width="300" height="225" src="https://acsdm.com/fwc/wp-content/uploads/2018/12/raven-model-thumbnail.jpg" class="attachment-large size-large wp-post-image fadein-style" alt="Raven Model">
                                    </div>
                                </a>
                            </div>
                            <div class="right-box">
                                <div class="model-box">
                                    <a href="https://acsdm.com/fwc/model/raven-model/"  title="">
                                        <h3 class="model-title">Raven Model</h3>
                                    </a>
                                    <div class="model-inner-box">
                                        <div class="model-details">
                                            <span class="model-info">Starting at <span>$18,995.00</span> USD</span>
                                            <span class="model-info">Bed size: <span>5'5"– 5'8"</span></span>
                                            <span class="model-info">Floor plans: <span>2</span></span>
                                        </div>
                                        <div class="content small">
                                            <p>The Raven Model is designed to fit on Full Sized, 1/2 Ton, Crew Cab trucks
                                                that have the really short bed. These trucks usually have the
                                                short 5’5″– 5’8″ truck bed.</p>
                                            <br>
                                            <b>Truck examples:</b>
                                            <p>Ford F-150 SuperCrew, Tundra CrewMax, Chevy/GMC 1500 Crew Cab,
                                                Nissan Titan CrewCab, etc.</p>
                                        </div>
                                    </div>
                                    <a href="https://acsdm.com/fwc/model/raven-model/" class="btn blue" title="View Model & Floor Plans">View Model & Floor Plans</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="model-wrap">
                            <div class="left-box">
                                <div class="model-img-wrap centered-img">
                                    <img width="300" height="225" src="https://acsdm.com/fwc/wp-content/uploads/2018/12/hawk-model-thumbnail.jpg" class="attachment-large size-large wp-post-image fadein-style" alt="Raven Model">
                                </div>
                            </div>
                            <div class="right-box">
                                <div class="model-box">
                                    <h3 class="model-title">Raven Model</h3>
                                    <div class="model-inner-box">
                                        <div class="model-details">
                                            <span class="model-info">Starting at <span>$18,995.00</span> USD</span>
                                            <span class="model-info">Bed size: <span>5'5"– 5'8"</span></span>
                                            <span class="model-info">Floor plans: <span>2</span></span>
                                        </div>
                                        <div class="content small">
                                            <p>The Raven Model is designed to fit on Full Sized, 1/2 Ton, Crew Cab trucks
                                                that have the really short bed. These trucks usually have the
                                                short 5’5″– 5’8″ truck bed.</p>
                                            <br>
                                            <b>Truck examples:</b>
                                            <p>Ford F-150 SuperCrew, Tundra CrewMax, Chevy/GMC 1500 Crew Cab,
                                                Nissan Titan CrewCab, etc.</p>
                                        </div>
                                    </div>
                                    <a href="https://acsdm.com/fwc/model/raven-model/" class="btn blue" title="View Model & Floor Plans">View Model & Floor Plans</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            <?php */ } ?>

            <?php
            if ($flat_bad_page) :

                $tax_children_ids = [];
                foreach ($categories as $category) {
                    $tax_children = get_term_children((int)$category->term_id, $taxonomy);
                    $tax_children_id = (is_array($tax_children) && count($tax_children) > 0) ? $tax_children[0] : 0;
                    if ($tax_children_id > 0 && !in_array($tax_children_id)) {
                        $tax_children_ids[] = $tax_children_id;
                    }
                }

                if ($tax_children_ids && is_array($tax_children_ids) && count($tax_children_ids) > 0 ) :
                    echo '<ul class="models-list">';
                    foreach ($tax_children_ids as $value) :
                        $term = get_term( $value, $taxonomy );

                        if (strpos($term->slug, 'flat-bed')) :
                            $model_category_info = get_field('model_category_info', $taxonomy.'_'.$term->term_id);
                            if ($model_category_info && is_array($model_category_info) && count($model_category_info) > 0) :

                                $img_id = (int)$model_category_info['hero_image']['id'];
                                $title = $model_category_info['title'] ? $model_category_info['title'] : $term->name;
                                $description = $model_category_info['description'] ? $model_category_info['description'] : $term->description;
                                $url = get_term_link((int)$term->term_id, $taxonomy);
                                $model_price = trim($model_category_info['price']) ? $model_category_info['price'] : '';
                                $model_bed_size = trim($model_category_info['bed_size']) ? $model_category_info['bed_size'] : '';
                                $model_floor_plans = trim($model_category_info['floor_plans']) ? $model_category_info['floor_plans'] : '';
                                $model_truck_examples = trim($model_category_info['truck_examples']) ? $model_category_info['truck_examples'] : '';

                                ?>
                                <li>
                                    <div class="model-wrap">
                                        <div class="left-box">
                                            <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                                                <div class="model-img-wrap centered-img">
                                                <?php
                                                    if ($img_id) {
                                                        echo wp_get_attachment_image($img_id,'large', false, array('title'   => esc_attr($title)));
                                                    }
                                                ?>
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
                                                    <?php if ($description || $model_truck_examples) : ?>
                                                        <div class="content small">
                                                            <?php
                                                            if ($description) {
                                                                echo $description;
                                                            }
                                                            if ($model_truck_examples) {
                                                                echo '<br><b>'.__('Truck examples:', 'fw_campers').'</b>';
                                                                echo '<p>'.$model_truck_examples.'</p>';
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <a href="<?php echo esc_url($url); ?>" class="btn blue" title="<?php esc_attr_e('View Models','fw_campers'); ?>"><?php _e('View Models','fw_campers'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            endif;
                        endif;
                    endforeach;;
                    echo "</ul>";
                endif;

            else:
                global $wp_query;

                $args = array(
                    'post_type'         => 'model',
                    'post_status'       => 'publish',
                    'posts_per_page'    => -1,
                    'orderby'           => array( 'menu_order' => 'DESC', 'date' => 'DESC' ),
                    'post_parent'       => 0

                );
                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {
                    echo '<ul class="models-list">';
                    while ( $new_query->have_posts() ) : $new_query->the_post();

                        get_template_part('inc/loop', 'model');

                    endwhile;
                    echo "</ul>";
                } else {
                    echo '<p class="no-results">' . __('Sorry, no models found...', 'fw_campers') . '</p>';
                }

                wp_reset_query();
            endif;
            ?>

        </div>
    </section>

<?php get_footer(); ?>