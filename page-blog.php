<?php
/**
 * Template Name: Articles
 */
get_header(); ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-articles">
        <div id="content"></div>
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <div class="articles-search">
                <form role="search" method="get" class="search-form" action="<?php echo home_url(); ?>">
                    <label>
                        <span class="screen-reader-text">Search for:</span>
                        <input type="search" class="search-field" placeholder="Search …" value="<?php echo trim(get_search_query()); ?>" name="s">
                    </label>
                    <input type="submit" class="search-submit" value="Search">
                </form>
            </div>

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
                            'posts_per_page'=> 12
                        );
                        $new_query = new WP_Query( $args );

                        if ($new_query->have_posts()) {
                            echo '<ul class="events-list news">';
                            while ( $new_query->have_posts() ) : $new_query->the_post();

                                get_template_part('inc/loop', 'news');

                            endwhile;
                            echo "</ul>";

                            get_template_part('inc/pagination');

                        } else {
                            echo '<p class="no-results">' . __('Sorry, articles not found...', 'fw_campers') . '</p>';
                        }

                        wp_reset_query();
                    ?>
                </div>

                <?php // get_sidebar(); ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>