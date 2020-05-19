<?php
/**
 * Template Name: Campers List
 */
get_header();
$id                     = get_the_ID();
$parent_id                      = wp_get_post_parent_id($id);

$all_model_id           = 1236;
$flat_bad_model_id      = 2554;
$taxonomy               = 'model_categories';
$categories             = get_terms(array('taxonomy' => $taxonomy, 'orderby' => 'term_order', 'parent' => 0));
$flat_bad_page          = wp_get_post_parent_id($id);


?>
<!-- <?php print $flat_bad_page; ?> -->
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
                    <li>
                        <a class="btn blue small inverse" href="<?php echo get_permalink(4010); ?>" title="<?php esc_attr_e('Project M', 'fw_campers'); ?>"><?php _e('Project M', 'fw_campers'); ?></a>
                    </li>

                    
                </ul>
            </div>

            <?php
            // if ($flat_bad_page) :
            if ($id == $flat_bad_model_id) :

                $tax_children_ids = [];
                foreach ($categories as $category) {
                    $tax_children = get_term_children((int)$category->term_id, $taxonomy);
                    $tax_children_id = (is_array($tax_children) && count($tax_children) > 0) ? $tax_children[0] : 0;
                    if ($tax_children_id > 0 && !in_array($tax_children_id, $tax_children_ids)) {
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
                                                    <div class="title-wrapper">
                                                        <h3 class="model-title model-custom-title"><?php echo $title; ?></h3>
                                                        <?php if ($model_price) { ?>
                                                            <span class="model-info"><?php _e('From at','fw_campers'); ?> <span><?php _e('$','fw_campers'); ?><?php echo number_format( $model_price, 0, '.', ',' ); ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="info-custom">
                                                        <?php if ($model_bed_size) { ?>
                                                            <span class="model-info"><span><?php echo $model_bed_size; ?></span> <?php _e('bed size','fw_campers'); ?></span>
                                                        <?php } ?>
                                                        <?php if ($model_floor_plans) { ?>
                                                            <span class="model-info"><span><?php echo $model_floor_plans; ?></span> <?php _e('floor plans','fw_campers'); ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="<?php echo esc_url($url); ?>" class="btn blue btn_viewModel_plans" title="<?php esc_attr_e('View Models','fw_campers'); ?>"><?php _e('View Models','fw_campers'); ?></a>
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
                    'post_parent'       => 0,
                    'post__not_in' => array(3928,4010) //Don't include the Project M Post

                );
                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {
                    echo '<ul class="models-list">';
                    while ( $new_query->have_posts() ) : $new_query->the_post();

                        get_template_part('inc/loop', 'model');

                    endwhile;
                    ?>
                        <li class="custom_shell_wrapper">
                            <div class="model-wrap">
                                <div class="left-box">
                                    <a href="javascript:void(0);" class="shell_campers">
                                        <div class="shell_campers_title">
                                            <h3>Shell Campers</h3>
                                            <p>start at $12,995 and are available in all Slide-in models</p>
                                        </div>
                                        <div class="shell_cursor">
                                            <div class="cursor_image_wrapper">
                                                <img src="<?php echo get_template_directory_uri(); ?>/img/cursor.png">
                                            </div>
                                        </div>
                                        <div class="shell_click_btn">
                                            <p>click a model for details</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php
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