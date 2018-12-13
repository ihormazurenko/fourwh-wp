<?php
/**
 * Template Name: Articles
 */
get_header(); ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-articles">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <div class="content-with-sidebar">
                <div class="content-box">
                    <?php
                        global $wp_query;

                        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                        $args = array(
                            'post_type'     => 'post',
                            'post_status'   => 'publish',
                            'orderby'       => 'date',
                            'order'         => 'DESC',
                            'paged'         => $paged,
                        );
                        $new_query = new WP_Query( $args );

                        if ($new_query->have_posts()) {
                            echo '<ul class="article-list">';
                            while ( $new_query->have_posts() ) : $new_query->the_post();

                                get_template_part('inc/loop', 'post');

                            endwhile;
                            echo "</ul>";

                            get_template_part('inc/pagination');

                        } else {
                            echo '<p class="no-results">Sorry, articles not found...</p>';
                        }

                        wp_reset_query();
                    ?>
                </div>

                <?php get_sidebar(); ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>