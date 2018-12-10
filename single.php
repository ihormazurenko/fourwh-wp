<?php get_header(); ?>

    <div class="content-wrap">
        <div class="content">

            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <article>

                    <header>
                        <?php the_title('<h1>', '</h1>'); ?>
                    </header>

                    <section>
                        <?php the_content(); ?>
                    </section>

                </article>

            <?php endwhile; else: endif; ?>

        </div><!--/content-->

        <?php get_sidebar(); ?>

    </div><!--/content-wrap-->

<?php get_footer(); ?>