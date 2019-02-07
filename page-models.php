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
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <div class="categories">
                <ul>
                    <li>
                        <a class="btn blue small <?php echo $all_model_id == get_the_ID() ? '' : 'inverse'; ?>" href="<?php echo get_permalink($all_model_id); ?>" title="<?php esc_attr_e('Slide-in', 'fw_campers'); ?>"><?php _e('Slide-in', 'fw_campers'); ?></a>
                    </li>
                    <li>
                        <a class="btn blue small <?php echo $flat_bad_model_id == get_the_ID() ? '' : 'inverse'; ?>" href="<?php echo get_permalink($flat_bad_model_id); ?>" title="<?php esc_attr_e('Flat Bed', 'fw_campers'); ?>"><?php _e('Flat Bed', 'fw_campers'); ?></a>
                    </li>
                </ul>
            </div>

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
                    echo '<ul class="products-list">';
                    foreach ($tax_children_ids as $value) :
                        $term = get_term( $value, $taxonomy );

                        if (strpos($term->slug, 'flat-bed')) :
                            $model_category_info = get_field('model_category_info', $taxonomy.'_'.$term->term_id);
                            if ($model_category_info && is_array($model_category_info) && count($model_category_info) > 0) :

                                $img_id = (int)$model_category_info['hero_image']['id'];
                                $title = $model_category_info['title'] ? $model_category_info['title'] : $term->name;
                                $description = $model_category_info['description'] ? $model_category_info['description'] : $term->description;
                                $url = get_term_link((int)$term->term_id, $taxonomy);

                                ?>
                                <li>
                                    <div class="product-wrap">
                                        <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                                            <h3 class="product-title"><?php echo $title; ?></h3>
                                            <div class="product-box">
                                                <?php if ($img_id) { ?>
                                                    <div class="product-img-wrap centered-img">
                                                        <?php echo wp_get_attachment_image($img_id,'large', false, array('title'   => esc_attr($title))); ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if ( $description) : ?>
                                                    <div class="see-improvement-box">
                                                        <span class="see-improvement"><?php _e('Details','fw_campers'); ?></span>
                                                    </div>
                                                    <div class="product-info-box content small">
                                                        <?php echo $description; ?>
                                                    </div>
                                                <?php endif; ?>
                                                <span class="view-more-btn"><?php _e('View Models','fw_campers'); ?></span>
                                            </div>
                                        </a>
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
                    'orderby'           => array( 'menu_order' => 'DESC', 'date' => 'ASC' ),
                    'post_parent'       => 0

                );
                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {
                    echo '<ul class="products-list">';
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