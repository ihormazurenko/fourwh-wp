<?php
$id                             = get_the_ID();
$parent_id                      = wp_get_post_parent_id($id);
$title                          = get_the_title();

$show_section_floorplans        = get_field('show_section_floorplans');
$floorplans                     = get_field('floorplans_parent_data') ? get_field('floorplans', $parent_id) : get_field('floorplans', $id);

$show_section_virtual_tour      = get_field('show_section_virtual_tour');
$virtual_tour                   = get_field('virtual_tour_parent_data') ? get_field('virtual_tour', $parent_id) : get_field('virtual_tour', $id);

$show_section_testimonial      = get_field('show_section_testimonial');
$testimonial                   = get_field('testimonial_parent_data') ? get_field('testimonial', $parent_id) : get_field('testimonial', $id);

$show_section_specifications    = get_field('show_section_specifications');
$specifications                 = get_field('specifications_parent_data') ? get_field('specifications', $parent_id) : get_field('specifications', $id);

$show_section_fabric_selection  = get_field('show_section_fabric_selection');
$fabric_selection               = get_field('fabric_selection_parent_data') ? get_field('fabric_selection', $parent_id) : get_field('fabric_selection', $id);

$show_section_full_width_image  = get_field('show_section_full_width_image');
$full_width                     = get_field('full_width_image_parent_data') ? get_field('full_width_image', $parent_id) : get_field('full_width_image', $id);

$show_section_siding            = get_field('show_section_siding');
$siding                         = get_field('siding_parent_data') ? get_field('siding', $parent_id) : get_field('siding', $id);

$show_section_key_benefits      = get_field('show_section_key_benefits');
$key_benefits                   = get_field('key_benefits_parent_data') ? get_field('key_benefits', $parent_id) : get_field('key_benefits', $id);

$show_section_download          = get_field('show_section_download');
$download                       = get_field('download_parent_data') ? get_field('download', $parent_id) : get_field('download', $id);

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


$childrens = get_children( array(
    'post_parent' => $id,
    'post_type'   => 'model',
    'numberposts' => -1,
    'post_status' => 'publish'
) );

$model_id = get_the_ID();
$model_name = get_the_title();
$table_name = 'fourwh_model_relationship';
$model_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE model_id = %d',$model_id),OBJECT);

$options_ids    = [];
$options_arr    = [];
$group_desc_arr = [];
$status_arr     = [];
$taxonomy       = 'groups';

foreach ($model_relationship as $key => $value) {
    if ($value->status != 'not_available' && $value->status != '' && $value->trash != 1) {
        $options_ids[]                  = $value->option_id;
        $status_arr[$value->option_id]  = $value->status;
    }
}

$option_args = array(
    'post_type'         => 'model_option',
    'post_status'       => 'publish',
    'post__in'          => $options_ids,
    'posts_per_page'    => -1,
    'orderby'           => 'post__in'
);

$option_query = new WP_Query( $option_args );
if ( $option_query->have_posts() )  :
    while ( $option_query->have_posts()) : $option_query->the_post();
        $option_id          = $option_query->post->ID;

        $meta = new stdClass;
        foreach( (array) get_post_meta($option_id ) as $k => $v ) $meta->$k = $v[0];

        $option_name        = get_the_title() ? get_the_title() : '';
        $option_price       = $meta->option_info_price ? $meta->option_info_price : 0;
        $option_weight      = $meta->option_info_weight ? $meta->option_info_weight : 0;
        $option_desc        = $meta->description ? $meta->description : '';
        $option_status      = $status_arr[$option_id];
        $option_group       = get_the_terms($option_id, 'groups');


        if ( strtolower($option_group[0]->name) === strtolower('Cushion Fabric Colors') ) {
            $option_thumb_id = $meta->thumbnail ? $meta->thumbnail : '';
            $option_thumb_arr = $option_thumb_id ? image_downsize($option_thumb_id, 'thumbnail') : '';
            $option_thumb_url = $option_thumb_arr[0] ? $option_thumb_arr[0] : '';
            $option_thumb_class = ($option_thumb_arr[1] > $option_thumb_arr[2]) ? 'wider' : '';

            $option_medium_large_photo_id = $meta->photo ? $meta->photo : $meta->thumbnail;
            $option_medium_large_photo_arr = $option_medium_large_photo_id ? image_downsize($option_medium_large_photo_id, 'medium_large') : '';
            $option_medium_large_photo_url = $option_medium_large_photo_arr[0] ? $option_medium_large_photo_arr[0] : '';
            $option_medium_large_photo_class = ($option_medium_large_photo_arr[1] > $option_medium_large_photo_arr[2]) ? 'wider' : '';

            $option_full_photo_id = $meta->photo ? $meta->photo : $meta->thumbnail;
            $option_full_photo_arr = $option_full_photo_id ? image_downsize($option_full_photo_id, 'full') : '';
            $option_full_photo_url = $option_full_photo_arr[0] ? $option_full_photo_arr[0] : '';
            $option_full_photo_class = ($option_full_photo_arr[1] > $option_full_photo_arr[2]) ? 'wider' : '';

            if (is_array($option_group)) {
                $group_id = trim($option_group[0]->term_id);
                $group_name = trim($option_group[0]->name);
                    $options_arr[$group_name][] = [
                        'option_id' => $option_id,
                        'name' => $option_name,
                        'price' => $option_price,
                        'weight' => $option_weight,
                        'full_photo' => $option_full_photo_url,
                        'full_photo_class' => $option_full_photo_class,
                        'medium_large_photo' => $option_medium_large_photo_url,
                        'medium_large_photo_class' => $option_medium_large_photo_class,
                        'thumbnail' => $option_thumb_url,
                        'thumbnail_class' => $option_thumb_class,
                        'status' => $option_status,
                        'desc' => $option_desc,
                    ];
            }
        }

    endwhile;

    //group Cushion Fabric Colors
    $options_fabric_arr = $options_arr['Cushion Fabric Colors'];

    if (isset($options_fabric_arr)) :
        $fabric_price_arr = array_column( $options_fabric_arr, 'price' );
        $fabric_name_arr = array_column( $options_fabric_arr, 'name' );
        $fabric_status_arr = array_column( $options_fabric_arr, 'status' );

        array_multisort( $fabric_price_arr, SORT_NUMERIC , $fabric_name_arr, SORT_NATURAL | SORT_FLAG_CASE, $options_fabric_arr );

        if ( ! in_array( $fabric_status_arr, 'standard' ) ) {
            $options_fabric_arr[1]['status'] = 'standard';
        }

        $options_arr['Cushion Fabric Colors'] = $options_fabric_arr;

    endif;

else:
    $options_arr = [];
endif;

wp_reset_postdata();

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
                                    <a href="<?php print get_site_url(); ?>/contact-us/" class="btn blue inverse" title="<?php esc_attr_e('Contact Us', 'fw_campers') ?>"><?php _e('Contact Us', 'fw_campers'); ?></a>
                                </li>
                                    <?php
                                        if ($childrens && is_array($childrens) && count($childrens) > 0 ) {
                                            $term_id = wp_get_post_terms($model_id, 'model_categories', array('fields' => 'ids'));
                                            $build_price_url = get_term_link((int)$term_id[0], 'model_categories').'?type=build';
                                        } else {
                                            $build_price_url = get_permalink() . $build_url;
                                        }
                                    ?>
                                <li>
                                    <a href="<?php echo $build_price_url; ?>" class="btn blue" title="<?php esc_attr_e('Build &amp; Price', 'fw_campers') ?>"><?php _e('Build &amp; Price', 'fw_campers'); ?></a>
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
                $virtual_tour_video_url   = $virtual_tour['url'];
                $virtual_tour_thumb_url   = $virtual_tour['image'] ? $virtual_tour['image']['url'] : getVideoThumbnail($virtual_tour_video_url);
                $virtual_tour_link        = $virtual_tour['link'];
                $virtual_tour_slider      = $virtual_tour['slider'];

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

                            if ( $virtual_tour_video_url || $virtual_tour_thumb_url ) {
                                if ( !$virtual_tour_video_url && $virtual_tour_thumb_url ) {
                                    echo '<div class="detail-img-wrap">
                                            <img src="' . $virtual_tour_thumb_url . '" alt="' . esc_attr( $virtual_tour_title ) . '">
                                        </div>';
                                } elseif ($virtual_tour_video_url || $virtual_tour_thumb_url) {
                                    echo '<div class="video-wrap-box">
                                            <div class="video-wrap">';
                                                if ( $virtual_tour_thumb_url ) {
                                                    echo '<img src="' . $virtual_tour_thumb_url . '" alt="' . esc_attr($virtual_tour_title) . '">';
                                                }
                                                if ( $virtual_tour_video_url ) {
                                                    if (getVideoType($virtual_tour_video_url) == 'youtube') {
                                                        echo '<iframe src="https://www.youtube.com/embed/'.getVideoId($virtual_tour_video_url).'?rel=0&autoplay=1&loop=1&mute=1&playlist='.getVideoId($virtual_tour_video_url).'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
                                                    }   elseif (getVideoType($virtual_tour_video_url) == 'vimeo') {
                                                        echo '<iframe src="https://player.vimeo.com/video/'.getVideoId($virtual_tour_video_url).'?autoplay=1&loop=1&muted=1&autopause=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                                                    }
                                                }
                                    echo '</div>
                                        </div>';
                                }
                            }
                            if ( $virtual_tour_link && is_array( $virtual_tour_link ) && count( $virtual_tour_link ) > 0) {
                                $virtual_label = $virtual_tour_link['label'];
                                $virtual_link_type = $virtual_tour_link['link_type'];
                                $virtual_target = $virtual_tour_link['target'] ? 'target="_blank" rel="nofollow noopener"' : '';

                                if ($virtual_link_type == 'internal') {
                                    $virtual_link = $virtual_tour_link['internal_link'] ? $virtual_tour_link['internal_link'] : '';
                                } elseif ($virtual_link_type == 'external') {
                                    $virtual_link = $virtual_tour_link['external_link'] ? $virtual_tour_link['external_link'] : '';
                                } else {
                                    $virtual_link = '';
                                }

                                if (!empty($virtual_label)) {
                                    echo '<div class="videotour-link-box">';
                                        if (!empty($virtual_link)) {
                                            echo '<a href="' . $virtual_link . '" class="video-title" title="' . esc_attr($virtual_label) . '" ' . $virtual_target . '>' . $virtual_label . '</a>';
                                        } else {
                                            echo '<span>' . $virtual_label . '</span>';
                                        }
                                    echo '</div>';
                                }
                            }
                        ?>
                        </div>
                    </div>
                    <?php
                endif;
            endif;
        ?>

        <?php
            if (get_current_user_id() == 1) :
                if ( $show_section_virtual_tour && $virtual_tour && is_array( $virtual_tour ) && count( $virtual_tour ) > 0) :
                    $virtual_tour_title       = $virtual_tour['title'];
                    $virtual_tour_description = $virtual_tour['description'];
                    $virtual_tour_link        = $virtual_tour['link'];
                    $virtual_tour_slider      = $virtual_tour['slider'];

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

                                if ( $virtual_tour_slider && is_array($virtual_tour_slider) && count($virtual_tour_slider) > 0 ) {
//                                    if ( !$virtual_tour_video_url && $virtual_tour_thumb_url ) {
//                                        echo '<div class="detail-img-wrap">
//                                                    <img src="' . $virtual_tour_thumb_url . '" alt="' . esc_attr( $virtual_tour_title ) . '">
//                                                </div>';
//                                    } elseif ($virtual_tour_video_url || $virtual_tour_thumb_url) {
//                                        echo '<div class="video-wrap-box">
//                                                    <div class="video-wrap">';
//                                        if ( $virtual_tour_thumb_url ) {
//                                            echo '<img src="' . $virtual_tour_thumb_url . '" alt="' . esc_attr($virtual_tour_title) . '">';
//                                        }
//                                        if ( $virtual_tour_video_url ) {
//                                            if (getVideoType($virtual_tour_video_url) == 'youtube') {
//                                                echo '<iframe src="https://www.youtube.com/embed/'.getVideoId($virtual_tour_video_url).'?rel=0&autoplay=1&loop=1&mute=1&playlist='.getVideoId($virtual_tour_video_url).'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
//                                            }   elseif (getVideoType($virtual_tour_video_url) == 'vimeo') {
//                                                echo '<iframe src="https://player.vimeo.com/video/'.getVideoId($virtual_tour_video_url).'?autoplay=1&loop=1&muted=1&autopause=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
//                                            }
//                                        }
//                                        echo '</div>
//                                                </div>';
//                                    }
                                }
                                if ( $virtual_tour_link && is_array( $virtual_tour_link ) && count( $virtual_tour_link ) > 0) {
                                    $virtual_label = $virtual_tour_link['label'];
                                    $virtual_link_type = $virtual_tour_link['link_type'];
                                    $virtual_target = $virtual_tour_link['target'] ? 'target="_blank" rel="nofollow noopener"' : '';

                                    if ($virtual_link_type == 'internal') {
                                        $virtual_link = $virtual_tour_link['internal_link'] ? $virtual_tour_link['internal_link'] : '';
                                    } elseif ($virtual_link_type == 'external') {
                                        $virtual_link = $virtual_tour_link['external_link'] ? $virtual_tour_link['external_link'] : '';
                                    } else {
                                        $virtual_link = '';
                                    }

                                    if (!empty($virtual_label)) {
                                        echo '<div class="videotour-link-box">';
                                        if (!empty($virtual_link)) {
                                            echo '<a href="' . $virtual_link . '" class="video-title" title="' . esc_attr($virtual_label) . '" ' . $virtual_target . '>' . $virtual_label . '</a>';
                                        } else {
                                            echo '<span>' . $virtual_label . '</span>';
                                        }
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                endif;
            endif;
        ?>

        <?php
            if ( $show_section_testimonial && $testimonial && is_array( $testimonial ) && count( $testimonial ) > 0) :
                $testimonial_info        = $testimonial['info'];
                if ( $testimonial_info && is_array( $testimonial_info ) && count( $testimonial_info ) > 0) {
                    $author_name         = $testimonial_info['name'];
                    $author_position     = $testimonial_info['position'];

                }
                $testimonial_content     = $testimonial['content'];
                $testimonial_thumb_url   = $testimonial['photo'] ? $testimonial['photo']['sizes']['thumbnail'] :$testimonial['photo']['url'];
                $testimonial_thumb_class = $testimonial['photo']['width'] > $testimonial['photo']['height'] ? 'wider' : '';
                $testimonial_thumb_alt   = $author_position ? $author_name : 'avatar';
                $testimonial_link        = $testimonial['link'];

                ?>
                <?php if ($author_name || $author_position || $testimonial_content || $testimonial_thumb_url || $testimonial_link) : ?>
                    <div class="detail-box testimonial" id="testimonial">
                        <div class="container">
                            <div class="testimonial-box align-center">
                                <?php if ($testimonial_content) : ?>
                                    <div class="content">
                                        <?php echo $testimonial_content; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($author_name || $author_position || $testimonial_thumb_url) : ?>
                                    <div class="testimonial-author-box">
                                        <?php if ( $testimonial_thumb_url ) { ?>
                                            <div class="centered-img <?php echo $testimonial_thumb_class; ?>">
                                                <img src="<?php echo esc_url($testimonial_thumb_url); ?>" alt="<?php echo esc_attr($testimonial_thumb_alt); ?>">
                                            </div>
                                        <?php } ?>
                                        <?php if ($author_name) { ?>
                                            <h4 class="author-name"><?php echo $author_name; ?></h4>
                                        <?php } ?>
                                        <?php if ($author_position) { ?>
                                            <span class="author-position"><?php echo $author_position; ?></span>
                                        <?php } ?>
                                    </div>
                                <?php endif; ?>
                                <?php
                                    if ( $testimonial_link && is_array( $testimonial_link ) && count( $testimonial_link ) > 0) {
                                        $testimonial_label = $testimonial_link['label'];
                                        $testimonial_link_type = $testimonial_link['link_type'];
                                        $testimonial_target = $testimonial_link['target'] ? 'target="_blank" rel="nofollow noopener"' : '';

                                        if ($testimonial_link_type == 'internal') {
                                            $testimonial_link = $testimonial_link['internal_link'] ? $testimonial_link['internal_link'] : '';
                                        } elseif ($testimonial_link_type == 'external') {
                                            $testimonial_link = $testimonial_link['external_link'] ? $testimonial_link['external_link'] : '';
                                        } else {
                                            $testimonial_link = '';
                                        }

                                        if (!empty($testimonial_label)) {
                                            echo '<div class="videotour-link-box">';
                                            if (!empty($testimonial_link)) {
                                                echo '<a href="' . $testimonial_link . '" class="testimonial-read-more" title="' . esc_attr($testimonial_label) . '" ' . $testimonial_target . '>' . $testimonial_label . '</a>';
                                            } else {
                                                echo '<span>' . $testimonial_label . '</span>';
                                            }
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </div>
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
                $specifications_list        = $specifications['specifications'];

                if ($specifications_title || $specifications_description || $specifications_img_url || $specifications_accordion) :
                    ?>
                    <div class="detail-box specifications" id="new-specifications">
                        <?php
                            if ( $specifications_title ) {
                                echo '<div class="detail-header-box">
                                            <div class="container">
                                                <h2 class="specification-title">' . $specifications_title . '</h2>
                                            </div>
                                        </div>';
                            }
                        ?>
                        <div class="container">
                            <?php
                                if ( $specifications_description ) {
                                    echo '<div class="section-desc content">' . $specifications_description . '</div>';
                                }

                                if ($specifications_list && is_array($specifications_list) && count($specifications_list) > 0 ) {
                                    echo '<table class="specification-table">
                                            <tbody>';
                                        foreach ($specifications_list as $specification_item) {
                                            $specification_name = $specification_item['name'];
                                            $specification_value = $specification_item['value'];

                                            if ($specification_name || $specification_value) {
                                                echo '<tr>
                                                        <td class="name">'.$specification_name.'<span class="value-mob">'.$specification_value.'</span></td>
                                                        <td class="value">'.$specification_value.'</td>
                                                    </tr>';
                                            }

                                        }
                                    echo '</tbody>
                                        </table>';
                                }
                            ?>
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
                                    ?>

                                <?php

                                ?>
                                <?php
                                    if( $options_arr && is_array( $options_arr ) && count( $options_arr ) > 0 ) :
                                        foreach ($options_arr as $group => $items) :
                                            $element_id  = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($group))) );
                                            $element_id  = preg_replace('/(-)\1+/','-', $element_id );
                                            $group_desc  = $group_desc_arr[$group]['desc'];
                                            $group_check = $group_desc_arr[$group]['check-type'];

                                            if ( strtolower($group) === strtolower('Cushion Fabric Colors') ) :
                                                $data_attr = (strtolower($group) === strtolower('Cushion Fabric Colors')) ? 'interior' : 'exterior';
                                                ?>
                                                <div id="<?php echo $element_id; ?>" class="group-box color-selector-box">
                                                    <?php
                                                    if (is_array($items) && count($items) > 0) :
                                                        $items_count = count($items);
                                                        ?>
                                                        <div class="left-box">
                                                            <div class="group-img-wrap centered-img">
                                                                <?php
                                                                foreach ($items as $key => $value) :
                                                                    if ( strtolower($value['status']) == strtolower('standard') ) {
                                                                        $item_id                    = trim($value['option_id']);
                                                                        $item_name                  = trim($value['name']);
                                                                        $item_full_photo            = trim($value['full_photo']);
                                                                        $item_medium_large_photo    = $value['medium_large_photo'] ? trim($value['medium_large_photo']) : $item_full_photo;
                                                                    }
                                                                endforeach;
                                                                ?>
                                                                <?php if ( $item_full_photo ) { ?>
                                                                    <a class="icon-zoom"
                                                                       href="<?php echo esc_url($item_full_photo); ?>"
                                                                       title="<?php esc_attr_e('Zoom', 'fw_campers'); ?>"></a>
                                                                <?php } ?>
                                                                <img src="<?php echo esc_url( $item_medium_large_photo ); ?>" class="group-img active" alt="<?php echo esc_attr( $item_name ); ?>">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php
                                                    if (is_array($items) && count($items) > 0) :
                                                        ?>
                                                        <div class="right-box">
                                                            <?php
                                                            $img_count   = 0;
                                                            $items_count = count($items);
                                                            $item_prev_price = 0;
                                                            ?>
                                                            <ul class="color-list">
                                                            <?php
                                                            foreach ($items as $key => $value) :
                                                                $item_id                        = trim($value['option_id']);
                                                                $item_name                      = trim($value['name']);
                                                                $item_price                     = trim($value['price']);
                                                                $item_weight                    = trim($value['weight']);
                                                                $item_full_photo                = trim($value['full_photo']);
                                                                $item_full_photo_class          = trim($value['full_photo_class']);
                                                                $item_medium_large_photo        = trim($value['medium_large_photo']);
                                                                $item_medium_large_photo_class  = trim($value['medium_large_photo_class']);
                                                                $item_thumbnail                 = trim($value['thumbnail']);
                                                                $item_thumbnail_class           = trim($value['thumbnail_class']);
                                                                $item_class                     = (strtolower($value['status']) == strtolower('standard')) ? 'checked' : '';

                                                                $img_count++;
                                                                $item_prev_price = $item_price;

                                                                ?>
                                                                <li>
                                                                    <div class="color-box color-gainsboro">
                                                                        <input class="color-selector"
                                                                               type="radio"
                                                                               name="option_group[<?php echo $element_id; ?>]"
                                                                               id="option_<?php echo $item_id; ?>"
                                                                               value="<?php echo $item_name; ?>" <?php echo $item_class; ?>
                                                                               data-color="truck_color_<?php echo $item_id; ?>"
                                                                               data-price="<?php echo $item_price; ?>"
                                                                               data-weight="<?php echo $item_weight; ?>"
                                                                               data-img-full="<?php echo esc_url($item_full_photo); ?>"
                                                                               data-img-medium-large="<?php echo esc_url($item_medium_large_photo); ?>"
                                                                               data-img-medium-large-class="<?php echo esc_url($item_medium_large_photo_class); ?>"
                                                                               data-group-name="<?php echo $group; ?>"
                                                                               data-option-parent-group="<?php echo $parent_group; ?>"
                                                                               data-option-group="<?php echo $element_id; ?>"
                                                                               data-preview="<?php echo $data_attr; ?>"
                                                                               data-option-name = "<?php echo trim($item_name); ?>"
                                                                               data-option>
                                                                        <label for="option_<?php echo $item_id; ?>" data-tippy-content="<?php echo $item_name; ?>">
                                                                                                <span class="color centered-img <?php echo $item_thumbnail_class; ?>">
                                                                                                    <img src="<?php echo esc_url( $item_thumbnail ); ?>" alt="<?php echo esc_attr( $item_name ); ?>">
                                                                                                </span>
                                                                            <span class="color-name"><?php echo $item_name; ?></span>
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php
                                            endif;
                                        endforeach;
                                    endif;
                                ?>
                            </div>
                        </div>
                    <?php
                endif;
            endif;
        ?>

        <?php
            if ( $show_section_full_width_image && $full_width && is_array( $full_width ) && count( $full_width ) > 0) :
                $full_width_title = $full_width['title'];
                $full_width_img = $full_width['image'];
                $full_width_img_url = $full_width_img['url'] ? 'style="background-image: url('.$full_width_img['url'].');"' : '';
                $full_width_img_alt = $full_width_title ? $full_width_title : $full_width_img['title'];
                ?>
                <?php if ($full_width_title || $full_width_img ) : ?>
                    <div class="detail-box full-width-img" id="full-width-img" <?php echo $full_width_img_url; ?>>
                        <?php if ( $full_width_title ) : ?>
                            <div class="full-width-bottom-box">
                                <div class="container">
                                    <h3 class="full-width-title"><?php echo $full_width_title; ?></h3>
                                </div>
                            </div>
                        <?php endif; ?>
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
                    <div class="detail-box key-benefits" id="key-benefits">
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
