<?php
get_header();


$video_page_id = 1020;
$term = get_queried_object();


?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-how-videos">
        <div id="content"></div>
        <div class="container">

            <?php //get_template_part('inc/section', 'info'); ?>
            <h1 class="section-title smaller line">Videos: <?php print $term->name; ?></h1>
            <div class="section-desc content"><?php print $term->description ?></div>

            

            <?php

                $taxonomy = 'video_category';
                $categories = get_terms($taxonomy, array('orderby' => 'term_order', 'parent' => 0));

                //category
                if ( is_array( $categories ) && count( $categories ) > 0) {
                    ?>
                    <div class="categories">
                        <ul>
                            <li>
                                <a class="btn blue small inverse" href="<?php echo get_permalink($video_page_id); ?>" title="<?php esc_attr_e('All', 'fw_campers'); ?>"><?php _e('All', 'fw_campers'); ?></a>
                            </li>
                            <?php foreach ($categories as $term) {
                                if (is_tax( $taxonomy, (int)$term->term_id )) {
                                    $current_term_id = $term->term_id;
                                    $category_class = 'active';
                                } else {
                                    $current_term = '';
                                    $category_class = 'inverse';
                                }
                                ?>
                                <li>
                                    <a class="btn blue small <?php echo $category_class; ?> " href="<?php echo get_term_link((int)$term->term_id, $taxonomy); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $term->name; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                }

                //videos
                global $wp_query;

                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                $args = array(
                    'post_type'        => 'video',
                    'post_status'      => 'publish',
                    'paged'            => $paged,
                    'orderby' => 'date',
                    'order'   => 'DESC',
                );

                if (!empty($current_term_id)) {
                    $args['tax_query'][] = array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field'    => 'id',
                            'terms'    => $current_term_id
                        )
                    );
                }

                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {
                    echo '<div class="video-list content">';
                    while ( $new_query->have_posts() ) : $new_query->the_post();

                        get_template_part('inc/loop', 'video');

                    endwhile;
                    echo "</div>";

                    get_template_part('inc/pagination');

                } else {
                    echo '<p class="no-results">' . __('Sorry, videos not found...', 'fw_campers') . '</p>';
                }

                wp_reset_query();
            ?>

        </div>
    </section>

<?php get_footer(); ?>