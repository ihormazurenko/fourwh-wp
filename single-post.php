<?php get_header(); ?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-article">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <div class="content-with-sidebar">
                <div class="content-box">
                    <?php
                        if ( have_posts() ) : while ( have_posts() ) : the_post();
                            get_template_part('inc/loop', 'post');
                        endwhile; else: endif;
                    ?>
                </div>

                <?php get_sidebar(); ?>

                <?php get_template_part('inc/section', 'related-news'); ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>