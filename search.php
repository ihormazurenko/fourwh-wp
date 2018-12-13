<?php get_header(); ?>

    <section class="section content-wrapper section-articles searsh">
        <div class="container">

            <h1 class="section-title"><?php printf( esc_html__( 'Search Results for: %s', 'fw_campers' ), '<span>' . trim(get_search_query()) . '</span>' ); ?></h1>

            <div class="content-with-sidebar">
                <div class="content-box">
                    <?php
                        if (have_posts()) {
                            echo '<ul class="article-list">';

                                while ( have_posts() ) : the_post();
                                    get_template_part('inc/loop', 'post');
                                endwhile;

                            echo "</ul>";

                            get_template_part('inc/pagination');

                        } else {
                            echo '<p class="no-results">Sorry, articles not found...</p>';
                        };
                    ?>
                </div>

                <?php get_sidebar(); ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>