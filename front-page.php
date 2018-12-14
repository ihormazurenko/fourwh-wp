<?php get_header();

    $video_title        = get_field('video_title');
    $video_slider       = get_field('video_slider');

    $build_based        = get_field('build_based');
    $social_slider      = get_field('social_slider');
    $upcoming_events    = get_field('upcoming_events');

get_template_part('inc/hero', 'banner');
?>

<?php if (($video_slider && is_array($video_slider) && count($video_slider) > 0) || $video_title) {
    $video_slide_count = count($video_slider); ?>

    <section class="section section-meet-popup <?php if ($video_slide_count > 1) { echo 'slider-mode'; } ?>">
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
                            $video_thumb_url = $slide['img'] ? $slide['img']['url'] : getVideoThumbnail($video_url);

                            if ($video_slide_count > 1) {
                                echo '<div class="swiper-slide">
                                            <a href="'.$video_url.'" class="youtube-video" title="'.esc_attr($video_title).'">
                                                <div class="video-preview">
                                                    <img src="'.$video_thumb_url.'" alt="'.esc_attr($video_title).'">
                                                </div>
                                            </a>
                                        </div>';
                            } else {
                                echo '<a href="' . $video_url . '" class="youtube-video" title="' . esc_attr($video_title) . '">
                                        <div class="video-preview">
                                            <img src="' . $video_thumb_url . '" alt="' . esc_attr($video_title) . '">
                                        </div>
                                    </a>';
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
    $build_title = $build_based['title'];
    $build_description = $build_based['description'];
    $build_button = $build_based['button'];

    if ($build_title || $build_description || $build_button) { ?>
        <section class="section section-build-based inverse">
            <div class="container">
                <div class="left-box">
                    <div class="four-truck-img-wrap">
                        <img class="" src="<?php echo get_bloginfo('template_url'); ?>/img/fourwh-truck.png" alt="Truck">
                    </div>
                </div>
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
                                            <a href="' . $link . '" class="btn white inverse big" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>
                                        </div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    <?php }
} ?>

<?php if ($social_slider && is_array($social_slider) && count($social_slider) > 0) { ?>
    <section class="section section-social-slider vertical-line">
        <div class="container">
            <div class="swiper-container social-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($social_slider as $slide) {
                        $slide_title            = $slide['title'];
                        $slide_without_title    = $slide_title ? '' : 'without-title';
                        $slide_description      = $slide['description'];
                        $slide_image            = $slide['image'];
                        $slide_image_class      = ($slide_image['width'] > $slide_image['height']) ? 'wider' : '';
                        $slide_style            = $slide['slide_style'];
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
                            } else {
                                $slide_icon = $slide_icon_alt = $slide_overlay_class = $slide_icon_class = '';
                            }
                        }

                        if ($slide_title || $slide_description || $slide_image || $slide_style) {
                            echo '<div class="swiper-slide">
                                    <a href="#" title="'.esc_attr($slide_title).'">
                                        <div class="slide-box '.$slide_image_class.' '.$slide_overlay_class.'">';
                                            if ($slide_image) {
                                                echo '<img src="'.$slide_image['url'].'" alt="'.esc_attr($slide_title).'">';
                                            }
                                            echo '<div class="slide-inner-box">
                                                    <div class="slider-social-table '.$slide_without_title.'">
                                                        <div class="slider-social-table-body">';
                                                            if ($slide_style) {
                                                                echo '<img src="'.$slide_icon_base.$slide_icon.'" alt="'.esc_attr($slide_icon_alt).'" class="'.$slide_icon_class.'">';
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

                <a href="#" class="go-link" title="<?= esc_attr_x('All Events', 'fw_campers'); ?>"><?= __('All Events', 'fw_campers') ?></a>

                <?php
                    //events
                    global $wp_query;

                    date_default_timezone_set( get_option('timezone_string') );
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
                <!--
                <ul class="events-list">
                    <li>
                        <a href="#" title="">
                            <div class="event-box">
                                <div class="event-img-wrap wider">
                                    <span class="event-date">07-12</span>
                                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/event_1.jpg" alt="">
                                </div>
                                <div class="event-info">
                                    <span class="event-location">Sacramento, CA</span>
                                    <h3 class="event-title">Saint-Tite Western no texts</h3>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="">
                            <div class="event-box">
                                <div class="event-img-wrap wider">
                                    <span class="event-date">15-19</span>
                                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/event_2.jpg" alt="">
                                </div>
                                <div class="event-info">
                                    <span class="event-location">Henderson, NV</span>
                                    <h3 class="event-title">Saint-Tite Western no texts</h3>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="">
                            <div class="event-box">
                                <div class="event-img-wrap wider">
                                    <span class="event-date">15-19</span>
                                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/event_3.jpg" alt="">
                                </div>
                                <div class="event-info">
                                    <span class="event-location">Denver, CO</span>
                                    <h3 class="event-title">Saint-Tite Western no texts</h3>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="">
                            <div class="event-box">
                                <div class="event-img-wrap wider">
                                    <span class="event-date">07-12</span>
                                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/event_4.jpg" alt="">
                                </div>
                                <div class="event-info">
                                    <span class="event-location">Sacramento, CA</span>
                                    <h3 class="event-title">Saint-Tite Western no texts</h3>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul> -->
            </div>
        </section>

    <?php }
} ?>

<?php get_footer(); ?>