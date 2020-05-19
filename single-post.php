<?php
get_header();

$title = get_the_title();
$url = get_permalink();
$date = get_the_date(get_option('date_format'));

$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-article">
        <div id="content"></div>
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <div class="content-with-sidebar">
                <div class="content-box">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        <div class="article-box">
                            <?php if (has_post_thumbnail()) { ?>
                                <div class="article-img-wrap">
                                    <?php the_post_thumbnail('max-width-2800', array(
                                        'alt'   => esc_attr($title)
                                    )); ?>
                                </div>
                            <?php } ?>
                            <h2 class="article-title"><?php echo $title; ?></h2>
                            <div class="article-info">
                                <span>
                                    <?php _e('Published Date:', 'fw_campers'); ?>
                                    <a href="https://fourwheelcampers.com/" class="date" title="<?php echo esc_attr($date); ?>"><?php echo $date; ?></a>
                                </span>
                                <span><?php _e('By', 'fw_campers'); ?> <?php the_author_posts_link(); ?></span>
                            </div>
                            <div class="content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                    <?php endwhile; else: endif; ?>
                </div>

                <?php get_sidebar(); ?>

                <?php get_template_part('inc/section', 'related-news'); ?>

            </div>
        </div>
    </section>

<?php get_footer(); ?>