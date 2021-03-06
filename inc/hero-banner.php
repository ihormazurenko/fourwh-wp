<?php
if (is_post_type_archive('event') || is_tax('event_category')) {
    $id = 339;
} elseif (is_post_type_archive('video') || is_tax('video_category')) {
    $id = 1020;
} elseif (is_post_type_archive('model') || is_tax('model_sizes') || is_tax('model_categories')) {
    if (is_tax('model_sizes')) {
        $id = 1236;
    } elseif (is_tax('model_categories')) {
        $id = 2554;
    } else {
        $id = 1236;
    }
} elseif (is_page()) {
    $id = get_the_ID();
} else {
    $id = '';
}

if (is_tax('model_categories')) {
    $model_category_id = get_queried_object()->term_id;
    $model_category_info = get_field('model_category_info', 'model_categories_'.$model_category_id);

    if ($model_category_info && is_array($model_category_info) && count($model_category_info) > 0) {
//        $hero_image_url = $model_category_info['hero_image']['url'];
//        if ($hero_image_url) {
//            $hero_bg = 'style="background-image: url(' . $hero_image_url . ')"';
//
//            echo '<div class="section section-hero inverse without-content" ' . $hero_bg . '">
//                    <div class="container">
//                        <div class="hero-box"></div>
//                    </div>
//                </div>';
//        }
    }

} else {
    $show_hero_banner = get_field('show_hero_banner', $id);
    $hero_banner = get_field('hero_banner', $id);
    $hero_classes = '';
    $hero_title_classes = '';
    $hero_content_classes = '';
    $hero_bg = '';
    $hero_overlay = '';

    if (is_front_page()) {
        $hero_classes = 'vertical-line';
        $hero_content_classes = 'biggest';
    }

    if (is_singular('model')) {
        $hero_title_classes = 'big';
    }

    if (is_singular('my_life')) {
        $hero_title_classes = 'big';
    }

    if (is_page(1029)) {
        $hero_title_classes = 'big';
    }

    if ($show_hero_banner && ($hero_banner && is_array($hero_banner) && count($hero_banner) > 0)) {
        $hero_slide_count = count($hero_banner);

        if ($hero_slide_count > 1) {
            echo '<section class="section section-hero slider-hero inverse ' . $hero_classes . '">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">';
        }

        foreach ($hero_banner as $slide) {
            $show_video_bg = $slide['show_video_bg'];
            $video_bg_id = ($show_video_bg && trim($slide['video_bg'])) ? getVideoId(trim($slide['video_bg'])) : '';

            $hero_image = $slide['image'];
            if ($hero_image['sizes']['max-width-2800']) {
                $hero_image_url = $hero_image['sizes']['max-width-2800'];
                $hero_image_class = ($hero_image['sizes']['max-width-2800-width'] < $hero_image['sizes']['max-width-2800-height']) ? 'highest' : '';
            } else {
                $hero_image_url = $hero_image['url'];
                $hero_image_class = ($hero_image['width'] > $hero_image['height']) ? 'highest' : '';
            }

            $hero_content_group = $slide['title_group'];
            $hero_button_group = $slide['show_button'] ? $slide['button'] : '';
            $hero_button_class = 'btn blue';
            $hero_button = '';

            if ($hero_image_url || $hero_content_group || $hero_button) {
                if ($hero_content_group && is_array($hero_content_group) && count($hero_content_group) > 0) {
                    $hero_alignment = $hero_content_group['alignment'] ? $hero_content_group['alignment'] : 'align-left';
                    $hero_title = $hero_content_group['title'];
                    $hero_subtitle = $hero_content_group['subtitle'];
                    $hero_content = $hero_content_group['content'];
                    $hero_overlay = $hero_content_group['overlay'];

                    if (empty($hero_title) && is_singular('model')) {
                        $hero_title = get_the_title($id);
                    }
                }

                if ($hero_button_group && is_array($hero_button_group) && count($hero_button_group) > 0) {
                    $label = $hero_button_group['label'];
                    $link_type = $hero_button_group['link_type'];
                    $target = $hero_button_group['target'] ? 'target="_blank"' : '';

                    if ($link_type == 'internal') {
                        $link = $hero_button_group['internal_link'] ? $hero_button_group['internal_link'] : '';
                    } elseif ($link_type == 'external') {
                        $link = $hero_button_group['external_link'] ? $hero_button_group['external_link'] : '';
                    } elseif ($link_type == 'scrolling') {
                        $link = '#content';
                    } elseif ($link_type == 'video') {
                        $link = $hero_button_group['popup_video'] ? $hero_button_group['popup_video'] : '';
                        $hero_button_class = 'youtube-video';
                    } else {
                        $link = '';
                    }

                    if (!empty($label) && !empty($link)) {
                        $hero_button = '<a href="' . $link . '" class="'.$hero_button_class.'" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>';
                    }
                }

                $hero_classes .= ($hero_title || $hero_subtitle || $hero_content || $hero_button) ? ' ' : ' without-content';

                $hero_classes .= ($hero_overlay == 1) ? ' overlay' : '';  
                

                if ($hero_image_url) {
                    // $hero_bg = 'style="background-image: url(' . $hero_image_url . ')"';
                    $hero_bg = '';
                }

                if ($hero_slide_count > 1) {
                    echo '<div class="swiper-slide ' . $hero_alignment . ' '.$hero_image_class.'"  ' . $hero_bg . '>';
                } else {
                    echo '<div class="section section-hero inverse ' . $hero_alignment . ' ' . $hero_classes . ' '.$hero_image_class.'" ' . $hero_bg . '>';
                }
                
                echo wp_get_attachment_image( $hero_image['ID'], 'max-width-2800' );

                if ($video_bg_id) {
                    echo '<div id="vimeo-bg-frame_'.$video_bg_id.'"  class="videoWrapper" data-vid-id="'.$video_bg_id.'" ></div>';
                }

                echo '<div class="container">
                                <div class="hero-box">';
                if ($hero_title) {
                    echo '<h1 class="hero-title ' . $hero_title_classes . '">' . $hero_title . '</h1>';
                }
                if ($hero_subtitle) {
                    echo '<h2 class="hero-subtitle">' . $hero_subtitle . '</h2>';
                }
                if ($hero_content) {
                    echo '<div class="hero-desc content ' . $hero_content_classes . '">' . $hero_content . '</div>';
                }
                if ($hero_button) {
                    echo '<div class="hero-btn-box">' . $hero_button . '</div>';
                }


                echo '</div>
                            </div>
                        </div>';
            }
        }

        if ($hero_slide_count > 1) {
            echo '</div>
                        <div class="swiper-pagination"></div>
                    </div>
                </section>';
        }
    }
}