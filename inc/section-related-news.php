<?php
    global $wp_query;

    $id = get_the_ID();
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
        'post_type'     => 'post',
        'post_status'   => 'publish',
        'post_per_page' => 3,
        'post__not_in'  => [ $id ],
        'orderby'       => 'date',
        'order'         => 'DESC',
        'paged'         => $paged,
    );
    $new_query = new WP_Query( $args );

    if ($new_query->have_posts()) {
        echo '<div class="related-news-box">
                <h2 class="group-title">'.__('Related News', 'fw_campers').'</h2>
                <ul class="related-news-list">';
                    while ( $new_query->have_posts() ) : $new_query->the_post();

                        get_template_part('inc/loop', 'related-news');

                    endwhile;
        echo '</ul>
            </div>';

        get_template_part('inc/pagination');

    }

    wp_reset_query();

