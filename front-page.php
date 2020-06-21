<?php get_header();

    $video_title        = get_field('video_title');
    $video_slider       = get_field('video_slider');

    $build_based        = get_field('build_based');
    $camper_photos      = get_field('camper_photos');
    $social_slider      = get_field('social_slider');
    $upcoming_events    = get_field('upcoming_events');
    $latest_news        = get_field('latest_news');

get_template_part('inc/hero', 'banner');
?>

<?php if (($video_slider && is_array($video_slider) && count($video_slider) > 0) || $video_title) {
    $video_slide_count = count($video_slider); ?>

    <section class="section section-meet-popup <?php if ($video_slide_count > 1) { echo 'slider-mode'; } ?>">
        <div id="content"></div>
        <div class="container">
            <?php
                if ($video_title) { echo '<h2 class="section-title">'.$video_title.'</h2>';}

                if ($video_slider) {

                    if ($video_slide_count > 1) {
                        echo '<div class="slider-video">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">';
                    }

                    foreach ($video_slider as $slide) {
                        $video_url = esc_url($slide['url']);

                        if (!empty($video_url)) {
                            $video_thumb_title  = $slide['title'] ? $slide['title'] : '';
                            $video_thumb_alt    = $video_thumb_title ? $video_thumb_title : $video_title;
                            $video_thumb_url    = $slide['img'] ? $slide['img']['sizes']['max-width-2800'] : getVideoThumbnail($video_url);

                            if ($video_slide_count > 1) {
                                echo '<div class="swiper-slide">
                                            <a href="'.$video_url.'?autoplay=1&muted=0&loop=1" class="youtube-video" title="'.esc_attr($video_thumb_alt).'">
                                                <div class="video-preview">'. wp_get_attachment_image( $slide['img']['ID'], 'max-width-2800' ).
                                                '</div>';
                                      echo '</a>';
                                            if ($video_thumb_title) {
                                                echo '<h3 class="swiper-video-title">' . $video_thumb_title . '</h3>';
                                            }
                                    echo '</div>';
                            } else {
                                echo '<a href="' . $video_url . '?autoplay=1&muted=0&loop=1" class="youtube-video" title="' . esc_attr($video_thumb_alt) . '">
                                        <div class="video-preview">
                                            <img src="' . $video_thumb_url . '" alt="' . esc_attr($video_thumb_alt) . '">
                                        </div>';
                                echo '</a>';
                                if ($video_thumb_title) {
                                    echo '<h3 class="swiper-video-title">' . $video_thumb_title . '</h3>';
                                }
                            }
                        }
                    }

                    if ($video_slide_count > 1) {
                        echo ' </div>
                                    <div class="custom-nav-box">
                                        <div class="swiper-custom-button-prev"></div>
                                        <div class="swiper-custom-button-next"></div>
                                    </div>
                                </div>
                            </div>';
                    }

                }
            ?>
        </div>
    </section>
<?php } ?>

<?php if ($build_based && is_array($build_based) && count($build_based) > 0) {
    $build_title = trim($build_based['title']) ? $build_based['title'] : '';
    $build_color_style = trim($build_based['color_style']) ? $build_based['color_style'] : '';
    $build_description = trim($build_based['description']) ? $build_based['description'] : '';
    $build_button = $build_based['button'];
    $build_button_class = '';
    $build_truck_id = ($build_based['truck_image'] && is_array($build_based['truck_image']) && count($build_based['truck_image']) > 0) ? $build_based['truck_image']['ID'] : '';
    $build_bg_id = ($build_based['background_image'] && is_array($build_based['background_image']) && count($build_based['background_image']) > 0) ? $build_based['background_image']['ID'] : '';
    $build_bg_url = ($build_based['background_image'] && is_array($build_based['background_image']) && count($build_based['background_image']) > 0) ? $build_based['background_image']['url'] : '';
    $build_class = '';

    if ($build_color_style == 'dark') {
        $build_class = 'dark';
        $build_button_class = 'dark';
    } elseif ($build_color_style == 'light') {
        $build_class = 'inverse';
        $build_button_class = 'white';
    } else {
        $build_class = 'dark';
        $build_button_class = 'dark';
    }

    if ($build_bg_url) {
        $build_class .= ' custom-bg';
    } else {
        $build_class .= '';
    }

    if ($build_title || $build_description || $build_button) { ?>
        <section class="section section-build-based <?php echo $build_class; ?>">
            <div class="container <?php ?>">
                <div class="container">
                <div class="right-box">
                    <div class="build-based-box">
                        <?php
                            if ($build_title) { echo '<h2 class="section-title">'.$build_title.'</h2>';}

                            if ($build_description) { echo '<div class="build-based-desc content big">'.$build_description.'</div>';}

                            if ($build_button && is_array($build_button) && count($build_button) > 0) {
                                $label = $build_button['label'];
                                $link_type = $build_button['link_type'];
                                $target = $build_button['target'] ? 'target="_blank"' : '';

                                if ($link_type == 'internal') {
                                    $link = $build_button['internal_link'] ? $build_button['internal_link'] : '';
                                } elseif ($link_type == 'external') {
                                    $link = $build_button['external_link'] ? $build_button['external_link'] : '';
                                } else {
                                    $link = '';
                                }

                                if (!empty($label) && !empty($link)) {
                                    echo '<div class="build-based-btn-box">
                                            <a href="' . $link . '" class="btn big '. $build_button_class .' inverse" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>
                                        </div>';
                                }
                            }
                        ?>
                    </div>
                </div>
                </div>

                <?php
                    if ($build_bg_id) {

//                        echo '<div class="custom-bg-box" style="background-image: url('.$build_bg_url.')">
                        echo '<div class="custom-bg-box">'.wp_get_attachment_image( $build_bg_id, 'max-width-2800').'</div>';
                    }
                ?>
            </div>
        </section>
    <?php }
} ?>


<?php if (current_user_can('administrator')) { ?>
    <?php if ($camper_photos && is_array($camper_photos) && count($camper_photos) > 0) {
        $camper_photo_title = get_field('camper_photo_title');

        ?>
        <section class="section section-camper-photos">
            <div class="container">
                <?php if ($camper_photo_title) { echo '<h2 class="section-title">'.$camper_photo_title.'</h2>';} ?>

                <div class="swiper-container camper-photos-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ($camper_photos as $photo) {
                            $photo_id = $photo['ID'];
                            $photo_full_url = $photo['url']; ?>

                            <div class="swiper-slide">
                                <a href="<?php echo esc_url($photo_full_url); ?>" title="<?php echo $camper_photo_title; ?>">
                                    <span class="centered-img">
                                        <?php echo wp_get_attachment_image( $photo_id, 'medium_large'); ?>
                                    </span>
                                </a>
                            </div>

                        <?php } ?>
                    </div>
                    <div class="custom-nav-box">
                        <div class="swiper-news-button-prev"></div>
                        <div class="swiper-news-button-next"></div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
<?php } ?>


<?php if ($latest_news && is_array($latest_news) && count($latest_news) > 0) {
    $show_latest_news = $latest_news['show_news'];

    if ($show_latest_news) {
        $latest_news_title = $latest_news['news_title'];
        $latest_news_article_count = $latest_news['article_count'] ? $latest_news['article_count'] : 8; ?>

        <section class="section section-upcoming-events">
            <div class="container">

                <?php if ($latest_news_title) { echo '<h2 class="section-title">'.$latest_news_title.'</h2>';} ?>

                <a href="<?php echo get_permalink(233); ?>" class="go-link" title="<?= esc_attr_x('All News', 'fw_campers'); ?>"><?= __('All News', 'fw_campers') ?></a>

                <?php
                    //events
                    global $wp_query;

                    $args = array(
                        'post_type'         => 'post',
                        'post_status'       => 'publish',
                        'posts_per_page'    => $latest_news_article_count,
                        'orderby'           => 'post_date',
                        'order'             => 'DESC',
                    );

                    $new_query = new WP_Query( $args );

                    if ($new_query->have_posts()) {
                        echo '<div class="events-list news">
                                <div class="swiper-container front-latest-news">
                                    <div class="swiper-wrapper">';

                        while ( $new_query->have_posts() ) : $new_query->the_post();

                            get_template_part('inc/loop', 'front-news');

                        endwhile;

                        echo   '</div>
                                <div class="custom-nav-box">
                                    <div class="swiper-news-button-prev"></div>
                                    <div class="swiper-news-button-next"></div>
                                </div>
                            </div>
                        </div>';
                    }

                    wp_reset_query();
                ?>
            </div>
        </section>

    <?php }
} ?>

<?php if ($social_slider && is_array($social_slider) && count($social_slider) > 0) { ?>
    <section class="section section-social-slider vertical-line">
        <div class="container">
            <h2 class="section-title">Stay Connected</h2>
            <div class="swiper-container social-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($social_slider as $slide) {
                        $slide_info_group       = ($slide['info_group'] && is_array($slide['info_group']) && count($slide['info_group']) > 0) ? $slide['info_group'] : '';
                        $slide_social_group     = ($slide['social_group'] && is_array($slide['social_group']) && count($slide['social_group']) > 0) ? $slide['social_group'] : '';

                        $slide_title            = ($slide_info_group && trim($slide_info_group['title'])) ? $slide_info_group['title'] : '';
                        $slide_without_title    = $slide_title ? '' : 'without-title';
                        $slide_description      = ($slide_info_group && trim($slide_info_group['description'])) ? $slide_info_group['description'] : '';
                        $slide_image            = $slide['image'];
                        $slide_image_id         = $slide_image['ID'] ? $slide_image['ID'] : '';

                        if ($slide_image['sizes']['size-720_720']) {
                            $slide_image_url    = $slide_image['sizes']['size-720_720'];
                            $slide_image_class  = ($slide_image['sizes']['size-720_720-width'] > $slide_image['sizes']['size-720_720-height']) ? 'wider' : '';
                        } else {
                            $slide_image_url    = $slide_image['url'];
                            $slide_image_class  = ($slide_image['width'] > $slide_image['height']) ? 'wider' : '';
                        }

                        $slide_style            = ($slide_social_group && $slide_social_group['slide_style']) ? $slide_social_group['slide_style'] : '';
                        $slide_url              = ($slide_social_group && trim($slide_social_group['link'])) ? $slide_social_group['link'] : '#';
                        $slide_icon_base        = get_bloginfo('template_url').'/img/';
                        $slide_icon             = '';
                        $slide_icon_alt         = '';
                        $slide_overlay_class    = '';
                        $slide_icon_class       = '';

                        if ($slide_title || $slide_description || $slide_image) {
                            if ($slide_style == 'facebook') {
                                $slide_icon             = 'icon_facebook.png';
                                $slide_icon_alt         = 'Facebook';
                                $slide_icon_class       = 'facebook';
                                $slide_overlay_class    = 'dark-overlay';
                            } elseif ($slide_style == 'instagram') {
                                $slide_icon             = 'icon_instagram.png';
                                $slide_icon_alt         = 'Instagram';
                                $slide_icon_class       = 'instagram';
                                $slide_overlay_class    = 'blue-overlay';
                            } elseif ($slide_style == 'pinterest') {
                                $slide_icon             = 'icon_pinterest.png';
                                $slide_icon_alt         = 'Pinterest';
                                $slide_icon_class       = 'pinterest';
                                $slide_overlay_class    = 'orange-overlay';
                            } elseif ($slide_style == 'youtube') {
                                $slide_icon             = 'icon_youtube.png';
                                $slide_icon_alt         = 'YouTube';
                                $slide_icon_class       = 'youtube';
                                $slide_overlay_class    = 'red-overlay';
                            } else {
                                $slide_icon = $slide_icon_alt = $slide_overlay_class = $slide_icon_class = '';
                            }
                        }

                        if ($slide_title || $slide_description || $slide_image || $slide_style) {
                            echo '<div class="swiper-slide">
                                    <a href="'.esc_url($slide_url).'" title="'.esc_attr($slide_title).'"  target="_blank" rel="nofollow">
                                        <div class="slide-box '.$slide_image_class.' '.$slide_overlay_class.' ">';
                                            if ($slide_image_id) {
//                                                echo '<img src="'.$slide_image_url.'" alt="'.esc_attr($slide_title).'">';
                                                echo wp_get_attachment_image($slide_image_id, 'medium', false, array('class' => 'social-slide-img lazyload'));
                                            }
                                            echo '<div class="slide-inner-box">
                                                    <div class="slider-social-table '.$slide_without_title.'">
                                                        <div class="slider-social-table-body">';
                                                            if ($slide_style) {
                                                                echo '<img src="'.$slide_icon_base.$slide_icon.'" alt="'.esc_attr($slide_icon_alt).'" class="slide-icon '.$slide_icon_class.'">';
                                                            }
                                                            if ($slide_title) {
                                                                echo '<h3 class="slide-title">'.$slide_title.'</h3>';
                                                            }
                                                 echo '</div>
                                                        <div class="slider-social-table-footer">';
                                                            if ($slide_description) {
                                                                echo '<p class="slide-desc">'.$slide_description.'</p>';
                                                            }
                                                  echo '</div>
                                                    </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>';
                        }
                    } ?>
                </div>
                <div class="social-nav-box">
                    <div class="swiper-social-button-prev"></div>
                    <div class="swiper-social-button-next"></div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>


<?php if ($upcoming_events && is_array($upcoming_events) && count($upcoming_events) > 0) {
    $show_upcoming_events = $upcoming_events['show'];

    if ($show_upcoming_events) {
        $upcoming_title = $upcoming_events['title'];
        $upcoming_event_count = $upcoming_events['event_count'] ? $upcoming_events['event_count'] : 4 ; ?>

        <section class="section section-upcoming-events">
            <div class="container">

                <?php if ($upcoming_title) { echo '<h2 class="section-title">'.$upcoming_title.'</h2>';} ?>

                <a href="<?php echo get_permalink(339); ?>" class="go-link" title="<?= esc_attr_x('All Events', 'fw_campers'); ?>"><?= __('All Events', 'fw_campers') ?></a>

                <?php
                    //events
                    global $wp_query;

                    //date_default_timezone_set( get_option('timezone_string') );
                    $currentTime = date('Y-m-d H:i:s');

                    $args = array(
                        'post_type'        => 'event',
                        'post_status'      => 'publish',
                        'posts_per_page'   => $upcoming_event_count,
                        'meta_query'       => array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'dates_end_U',
                                'value'   => $currentTime,
                                'compare' => '>=',
                                'type'    => 'DATE'
                            ),
                            'future_event' => array(
                                'key'  => 'dates_start_U',
                            )
                        ),
                        'orderby' => 'future_event',
                        'order'   => 'ASC',
                    );

                    $new_query = new WP_Query( $args );

                    if ($new_query->have_posts()) {
                        echo '<ul class="events-list">';
                        while ( $new_query->have_posts() ) : $new_query->the_post();

                            get_template_part('inc/loop', 'hero-event');

                        endwhile;
                        echo "</ul>";
                    }

                    wp_reset_query();
                ?>
            </div>
        </section>

    <?php }
} ?>

<?php get_footer(); ?>
