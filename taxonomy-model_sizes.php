<?php
get_header();

?>

<?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-products">
        <div id="content"></div>
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php
            if ( have_posts() ) {
                echo '<ul class="models-list">';
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