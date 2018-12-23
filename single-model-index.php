<?php
$title = get_the_title();
$show_section_floorplans        = get_field('show_section_floorplans');
$floorplans                     = get_field('floorplans');

$show_section_virtual_tour      = get_field('show_section_virtual_tour');
$virtual_tour                   = get_field('virtual_tour');

$show_section_specifications    = get_field('show_section_specifications');
$specifications                 = get_field('specifications');

$show_section_fabric_selection  = get_field('show_section_fabric_selection');
$fabric_selection               = get_field('fabric_selection');

$show_section_siding            = get_field('show_section_siding');
$siding                         = get_field('siding');

$show_section_key_benefits      = get_field('show_section_key_benefits');
$key_benefits                   = get_field('key_benefits');

$show_section_download          = get_field('show_section_download');
$download                       = get_field('download');

//from Theme Option
$show_subscribe_section         = get_field('show_subscribe_section', 'option');
$subscribe                      = get_field('subscribe', 'option');

$show_info_box_1                = get_field('show_info_box_1', 'option');
$info_box_1                     = get_field('info_box_1', 'option');

$show_info_box_2                = get_field('show_info_box_2', 'option');
$info_box_2                     = get_field('info_box_2', 'option');

$show_info_box_3                = get_field('show_info_box_3', 'option');
$info_box_3                     = get_field('info_box_3', 'option');

$enable_customizer              = get_field('enable_customizer');
$build_url                      = $enable_customizer ? 'build/' : '';

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <?php if ( $show_section_floorplans || $show_section_virtual_tour || $show_section_specifications || $show_section_fabric_selection || $show_section_siding || $show_section_key_benefits ) : ?>
        <div class="anchor-nav-box details">
            <div class="container">
                <nav class="anchor-nav">
                    <ul>
                        <?php if ( $floorplans ) { ?>
                            <li>
                                <a href="#floorplans" title="<?php esc_attr_e('Floorplans', 'fw_campers') ?>"><?php _e('Floorplans', 'fw_campers'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if ( $virtual_tour ) { ?>
                            <li>
                                <a href="#virtual-tour" title="<?php esc_attr_e('Virtual Tour', 'fw_campers') ?>"><?php _e('Virtual Tour', 'fw_campers'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if ( $specifications ) {?>
                            <li>
                                <a href="#specifications" title="<?php esc_attr_e('Specifications', 'fw_campers') ?>"><?php _e('Specifications', 'fw_campers'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if ( $fabric_selection ) {?>
                            <li>
                                <a href="#fabric-selection" title="<?php esc_attr_e('Fabric Selection', 'fw_campers') ?>"><?php _e('Fabric Selection', 'fw_campers'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if ( $siding ) {?>
                            <li>
                                <a href="#siding" title="<?php esc_attr_e('Siding', 'fw_campers') ?>"><?php _e('Siding', 'fw_campers'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if ( $key_benefits ) {?>
                            <li>
                                <a href="#key-benefits" title="<?php esc_attr_e('Key Benefits', 'fw_campers') ?>"><?php _e('Key Benefits', 'fw_campers'); ?></a>
                            </li>
                        <?php } ?>
                        <li class="anchor-btn-list">
                            <ul>
                                <li>
                                    <a href="#" class="btn blue inverse" title="<?php esc_attr_e('Brochure', 'fw_campers') ?>"><?php _e('Brochure', 'fw_campers'); ?></a>
                                </li>
                                <li>
                                    <a href="#" class="btn blue inverse" title="<?php esc_attr_e('Get a Quote', 'fw_campers') ?>"><?php _e('Get a Quote', 'fw_campers'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo get_permalink() . $build_url; ?>" class="btn blue" title="<?php esc_attr_e('Build', 'fw_campers') ?>"><?php _e('Build', 'fw_campers'); ?></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    <?php endif; ?>

    <section class="section section-camper-details">

        <?php
            if ( $show_section_floorplans && $floorplans && is_array( $floorplans ) && count( $floorplans ) > 0) :
                $floorplans_title       = $floorplans['title'];
                $floorplans_description = $floorplans['description'];
                $floorplans_slider      = $floorplans['slider'];

                if ( $floorplans_title || $floorplans_description || $floorplans_slider ) :
                    ?>
                    <div class="detail-box" id="floorplans">
                        <div class="container">
                        <?php
                            if ( $floorplans_title ) {
                                echo '<h2 class="section-title smaller">' . $floorplans_title . '</h2>';
                            }
                            if ( $floorplans_description ) {
                                echo '<div class="section-desc content">' . $floorplans_description . '</div>';
                            }

                            if ( $floorplans_slider && is_array( $floorplans_slider ) && count( $floorplans_slider ) > 0 ) {
                                ?>
                                <div class="slider-plan">
                                    <!-- Swiper -->
                                    <div class="swiper-container gallery-top">
                                        <div class="swiper-wrapper">
                                            <?php
                                                foreach ( $floorplans_slider as $slide ) {
                                                    $slide_url = $slide['image']['url'];
                                                    $slide_alt = $slide['short_title'] ? $slide['short_title'] :  $slide['image']['title'];
                                                    ?>
                                                    <div class="swiper-slide">
                                                        <img src="<?php echo esc_url( $slide_url ); ?>" alt="<?php echo esc_attr( $slide_alt );?>">
                                                    </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="swiper-container gallery-thumbs">
                                        <div class="swiper-wrapper">
                                            <?php
                                                foreach ( $floorplans_slider as $slide ) {
                                                    $slide_url = $slide['image']['sizes']['medium'] ? $slide['image']['sizes']['medium'] : $slide['image']['url'];
                                                    $slide_alt = $slide['short_title'] ? $slide['short_title'] :  $slide['image']['title'];
                                                    $slide_title = $slide['short_title'];
                                                    $slide_class = $slide['image']['width'] > $slide['image']['height'] ? 'wider' : '' ;
                                                    ?>
                                                    <div class="swiper-slide">
                                                        <div class="slide-img-wrap <?php echo $slide_class; ?>">
                                                            <img src="<?php echo esc_url( $slide_url ); ?>" alt="<?php echo esc_attr( $slide_alt );?>">
                                                        </div>
                                                        <?php if ( $slide_title ) { ?>
                                                            <div class="slide-title-box">
                                                                <h3 class="slide-title"><?php echo $slide_title; ?></h3>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                endif;
            endif;
        ?>

        <?php
            if ( $show_section_virtual_tour && $virtual_tour && is_array( $virtual_tour ) && count( $virtual_tour ) > 0) :
                $virtual_tour_title       = $virtual_tour['title'];
                $virtual_tour_description = $virtual_tour['description'];
                $virtual_tour_img_url     = $virtual_tour['image']['url'];
                $virtual_tour_img_alt     = $virtual_tour_title ? $virtual_tour_title :  $virtual_tour['image']['title'];

                if ($virtual_tour_title || $virtual_tour_description || $virtual_tour_img_url) :
                    ?>
                    <div class="detail-box videotour" id="virtual-tour">
                        <div class="container">
                        <?php
                            if ( $virtual_tour_title ) {
                                echo '<h2 class="section-title smaller">' . $virtual_tour_title . '</h2>';
                            }

                            if ( $virtual_tour_description ) {
                                echo '<div class="section-desc content">' . $virtual_tour_description . '</div>';
                            }

                            if ( $virtual_tour_img_url ) {
                                echo '<div class="detail-img-wrap">
                                        <img src="' . $virtual_tour_img_url . '" alt="' . esc_attr( $virtual_tour_img_alt ) . '">
                                    </div>';
                            }
                        ?>
                        </div>
                    </div>
                    <?php
                endif;
            endif;
        ?>

        <?php
            if ( $show_section_specifications && $specifications && is_array( $specifications ) && count( $specifications ) > 0 ) :
                $specifications_title       = $specifications['title'];
                $specifications_description = $specifications['description'];
                $specifications_img_url     = $specifications['image']['sizes']['medium_large'] ? $specifications['image']['sizes']['medium_large'] : $specifications['image']['url'];
                $specifications_img_alt     = $specifications_title ? $specifications_title :  $specifications['image']['title'];
                $specifications_accordion   = $specifications['accordion'];

                if ($specifications_title || $specifications_description || $specifications_img_url || $specifications_accordion) :
                    ?>
                        <div class="detail-box" id="specifications">
                            <div class="container">
                                <?php
                                if ( $specifications_title ) {
                                    echo '<h2 class="section-title smaller">' . $specifications_title . '</h2>';
                                }

                                if ( $specifications_description ) {
                                    echo '<div class="section-desc content">' . $specifications_description . '</div>';
                                }

                                if ( $virtual_tour_img_url ) {
                                    echo '<div class="left-box">
                                            <div class="detail-img-wrap">
                                                <img src="' . $specifications_img_url . '" alt="' . esc_attr( $specifications_img_alt ) . '">
                                            </div>
                                        </div>';
                                }

                                if ( $specifications_accordion && is_array( $specifications_accordion ) && count( $specifications_accordion ) > 0 ) :
                                ?>
                                    <div class="right-box">
                                        <div class="specifications-accordion content">
                                            <?php
                                                foreach ($specifications_accordion as $item ) {
                                                    $item_title     = $item['title'];
                                                    $item_content   = $item['content'];

                                                    if ($item_title || $item_content) {
                                                        ?>
                                                            <div class="accordion-box">
                                                                <?php if ( $item_title ) { ?>
                                                                    <h4 class="accordion active"><?php echo $item_title; ?> <i class="fa fa-chevron-down"></i></h4>
                                                                <?php } ?>
                                                                <?php if ( $item_content ) { ?>
                                                                    <div class="panel">
                                                                        <div class="inner-box">
                                                                          <?php echo $item_content; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                endif;
            endif;
        ?>

        <?php
            if ( $show_section_fabric_selection && $fabric_selection && is_array( $fabric_selection ) && count( $fabric_selection ) > 0 ) :
                $fabric_title       = $fabric_selection['title'];
                $fabric_description = $fabric_selection['description'];
                $fabric_slider      = $fabric_selection['slider'];

                if ( $fabric_title || $fabric_description || $fabric_slider ) :
                    ?>
                        <div class="detail-box" id="fabric-selection">
                            <div class="container">
                                <?php
                                    if ( $fabric_title ) {
                                        echo '<h2 class="section-title smaller">' . $fabric_title . '</h2>';
                                    }

                                    if ( $fabric_description ) {
                                        echo '<div class="section-desc content">' . $fabric_description . '</div>';
                                    }

                                    if ( $fabric_slider && is_array( $fabric_slider ) && count( $fabric_slider ) > 0 ) :
                                        ?>
                                        <div class="slider-vertical">
                                        <!-- Swiper -->
                                        <div class="swiper-container gallery-right">
                                            <div class="swiper-wrapper">
                                                <?php
                                                    foreach ( $fabric_slider as $slide ) {
                                                        $slide_url = $slide['sizes']['large'] ? $slide['sizes']['large'] : $slide['url'];
                                                        $slide_alt = $slide['title'];
                                                        $slide_class = $slide['width'] > $slide['height'] ? 'wider' : '' ;
                                                            ?>
                                                            <div class="swiper-slide">
                                                                <div class="slide-img-wrap <?php echo $slide_class; ?>">
                                                                    <img src="<?php echo esc_url( $slide_url ); ?>" alt="<?php echo esc_attr( $slide_alt ); ?>">
                                                                </div>
                                                            </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="swiper-container gallery-thumbs-left">
                                            <div class="swiper-wrapper">
                                                <?php
                                                    foreach ( $fabric_slider as $slide ) {
                                                        $slide_url = $slide['sizes']['medium'] ? $slide['sizes']['medium'] : $slide['url'];
                                                        $slide_alt = $slide['title'];
                                                        $slide_class = $slide['width'] > $slide['height'] ? 'wider' : '' ;
                                                        ?>
                                                        <div class="swiper-slide">
                                                            <div class="slide-img-wrap <?php echo $slide_class; ?>">
                                                                <img src="<?php echo esc_url( $slide_url ); ?>" alt="<?php echo esc_attr( $slide_alt ); ?>">
                                                            </div>
                                                        </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                            </div>
                        </div>
                    <?php
                endif;
            endif;
        ?>

        <?php
            if ( $show_section_siding && $siding && is_array( $siding ) && count( $siding ) > 0) :
                $siding_title       = $siding['title'];
                $siding_description = $siding['description'];
                $siding_slider      = $siding['slider'];

                if ( $siding_title || $siding_description || $siding_slider ) :
                    ?>
                     <div class="detail-box" id="siding">
                        <div class="container">
                        <?php
                            if ( $siding_title ) {
                                echo '<h2 class="section-title smaller">' . $siding_title . '</h2>';
                            }

                            if ( $siding_description ) {
                                echo '<div class="section-desc content">' . $siding_description . '</div>';
                            }

                            if ( $siding_slider && is_array( $siding_slider ) && count( $siding_slider ) > 0 ) :
                            ?>
                            <div class="slider-swatch">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <?php
                                            foreach ( $siding_slider as $slide ) {
                                                $slide_url = $slide['sizes']['medium_large'] ? $slide['sizes']['medium_large'] : $slide['url'];
                                                $slide_alt = $slide['title'];
                                                $slide_class = $slide['width'] > $slide['height'] ? 'wider' : '' ;
                                                ?>
                                                    <div class="swiper-slide">
                                                        <div class="slide-img-wrap <?php echo $slide_class; ?>">
                                                            <img src="<?php echo esc_url( $slide_url ); ?>" alt="<?php echo esc_attr( $slide_alt ); ?>">
                                                        </div>
                                                    </div>
                                        <?php } ?>
                                    </div>
                                    <div class="swatch-nav-box">
                                        <div class="swiper-swatch-button-prev btn blue"><i class="fas fa-long-arrow-alt-left"></i> Previous</div>
                                        <div class="swiper-swatch-button-next btn blue">Next <i class="fas fa-long-arrow-alt-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                endif;
            endif;
        ?>

        <?php
            if ( $show_section_key_benefits && $key_benefits && is_array( $key_benefits ) && count( $key_benefits ) > 0) :
                $benefits_title       = $key_benefits['title'];
                $benefits_description = $key_benefits['description'];
                $benefits_list        = $key_benefits['benefits_list'];

                if ( $siding_title || $siding_description || $siding_slider ) :
                ?>
                    <div class="detail-box" id="key-benefits">
                        <div class="container">
                        <?php
                            if ( $benefits_title ) {
                                echo '<h2 class="section-title smaller">' . $benefits_title . '</h2>';
                            }

                            if ( $benefits_description ) {
                                echo '<div class="section-desc content">' . $benefits_description . '</div>';
                            }

                            if ( $benefits_list && is_array( $benefits_list ) && count( $benefits_list ) > 0 ) :
                                ?>
                                <div class="benefits-list-box">
                                    <ul class="benefits-list">
                                         <?php foreach ( $benefits_list as $value ) { ?>
                                            <li>
                                                <div class="benefits">
                                                    <?php echo $value['text']; ?>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                endif;
            endif;
        ?>

        <?php if ( $show_section_download && $download && is_array( $download ) && count( $download ) > 0) : ?>
            <div class="detail-box" id="download">
                <div class="container">
                    <div class="download-btn-list-box">
                        <ul class="download-btn-list">
                            <?php foreach ( $download as $item ) {
                                $download_download_type = $item['download_type'];
                                $download_label = $item['label'];
                                $download_target = $item['target'] ? 'target="_blank" rel="nofollow noopener"' : '';
                                $download_url = '';

                                    if ( $download_download_type == 'file' ) {
                                        $download_url = $item['file'];
                                    } elseif ( $download_download_type == 'internal' ) {
                                        $download_url = $item['internal_link'];
                                    } elseif ( $download_download_type == 'external' ) {
                                        $download_url = $item['external_link'];
                                    } else {
                                        $download_url = '';
                                    }

                                    if ($download_url && $download_label) {
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url( $download_url ); ?>" class="btn blue download" title="<?php echo esc_attr( strip_tags($download_label) ); ?>" <?php echo $download_target; ?>><?php echo $download_label; ?></a>
                                        </li>
                                        <?php
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php if ( $show_info_box_1 || $show_info_box_2 || $show_info_box_3 ) :
        $info_boxes = [];

        if ( $info_box_1 && is_array( $info_box_1 ) && count( $info_box_1 ) > 0 ) {
            $info_box_1['default_icon'] = get_bloginfo('template_url') . '/img/icon_topog.png';
            $info_boxes[] = $info_box_1;
        }
        if ( $info_box_2 && is_array( $info_box_2 ) && count( $info_box_2 ) > 0 ) {
            $info_box_2['default_icon'] = get_bloginfo('template_url') . '/img/icon_build.png';
            $info_boxes[] = $info_box_2;
        }
        if ( $info_box_3 && is_array( $info_box_3 ) && count( $info_box_3 ) > 0 ) {
            $info_box_3['default_icon'] = get_bloginfo('template_url') . '/img/icon_search.png';
            $info_boxes[] = $info_box_3;
        }

        ?>
        <?php if ( $info_boxes && is_array( $info_boxes ) && count( $info_boxes ) > 0 ) : ?>
            <div class="detail-box" id="info-boxes">
                <div class="container">
                    <div class="our-services-list-box">
                        <div class="container">
                            <ul class="our-services-list">
                                <?php
                                    foreach ( $info_boxes as $box ) :
                                        $box_icon           = $box['icon'] ? $box['icon'] : $box['default_icon'];
                                        $box_title          = $box['title'];
                                        $box_description    = $box['description'];
                                        $box_button         = $box['button'];
                                        ?>
                                    <li>
                                        <div class="our-service-box">
                                            <div class="inner-box">
                                                <div class="our-service-img-wrap">
                                                    <?php if ( $box_icon ) { ?>
                                                        <img src="<?php echo esc_url( $box_icon ); ?>" alt="<?php esc_attr( $box_title ); ?>">
                                                    <?php } ?>
                                                </div>
                                                <?php
                                                    if ( $box_title ) {
                                                        echo '<h4 class="our-service-title">' . $box_title . '</h4>';
                                                    }

                                                    if ( $box_title ) {
                                                        echo ' <p class="our-services-desc">' . $box_description . '</p>';
                                                    }

                                                    if ( $box_button && is_array( $box_button ) && count( $box_button ) > 0 ) {
                                                        $label = $box_button['label'];
                                                        $link_type = $box_button['link_type'];
                                                        $target = $box_button['target'] ? 'target="_blank" rel="nofollow noopener"' : '';

                                                        if ($link_type == 'internal') {
                                                            $link = $box_button['internal_link'] ? $box_button['internal_link'] : '';
                                                        } elseif ($link_type == 'external') {
                                                            $link = $box_button['external_link'] ? $box_button['external_link'] : '';
                                                        } elseif ($link_type == 'build_page') {
                                                            $link = get_permalink() . $build_url;
                                                        } else {
                                                            $link = '';
                                                        }

                                                        if ( !empty($label) && !empty($link) ) {
                                                            echo '<a href="' . $link . '" class="btn blue inverse" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>';
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php
        if ( $show_subscribe_section && $subscribe && is_array( $subscribe ) && count( $subscribe ) > 0) :
            $subscribe_title       = $subscribe['title'];
            $subscribe_description = $subscribe['description'];
            $subscribe_form        = $subscribe['form'];

            if ( $siding_title || $siding_description ) :
                ?>
                <div class="detail-box" id="subscribe">
                    <div class="container">
                    <?php
                        if ( $subscribe_title ) {
                            echo '<h2 class="section-title smaller">' . $subscribe_title . '</h2>';
                        }

                        if ( $siding_description ) {
                            echo '<div class="section-desc content">' . $subscribe_description . '</div>';
                        }

                        if ( $subscribe_form ) {
                            echo do_shortcode($subscribe_form);
                        }
                    ?>
                    </div>
                </div>
            <?php
            endif;
        endif;
    ?>
    </section>
