<?php
get_header();

$post_id = get_the_ID();
$title = get_the_title();
$url = get_permalink();
$date = get_the_date(get_option('date_format'));

$archive_year  = get_the_time('Y');
$archive_month = get_the_time('m');
$archive_day   = get_the_time('d');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-article section-my-life-details">
        <div id="content" class="my-life-container">


            <?php

                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                $args = array(
                    'post_type'     => 'my_life',
                    'post_status'   => 'publish',
                    'posts_per_page' => -1,
                    'orderby'       => 'menu_order',
                    'order'         => 'ASC',
                    'paged'         => $paged,
                );

                $step_arr = [];
                $step_count = 0;

                $new_query = new WP_Query( $args );

                if ($new_query->have_posts()) :
                    ?>
                    <div id="my-life-nav" class="my-life-nav-box">
                        <h3 class="my-life-nav-title"><?php _e('More Activities','fw_campers'); ?></h3>
                        <ul class="my-life-nav">
                            <?php
                            while ( $new_query->have_posts() ) : $new_query->the_post();
                                $nav_title = get_the_title();
                                $nav_url = get_permalink();
                                $nav_active = (get_the_ID() === $post_id) ? 'class="active"' : '';
                                $item_img_size = 'medium';

                                $nav_hero_box = get_field('hero_banner');

                                if (get_field('show_hero_banner') && $nav_hero_box && is_array($nav_hero_box) && count($nav_hero_box) > 0) {
                                    foreach ($nav_hero_box as $single) {
                                        $post_nav_img_id = ( $single['image'] && is_array( $single['image'] ) && count( $single['image'] ) > 0 ) ? $single['image']['id'] : '';
                                        $post_nav_img_class = ($single['image']['width'] > $single['image']['height']) ? 'wider' : 'higher';
                                    }
                                } else {
                                    if ( has_post_thumbnail() ) {
                                        $post_nav_img_id = get_post_thumbnail_id();
                                        $post_nav_img_data = wp_get_attachment_image_src( $post_nav_img_id, $item_img_size, false );

                                        if ($post_nav_img_data && is_array($post_nav_img_data) && count($post_nav_img_data) > 0) {
                                            $post_nav_img_class = ($post_nav_img_data[1] > $post_nav_img_data[2]) ? 'wider' : 'higher';
                                        }
                                    }
                                }

                                if ($nav_url && $nav_title) :
                                    ?>
                                    <li <?php echo $nav_active; ?>>
                                        <div class="my-life-box">
                                            <a href="<?php echo esc_url($nav_url); ?>" title="<?php echo esc_attr(wp_strip_all_tags($nav_title)); ?>"><?php echo $nav_title; ?></a>
                                            <?php
                                            if ( $post_nav_img_id ) {
                                                echo '<div class="my-life-img-thumbnail centered-img">'.wp_get_attachment_image( $post_nav_img_id, $item_img_size, false, array('class' => $post_nav_img_class) ).'</div>';
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                endif;
                            endwhile;
                            ?>
                        </ul>
                    </div>
                    <?php
                endif;
            wp_reset_query();
            ?>

            <div class="my-life-content">
                <div class="my-life-content-box">
                    <?php get_template_part('inc/section', 'info'); ?>

                    <div class="content-box">
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                            <div class="article-box">
                                <div class="content">
                                    <?php the_content(); ?>
                                </div>
                            </div>

                        <?php endwhile; else: endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </section>

<?php get_footer(); ?>