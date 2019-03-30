<?php get_header(); ?>

    <section class="section content-wrapper section-articles searsh">
        <div id="content"></div>
        <div class="container">

            <h1 class="section-title"><?php printf( esc_html__( 'Search Results for: %s', 'fw_campers' ), '<span><i>' . trim(get_search_query()) . '</i></span>' ); ?></h1>

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
                            if ( is_search() ) {
                                ?>
                                    <p class="search-sorry-text"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fw_campers' ); ?></p>
                                    <?php get_search_form(); ?>
                                <?php
                            } else {
                                ?>
                                    <p class="search-sorry-text"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fw_campers' ); ?></p>
                                    <?php get_search_form(); ?>
                                <?php
                            }
                        };
                    ?>
                </div>

                <?php get_sidebar(); ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>