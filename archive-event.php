<?php
/**
 * Template Name: Events
 */
get_header();

date_default_timezone_set( get_option('timezone_string') );
$currentTime = date('Y-m-d H:i:s');

$event_page_id = is_page() ? get_the_ID() : 339;

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-events">
        <div id="content"></div>
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php

                $taxonomy = 'event_category';
                $categories = get_terms($taxonomy, array('orderby' => 'term_order', 'parent' => 0));

                //category
                if ( is_array( $categories ) && count( $categories ) > 0) {
                    ?>
                    <div class="categories">
                        <ul>
                            <li>
                                <a class="btn blue small active" href="<?php echo get_permalink($event_page_id); ?>" title="<?php esc_attr_e('All', 'fw_campers'); ?>"><?php _e('All', 'fw_campers'); ?></a>
                            </li>
                            <?php foreach ($categories as $term) { ?>
                                <li>
                                    <a class="btn blue small inverse" href="<?php echo get_term_link((int)$term->term_id, $taxonomy); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $term->name; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                }

                //events
                global $wp_query;

                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                $args = array(
                    'post_type'        => 'event',
                    'post_status'      => 'publish',
                    'paged'            => $paged,
                    'meta_query'       => array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'dates_end_U',
                            'value'   => $currentTime,
                            'compare' => '>=',
                            'type'    => 'DATE'
                        ),
                        'future_event' => array(
                                'key'  => 'dates_start_U',
                            )
                    ),
                    'orderby' => 'future_event',
                    'order'   => 'ASC',
                );

                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {
                    echo '<div class="video-list content">';
                    while ( $new_query->have_posts() ) : $new_query->the_post();

                        get_template_part('inc/loop', 'event');

                    endwhile;
                    echo "</div>";

                    get_template_part('inc/pagination');

                } else {
                    echo '<p class="no-results">' . __('Sorry, events not found...', 'fw_campers') . '</p>';
                }

                wp_reset_query();
            ?>

        </div>
    </section>

<?php get_footer(); ?>