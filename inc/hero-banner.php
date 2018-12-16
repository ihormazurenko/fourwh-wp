<?php
if (is_post_type_archive('event') || is_tax('event_category')) {
    $id = 339;
} elseif (is_page()) {
    $id = get_the_ID();
} else {
    $id = '';
}

$show_hero_banner       = get_field('show_hero_banner', $id );
$hero_banner            = get_field('hero_banner', $id );
$hero_classes           = '';
$hero_title_classes     = '';
$hero_content_classes   = '';
$hero_bg                = '';

if (is_front_page()) {
    $hero_classes           = 'vertical-line';
    $hero_content_classes   = 'biggest';
}
if (is_singular('model')) {
    $hero_title_classes = 'big';
}

if ($show_hero_banner && ($hero_banner && is_array($hero_banner) && count($hero_banner) > 0)) {
    $hero_slide_count   = count($hero_banner);

    if ($hero_slide_count > 1) {
        echo '<section class="section section-hero slider-hero inverse '.$hero_classes.'">
                <div class="swiper-container">
                    <div class="swiper-wrapper">';
    }

        foreach ($hero_banner as $slide) {
            $hero_image         = $slide['image'];
            $hero_image_url     = $slide['image'];
            $hero_image_class   = ($hero_image['width'] > $hero_image['height']) ? 'wider' : '';
            $hero_content_group = $slide['title_group'];
            $hero_button_group  = $slide['show_button'] ? $slide['button'] : '';
            $hero_button        = '';

            if ($hero_image_url || $hero_content_group || $hero_button) {
                if ($hero_content_group && is_array($hero_content_group) && count($hero_content_group) > 0) {
                    $hero_title = $hero_content_group['title'];
                    $hero_subtitle = $hero_content_group['subtitle'];
                    $hero_content = $hero_content_group['content'];

                    if( empty($hero_title) && is_singular('model') ){
                        $hero_title = get_the_title( $id );
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
                    } else {
                        $link = '';
                    }

                    if (!empty($label) && !empty($link)) {
                        $hero_button = '<a href="' . $link . '" class="btn blue" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>';
                    }
                }

                $hero_classes .= ($hero_title || $hero_subtitle || $hero_content || $hero_button) ? ' 
                ' : ' without-content' ;

                if ($hero_image_url) {
                    $hero_bg = 'style="background-image: url('.$hero_image['url'].')"';
                }

                if ($hero_slide_count > 1) {
                    echo '<div class="swiper-slide" '.$hero_bg.'">';
                } else {
                    echo '<div class="section section-hero inverse '.$hero_classes.'" '.$hero_bg.'">';
                }
                echo  '<div class="container">
                            <div class="hero-box">';
                                if ($hero_title) { echo '<h1 class="hero-title '.$hero_title_classes.'">'.$hero_title.'</h1>'; }
                                if ($hero_subtitle) {echo '<h2 class="hero-subtitle">'.$hero_subtitle.'</h2>'; }
                                if ($hero_content) { echo '<div class="hero-desc content '.$hero_content_classes.'">'.$hero_content.'</div>'; }
                                if ($hero_button) { echo '<div class="hero-btn-box">'.$hero_button.'</div>'; }
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
