<?php
/**
 * Template Name: My Life List
 */
get_header();


    ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section-life-grid">
        <div class="container">

            <?php

            $terms = get_terms('life_category');
            $terms = get_terms( array(
                'hide_empty'  => 0,
                'orderby'     => 'menu_order',
                'order'       => 'ASC',
                'taxonomy'    => 'life_category',
            ) );

            if ( !empty( $terms ) && !is_wp_error( $terms ) ){
                ?>
                <div class="categories button-group filters-button-group">
                    <ul>
                        <li><a class="btn blue small active" href="#" data-filter="*" title="<?php esc_attr_e('All', 'fw_campers'); ?>"><?php _e('All', 'fw_campers'); ?></a></li>
                        <?php
                        foreach ( $terms as $term ) {
                            $term = sanitize_term( $term, 'project-category' );
                            $term_slug = $term->slug;

                            echo '<li><a href="#'.$term_slug.'" data-filter=".'.$term_slug.'" title="'.strip_tags(esc_attr($term->name)).'" class="btn blue small inverse">' . $term->name . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }

            ?>


            <?php

                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = array(
                    'post_type'     => 'my_life',
                    'post_status'   => 'publish',
                    'posts_per_page' => -1,
                    'orderby'       => 'menu_order',
                    'order'         => 'ASC',
                    'paged'         => $paged,
                );

                $step_arr = [];
                $step_count = 0;

                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) :
                    ?>
                    <div class="grid isotope">
                        <div class="grid-sizer"></div>
                        <div class="gutter-sizer"></div>
                        <div class="grid-inner-box">
                            <?php
                            while ( $new_query->have_posts() ) : $new_query->the_post();
                                $step = $step_count % 15 + 1;
                                $step_h2 = $step_count % 15 + 15;
                                $item_class = $post_img_class = '';
                                $item_img_size = 'large';

                                if ($step == 1 || $step == 8) {
                                    $step_arr['width-2'][] = $step_count;
                                    $item_class = ' grid-item--width2';
//                                    $item_img_size = 'large';
                                } else if ($step == 12) {
                                    $step_arr['width-3'][] = $step_count;
                                    $item_class = ' grid-item--width3';
//                                    $item_img_size = 'max-width-2800';
                                } else if ($step_h2 == 21) {
                                    $step_arr['height-2'][] = $step_count;
                                    $item_class = ' grid-item--height2';
//                                    $item_img_size = 'size-720_720';
                                }

                                $step_count++;

                                $title = get_the_title();
                                $url = get_permalink();
                                $post_img_id = $life_term = '';
                                $life_terms = get_the_terms(get_the_ID(), 'life_category');

                                if ($life_terms && is_array($life_terms) && count($life_terms) > 0) {
                                    $life_term = $life_terms[0]->slug;
                                }

                                $item_class .= ' '.$life_term;


                                $hero_box = get_field('hero_banner');
                                if (get_field('show_hero_banner') && $hero_box && is_array($hero_box) && count($hero_box) > 0) {
                                    foreach ($hero_box as $single) {
                                        $post_img_id = ( $single['image'] && is_array( $single['image'] ) && count( $single['image'] ) > 0 ) ? $single['image']['id'] : '';
                                        $post_img_class = ($single['image']['width'] > $single['image']['height']) ? 'wider' : 'higher';
                                    }
                                } else {
                                    if ( has_post_thumbnail() ) {
                                        $post_img_id = get_post_thumbnail_id();
                                        $post_img_data = wp_get_attachment_image_src( $post_img_id, $item_img_size, false );

                                        if ($post_img_data && is_array($post_img_data) && count($post_img_data) > 0) {
                                            $post_img_class = ($post_img_data[1] > $post_img_data[2]) ? 'wider' : 'higher';
                                        }
                                    }
                                }


                                if ($title && $url) {
                                    ?>
                                    <div class="grid-item <?php echo $item_class; ?>">
                                        <a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $title ); ?>">
                                            <span class="centered-img">
                                                <?php
                                                if ( $post_img_id ) {
                                                    echo wp_get_attachment_image( $post_img_id, $item_img_size, false, array('class' => $post_img_class) );
                                                }
                                                ?>
                                            </span>
                                            <?php
                                                if ( $title ) {
                                                    ?>
                                                    <h2 class="life-title"><?php echo $title; ?></h2>
                                                    <?php
                                                }
                                            ?>
                                        </a>
                                    </div>
                                    <?php
                                }

                            endwhile;
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                wp_reset_query();
            ?>
        </div>
    </section>

    <?php


get_footer();
 ?>