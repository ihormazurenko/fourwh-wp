<?php
/**
 * Template Name: Events
 */
get_header();

date_default_timezone_set( get_option('timezone_string') );
$currentTime = date('Y-m-d H:i:s');

$id = is_page() ? get_the_ID() : 399;

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-events">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php
                $args = array(
                    'taxonomy' => 'event_category'
                );
                $terms = get_terms( $args );

                //category
                if ( is_array( $terms ) && count( $terms ) > 0) {
                    ?>
                    <div class="categories">
                        <ul>
                            <li>
                                <a class="btn blue small <?php echo isset($_GET['event_cat']) ? 'inverse' : 'active'; ?>" href="<?php echo get_permalink(); ?>" title="<?php esc_attr_e('All', 'fw_campers'); ?>"><?php _e('All', 'fw_campers'); ?></a>
                            </li>
                            <?php foreach ($terms as $value) {
                                $category_class = ( $value->slug === $_GET['event_cat']) ? 'active' : 'inverse'; ?>
                                <li>
                                    <a class="btn blue small <?php echo $category_class; ?>" href="<?php echo get_permalink() . '?event_cat=' . $value->slug; ?>" title="<?php echo esc_attr( $value->name ); ?>"><?php echo $value->name; ?></a>
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

                if (isset($_GET['event_cat'])) {
                    $slug = trim($_GET['event_cat']);

                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'event_category',
                            'field'    => 'slug',
                            'terms'    => $slug
                        )
                    );
                }

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