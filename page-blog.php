<?php
/**
 * Template Name: Articles
 */
get_header(); ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-articles">
        <div class="container">
            <h1 class="section-title smaller line">Latest Articles</h1>
            <div class="section-desc content">
                <p>There are many variations of passages of Lorem Ipsum available,
                    but the majority have suffered alteration in some form, by injected humour or randomised </p>
            </div>

            <div class="content-with-sidebar">
                <div class="content-box">
                    <?php global $wp_query;

                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type'     => 'post',
                        'post_status'   => 'publish',
                        'orderby'       => 'date',
                        'order'         => 'DESC',
                        'paged'         => $paged,
                    );
                    $new_query = new WP_Query( $args );

                    if ( $new_query->have_posts() ) : while ( $new_query->have_posts() ) : $new_query->the_post();
                        ?>
                        <?php get_template_part('inc/loop', 'post'); ?>

                    <?php endwhile; ?>

                        <?php // wp_pagenavi( array( 'query' => $new_query ) ); ?>

                    <?php else: echo "<p class='no-results'>Sorry, articles not found...</p>";

                    endif; wp_reset_query(); ?>
                    <!--
                    <ul class="article-list">
                        <li>
                            <div class="article-box">
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <div class="article-img-wrap">
                                        <img src="img/article_1.jpg" alt="Four Wheel Business is Amazing">
                                    </div>
                                </a>
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <h2 class="article-title">Four Wheel Business is Amazing</h2>
                                </a>
                                <div class="article-info"> Published Date: 22 september 2018 By <a href="#" title="Nikil Shorma">Nikil Shorma</a></div>
                                <div class="content">
                                    <p>Business to popular belief, Lorem Ipsum is not simply random text.
                                        It has roots in a piece of classica Latin literature from 45 BC,
                                        making it over 2000 years old. Richard McClintock very impottant
                                        an trending business for sturt upIt is a long established fact that
                                        a reader will be distracted by the reads readable content of a page
                                        when looking at its layout. The point of using Lorem Ipsum is tha it has
                                        more-or-less normal distribution of letters, as opposed to using
                                        'Content here, content here', making it look like readable English.
                                        Many desktop publishing packages...</p>
                                    <p>Business to popular belief, Lorem Ipsum is not simply random text.
                                        It has roots in a piece of classical Latin literature from 45 BC,
                                        making it over 2000 years old. Richard McClintock very impottant
                                        and trending business for sturt upIt is a long
                                        established. <a class="read-more" href="article-details.html" title="Read More">Read More...</a></p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="article-box">
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <div class="article-img-wrap">
                                        <img src="img/article_2.jpg" alt="Four Wheel Business is Amazing">
                                    </div>
                                </a>
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <h2 class="article-title">Four Wheel Business is Amazing</h2>
                                </a>
                                <div class="article-info"> Published Date: 22 september 2018 By <a href="#" title="Nikil Shorma">Nikil Shorma</a></div>
                                <div class="content">
                                    <p>Business to popular belief, Lorem Ipsum is not simply random text.
                                        It has roots in a piece of classica Latin literature from 45 BC, making
                                        it over 2000 years old. Richard McClintock very impottant  an trending
                                        business for sturt upIt is a long established fact that a reader will be
                                        distracted by the reads readable content of a page when looking at its layout.
                                        The point of using Lorem Ipsum is tha it has more-or-less normal distribution
                                        of letters, as opposed to using 'Content here, content here', making it look
                                        like readable English. Many desktop publishing packages.Business to popular belief,
                                        Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                        Latin literature from 45 BC, making it over 2000 years old. Richard McClintock
                                        very impottant  and trending business for sturt upIt is a long
                                        established. <a class="read-more" href="article-details.html" title="Read More">Read More...</a></p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="article-box">
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <div class="article-img-wrap">
                                        <img src="img/article_3.jpg" alt="Four Wheel Business is Amazing">
                                    </div>
                                </a>
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <h2 class="article-title">Four Wheel Business is Amazing</h2>
                                </a>
                                <div class="article-info"> Published Date: 22 september 2018 By <a href="#" title="Nikil Shorma">Nikil Shorma</a></div>
                                <div class="content">
                                    <p>Business to popular belief, Lorem Ipsum is not simply random text.
                                        It has roots in a piece of classica Latin literature from 45 BC, making
                                        it over 2000 years old. Richard McClintock very impottant  an trending
                                        business for sturt upIt is a long established fact that a reader will be
                                        distracted by the reads readable content of a page when looking at its layout.
                                        The point of using Lorem Ipsum is tha it has more-or-less normal distribution
                                        of letters, as opposed to using 'Content here, content here', making it look
                                        like readable English. Many desktop publishing packages.Business to popular belief,
                                        Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                        Latin literature from 45 BC, making it over 2000 years old. Richard McClintock
                                        very impottant  and trending business for sturt upIt is a long
                                        established. <a class="read-more" href="article-details.html" title="Read More">Read More...</a></p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="article-box">
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <div class="article-img-wrap">
                                        <img src="img/article_4.jpg" alt="Four Wheel Business is Amazing">
                                    </div>
                                </a>
                                <a href="article-details.html" title="Four Wheel Business is Amazing">
                                    <h2 class="article-title">Four Wheel Business is Amazing</h2>
                                </a>
                                <div class="article-info"> Published Date: 22 september 2018 By <a href="#" title="Nikil Shorma">Nikil Shorma</a></div>
                                <div class="content">
                                    <p>Business to popular belief, Lorem Ipsum is not simply random text.
                                        It has roots in a piece of classica Latin literature from 45 BC, making
                                        it over 2000 years old. Richard McClintock very impottant  an trending
                                        business for sturt upIt is a long established fact that a reader will be
                                        distracted by the reads readable content of a page when looking at its layout.
                                        The point of using Lorem Ipsum is tha it has more-or-less normal distribution
                                        of letters, as opposed to using 'Content here, content here', making it look
                                        like readable English. Many desktop publishing packages.Business to popular belief,
                                        Lorem Ipsum is not simply random text. It has roots in a piece of classical
                                        Latin literature from 45 BC, making it over 2000 years old. Richard McClintock
                                        very impottant  and trending business for sturt upIt is a long
                                        established. <a class="read-more" href="article-details.html" title="Read More">Read More...</a></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    -->
                </div>
                <div class="sidebar">
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
        </div>
    </section>

<?php get_footer(); ?>