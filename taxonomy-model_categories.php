<?php
get_header();
$all_model_id           = 1236;
$flat_bad_model_id      = 2554;
?>

<?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-products">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php if (strpos(get_queried_object()->slug, 'flat-bed')) { ?>
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
            <?php } ?>

            <?php
            if ( have_posts() ) {
                echo '<ul class="products-list">';
                while ( have_posts() ) : the_post();

                    get_template_part('inc/loop', 'model');

                endwhile;
                echo '</ul>';
            } else {
                echo '<p class="no-results">' . __('Sorry, no models found...', 'fw_campers') . '</p>';
            }

            wp_reset_query();
            ?>

        </div>
    </section>

<?php get_footer(); ?>