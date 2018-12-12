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
                                echo '<li>';
                                    get_template_part('inc/loop', 'post');
                                echo '</li>';
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
                <!--
                    <div id="search-2" class="widget widget_search">
                        <form role="search" method="get" class="search-form" action="https://americanbonehealth.org/">
                            <label>
                                <span class="screen-reader-text">Search News:</span>
                                <input type="search" class="search-field" placeholder="Search News" value="" name="s">
                            </label>
                            <input type="submit" class="search-submit" value="Search">
                        </form>
                    </div>
                    <div class="popular-posts">
                        <h3 class="widget-title">Popular News</h3>

                        <ul class="popular-posts-list">
                            <li>
                                <div class="popular-box">
                                    <a href="#" title="Campers Business">
                                        <div class="centered-img popular-img-wrap">
                                            <img src="img/popular_1.png" alt="Campers Business">
                                        </div>

                                        <div class="popular-info-box">
                                            <span class="popular-date">Jan-20- 2018</span>
                                            <h4 class="popular-title">Campers Business</h4>
                                            <p class="popular-desc">Established fact that likes on distracted readable</p>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="popular-box">
                                    <a href="#" title="Campers Business">
                                        <div class="centered-img popular-img-wrap">
                                            <img src="img/popular_2.png" alt="Campers Business">
                                        </div>

                                        <div class="popular-info-box">
                                            <span class="popular-date">Jan-20- 2018</span>
                                            <h4 class="popular-title">Campers Business</h4>
                                            <p class="popular-desc">Established fact that likes on distracted readable</p>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="popular-box">
                                    <a href="#" title="Campers Business">
                                        <div class="centered-img popular-img-wrap">
                                            <img src="img/popular_3.png" alt="Campers Business">
                                        </div>

                                        <div class="popular-info-box">
                                            <span class="popular-date">Jan-20- 2018</span>
                                            <h4 class="popular-title">Campers Business</h4>
                                            <p class="popular-desc">Established fact that likes on distracted readable</p>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    -->
            </div>
        </div>
    </section>

<?php get_footer(); ?>