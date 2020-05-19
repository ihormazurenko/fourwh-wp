<?php
get_header();
$all_model_id           = 1236;
$flat_bad_model_id      = 2554;
$model_term = get_queried_object();
?>

<?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-products">
        <div id="content"></div>
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php /*if (strpos(get_queried_object()->slug, 'flat-bed')) { ?>
                <div class="categories">
                    <ul>
                        <li>
                            <a class="btn blue small inverse" href="<?php echo get_permalink($all_model_id); ?>" title="<?php esc_attr_e('Slide-In', 'fw_campers'); ?>"><?php _e('Slide-In', 'fw_campers'); ?></a>
                        </li>
                        <li>
                            <a class="btn blue small" href="<?php echo get_permalink($flat_bad_model_id); ?>" title="<?php esc_attr_e('Flat Bed', 'fw_campers'); ?>"><?php _e('Flat Bed', 'fw_campers'); ?></a>
                        </li>
                    </ul>
                </div>
            <?php } */?>

            <?php if (get_current_user_id() == 1) { /* ?>

                <div class="sub-category-desc">
                    <div class="left-box">
                        <div class="sub-category-info">
                            <ul class="list">
                                <li><span>$18,995</span> Starting price</li>
                                <li><span>6.0′</span> Bed size</li>
                                <li><span>2</span> Floor plans</li>
                            </ul>
                        </div>
                    </div>
                    <div class="right-box">
                        <div class="content small">
                            <b>About model</b>
                            <p>The Fleet Flat Bed Model is designed to fit on the smaller & mid-sized trucks that
                                have the longer 6.0′ foot bed. For this camper model you will also need to have a
                                Flat Bed Tray installed. The “flat bed” can be installed from aftermarket companies
                                or from most of our camper dealers.</p>

                            <b>Truck examples</b>
                            <p>Toyota Tacoma, Ford Ranger, Nissan Frontier, Chevy Colorado, GMC Canyon,
                                & Dodge Dakota.</p>
                        </div>
                    </div>
                </div>

                <?php
                if ( have_posts() ) {
                    echo '<ul class="products-list">';
                    while ( have_posts() ) : the_post();

                        get_template_part('inc/loop', 'sub-category');

                    endwhile;
                    echo '</ul>';
                } else {
                    echo '<p class="no-results">' . __('Sorry, no models found...', 'fw_campers') . '</p>';
                }

                wp_reset_query();
                ?>

            <?php */ } ?>

            <?php /*
            if ( have_posts() ) {
                echo '<ul class="models-list">';
                while ( have_posts() ) : the_post();

                    get_template_part('inc/loop', 'model');

                endwhile;
                echo '</ul>';
            } else {
                echo '<p class="no-results">' . __('Sorry, no models found...', 'fw_campers') . '</p>';
            }

            wp_reset_query();
 */

                if (strpos($model_term->slug, 'flat-bed')) {

                    $parent_model_category_info = get_field('model_category_info', 'model_categories_'.$model_term->term_id);

                    if ($parent_model_category_info && is_array($parent_model_category_info) && count($parent_model_category_info) > 0) {
                        $parent_price = trim($parent_model_category_info['price']) ? $parent_model_category_info['price'] : '';
                        $parent_bed_size = trim($parent_model_category_info['bed_size']) ? $parent_model_category_info['bed_size'] : '';
                        $parent_floor_plans = trim($parent_model_category_info['floor_plans']) ? $parent_model_category_info['floor_plans'] : '';
                        $parent_description = $parent_model_category_info['description'] ? $parent_model_category_info['description'] : $model_term->description;
                        $parent_truck_examples = trim($parent_model_category_info['truck_examples']) ? $parent_model_category_info['truck_examples'] : '';
                    }

                } else {

                    $parent_model_id = 0;

                    if (have_posts()) {
                        while (have_posts()) : the_post();
                            $childrens = get_children(array(
                                'post_parent' => get_the_ID(),
                                'post_type' => 'model',
                                'numberposts' => 1,
                                'post_status' => 'publish'
                            ));

                            if ($childrens && is_array($childrens) && count($childrens) > 0) {
                                $parent_model_id = get_the_ID();
                            }

                        endwhile;
                    }

                    wp_reset_query();

                    if ($parent_model_id) {
                        $parent_price = trim(get_field('model_price', $parent_model_id)) ? get_field('model_price', $parent_model_id) : '';
                        $parent_bed_size = trim(get_field('model_bed_size', $parent_model_id)) ? get_field('model_bed_size', $parent_model_id) : '';
                        $parent_floor_plans = trim(get_field('model_floor_plans', $parent_model_id)) ? get_field('model_floor_plans', $parent_model_id) : '';
                        $parent_general_list   = get_field('general_list', $parent_model_id);
                        $parent_description = trim($parent_general_list['short_description']) ? $parent_general_list['short_description'] : '';
                        $parent_truck_examples = trim($parent_general_list['truck_examples']) ? $parent_general_list['truck_examples'] : '';
                    }
                }
            ?>

            <div class="sub-category-desc">
                <div class="left-box">
                    <div class="sub-category-info">
                        <ul class="list">
                            <?php if($parent_price) { ?>
                                <li><span><?php _e('$','fw_campers'); ?><?php echo number_format( $parent_price, 0, '.', ',' ); ?></span> <?php _e('Starting price', 'fw_campers'); ?></li>
                            <?php } ?>
                            <?php if($parent_bed_size) { ?>
                                <li><span><?php echo $parent_bed_size; ?></span> <?php _e('Bed size', 'fw_campers'); ?></li>
                            <?php } ?>
                            <?php if($parent_floor_plans) { ?>
                                <li><span><?php echo $parent_floor_plans; ?></span> <?php _e('Floor plans', 'fw_campers'); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="right-box">
                    <div class="content small">
                        <?php
                        if ($parent_description) {
                            echo '<b>'.__('About model', 'fw_campers').'</b>';
                            echo $parent_description;
                        }
                        if ($parent_truck_examples) {
                            echo '<b>'.__('Truck examples:', 'fw_campers').'</b>';
                            echo '<p>'.$parent_truck_examples.'</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
//            if ( have_posts() ) {
//                echo '<ul class="products-list">';
//                while ( have_posts() ) : the_post();
//
//                    get_template_part('inc/loop', 'model-subcategory');
//
//                endwhile;
//                echo '</ul>';
//            } else {
//                echo '<p class="no-results">' . __('Sorry, no models found...', 'fw_campers') . '</p>';
//            }
//
//            wp_reset_query();
            global $wp_query;

            $args = array(
                'post_type'         => 'model',
                'post_status'       => 'publish',
                'posts_per_page'    => -1,
                'orderby'           => array( 'menu_order' => 'DESC', 'date' => 'DESC' ),
                'model_categories' => $model_term->slug
            );

            if ($parent_model_id) {
                $args['post__not_in'] = [$parent_model_id];
            }

            $new_query = new WP_Query( $args );

            if ($new_query->have_posts()) {
                echo '<ul class="models-list">';
                while ( $new_query->have_posts() ) : $new_query->the_post();

                    get_template_part('inc/loop', 'model');
                    //get_template_part('inc/loop', 'model-subcategory');

                endwhile;
                echo "</ul>";
            } else {
                echo '<p class="no-results">' . __('Sorry, no models found...', 'fw_campers') . '</p>';
            }

            wp_reset_query();
            ?>

        </div>
    </section>

<?php get_footer(); ?>