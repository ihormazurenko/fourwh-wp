<?php
    $title = get_the_title();
    $url = get_permalink();
    $date = get_the_date('F j, Y T');

    if (is_single()) {
        ?>
        <div class="article-box">
            <?php if (has_post_thumbnail()) { ?>
                <div class="article-img-wrap">
                    <?php the_post_thumbnail('full', array(
                        'alt'   => esc_attr($title)
                    )); ?>
                </div>
            <?php } ?>
            <h2 class="article-title"><?php echo $title; ?></h2>
            <div class="article-info">
                <span><?php _e('Published Date:', 'fw_campers'); ?> <?php echo $date; ?></span>
                <span><?php _e('By', 'fw_campers'); ?> <?php the_author_posts_link(); ?></span>
            </div>
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="article-box">
            <?php if (has_post_thumbnail()) { ?>
                <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                    <div class="article-img-wrap">
                        <?php the_post_thumbnail('full', array(
                            'alt'   => esc_attr($title)
                        )); ?>
                    </div>
                </a>
            <?php } ?>
            <a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($title); ?>">
                <h2 class="article-title"><?php echo $title; ?></h2>
            </a>
            <div class="article-info">
                <span><?php _e('Published Date:', 'fw_campers'); ?> <?php echo $date; ?></span>
                <span><?php _e('By', 'fw_campers'); ?> <?php the_author_posts_link(); ?></span>
            </div>
            <div class="content">
                <?php the_excerpt(); ?>
            </div>
        </div>
        <?php
    }


?>


