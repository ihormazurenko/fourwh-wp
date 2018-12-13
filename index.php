<?php get_header(); ?>

    <section class="section section-content content-wrapper">
        <div class="container">
            <?php the_title('<h1 class="section-title">', '</h1>'); ?>
            <div class="content">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <?php the_content(); ?>

                <?php endwhile; else: endif; ?>
            </div>
        </div>
    </section>

<?php get_footer(); ?>