<?php
/**
 * Template Name: Campers List
 */
get_header(); ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-products">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php
                if (get_current_user_id() == 1) {
                    $taxonomy = 'model_categories';
                    $categories = get_terms(array('taxonomy' => $taxonomy, 'orderby' => 'term_order', 'parent' => 0));

//                    var_dump($categories);
                }
            ?>

            <?php
                global $wp_query;

                $args = array(
                    'post_type'         => 'model',
                    'post_status'       => 'publish',
                    'posts_per_page'    => -1,
                    'orderby'           => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
                    'post_parent'       => 0

                );
                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {
                    echo '<ul class="products-list">';
                    while ( $new_query->have_posts() ) : $new_query->the_post();

                        get_template_part('inc/loop', 'model-all');

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