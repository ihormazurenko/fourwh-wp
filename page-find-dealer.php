<?php
/**
 * Template Name: Find Dealer
 */
get_header();

global $fwc_coordinate, $fwc_google_map_key;

$show_map       = get_field('show_map');
$map_info_left  = get_field('map_info_left');
$map_info_right = get_field('map_info_right');

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-service-location">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <?php if ( $show_map ) : ?>
                <script src="//maps.googleapis.com/maps/api/js?key=<?php echo $fwc_google_map_key; ?>"></script>
                <div class="map-wrap">
                    <div id="map"></div>
                    <div class="map-contact-info">
                        <?php if ($map_info_left) : ?>
                            <div class="left-box">
                                <p><?php echo $map_info_left; ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($map_info_right) : ?>
                            <div class="right-box">
                                <p><?php echo $map_info_right; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
                global $wp_query;

                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = array(
                    'post_type'     => 'location',
                    'post_status'   => 'publish',
                    'orderby'       => 'name',
                    'order'         => 'DESC',
                    'paged'         => $paged,
                );
                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) {
                    echo '<ul class="service-list">';
                    while ( $new_query->have_posts() ) : $new_query->the_post();

                        get_template_part('inc/loop', 'location');

                    endwhile;
                    echo "</ul>";
                } else {
                    echo '<p class="no-results">' . __('Sorry, locations not found...', 'fw_campers') . '</p>';
                }

                wp_reset_query();

                if ( $show_map && is_array($fwc_coordinate) && count($fwc_coordinate) > 0 ) :
                   ?>
                    <script>
                        fwc_marker_url = "<?php echo get_bloginfo('template_url') . '/img/marker.png'; ?>";
                        fwc_arr = '<?php echo json_encode($fwc_coordinate); ?>';
                    </script>
                <?php endif; ?>
        </div>
    </section>

<?php get_footer(); ?>