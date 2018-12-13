<?php
    $title = get_the_title();
    $url = get_permalink();
    $date = get_the_date(get_option('date_format'));

    $archive_year  = get_the_time('Y');
    $archive_month = get_the_time('m');
    $archive_day   = get_the_time('d');
?>

<li>
    <div class="article-box">
        <?php if (has_post_thumbnail()) { ?>
            <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                <div class="article-img-wrap">
                    <?php the_post_thumbnail('large', array(
                        'alt'   => esc_attr($title)
                    )); ?>
                </div>
            </a>
        <?php } ?>
        <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
            <h2 class="article-title"><?php echo $title; ?></h2>
        </a>
        <div class="article-info">
            <span>
                <?php _e('Published Date:', 'fw_campers'); ?>
                <a href="<?php echo get_day_link( $archive_year, $archive_month, $archive_day); ?>" class="date" title="<?php echo esc_attr($date); ?>"><?php echo $date; ?></a>
            </span>
            <span><?php _e('By', 'fw_campers'); ?> <?php the_author_posts_link(); ?></span>
        </div>
        <div class="content">
            <?php the_excerpt(); ?>
        </div>
    </div>
</li>