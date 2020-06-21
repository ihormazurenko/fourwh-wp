<?php
/**
 * Template Name: Corporate Store
 */
get_header();

    $contact_info           = get_field('contact_info');
    $about                  = get_field('about');
    $image                  = get_field('image');
    $services               = get_field('services');
    $show_our_showroom      = '';
    $show_campers_for_sale  = '';

    if (get_field('show_buttons')) {
        $related_location       = get_field('related_location');
        $location_id            = ($related_location && is_array($related_location) && count($related_location) === 1) ? $related_location[0] : '';
        $show_our_showroom      = $location_id ? get_field('show_our_showroom', $location_id) : '';
        $show_campers_for_sale  = $location_id ? get_field('show_campers_for_sale', $location_id) : '';
    }
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-corporate-store">
        <div id="content"></div>

            <?php get_template_part('inc/section', 'info'); ?>

            <?php

            // if (current_user_can('administrator')) {
                if ($show_our_showroom || $show_campers_for_sale) {
                    ?>
                    <div class="categories">
                        <ul>
                            <?php
                            if ($show_our_showroom) {
                                echo '<li><a href="'.get_permalink($location_id).'showroom/" class="btn blue small" title="'.__('See Our Showroom','fw_campers').'">'.__('See Our Showroom','fw_campers').'</a></li>';
                            }

                            if ($show_campers_for_sale) {
                                echo '<li><a href="'.get_permalink($location_id).'campers-for-sale/" class="btn blue small" title="'.__('See Campers for Sale','fw_campers').'">'.__('See Campers for Sale','fw_campers').'</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
            // }


            if ($contact_info && is_array($contact_info) && count($contact_info) > 0) :
                $contact_image_id       = $contact_image_class = '';
                $peoples_list           = $contacts_list = '';
//                $contact_image          = ($contact_info['image'] && is_array($contact_info['image']) && count($contact_info['image']) > 0) ? $contact_info['image'] : '';
                $contact_gallery        = ($contact_info['gallery'] && is_array($contact_info['gallery']) && count($contact_info['gallery']) > 0) ? $contact_info['gallery'] : '';
                $contact_data           = ($contact_info['left_box'] && is_array($contact_info['left_box']) && count($contact_info['left_box']) > 0) ? $contact_info['left_box'] : '';
                $contact_gallery_count  = $contact_gallery ? count($contact_gallery) : '';

//                if ($contact_image) {
//                    $contact_image_id     = $contact_image['ID'] ? $contact_image['ID'] : '';
//                    $contact_image_class  = $contact_image['width'] > $contact_image['height'] ? 'wider' : '';
//                }

                if ($contact_data) {
                    $contacts_list  = ($contact_data['contact_info'] && is_array($contact_data['contact_info']) && count($contact_data['contact_info']) > 0) ? $contact_data['contact_info'] : '';
                    $peoples_list   = ($contact_data['sales_service'] && is_array($contact_data['sales_service']) && count($contact_data['sales_service']) > 0) ? $contact_data['sales_service'] : '';
                }

                if ($contacts_list || $peoples_list || $contact_image_id) :
                    echo '<div class="corporate-store-contact-section">';
                        echo '<div class="top-box">';
                            echo '<div class="container">';
                                echo '<div class="left-box">';
                                    echo '<div class="inner-box">';
                                        if ($contacts_list) {
                                            echo '<ul class="corporate-store-contact-list">';
                                                foreach ($contacts_list as $single_contact) {
                                                    $contact_icon       = $single_contact['icon'] ? $single_contact['icon'] : 'clock';
                                                    $contact_title      = trim($single_contact['title']) ? $single_contact['title'] : '';
                                                    $contact_content    = trim($single_contact['content']) ? $single_contact['content'] : '';

                                                    if ($contact_title || $contact_content) {
                                                        echo '<li>';
                                                            echo '<div class="corporate-store-contact-box">';
                                                                echo '<div class="corporate-store-contact-icon '.$contact_icon.'"></div>';
                                                                echo '<div class="corporate-store-contact-info">';
                                                                    if ($contact_title)
                                                                        echo '<strong>'.$contact_title.'</strong>';

                                                                    if ($contact_content)
                                                                        echo '<p>'.$contact_content.'</p>';

                                                                echo '</div>';
                                                            echo '</div>';
                                                        echo '</li>';
                                                    }
                                                }
                                            echo '</ul>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                                if ($contact_gallery) :
                                    if ($contact_gallery_count > 1) {
                                        echo '<div class="right-box">
                                                  <div class="corporate-store-slider">
                                                        <div class="swiper-container">
                                                            <div class="swiper-wrapper">';
                                    }

                                    foreach ($contact_gallery as $single_image) :
                                        if ($single_image && is_array($single_image) && count($single_image) > 0) :
                                            $single_image_id = isset($single_image['id']) ? $single_image['id'] : '';
                                            $single_image_class  = $single_image['width'] > $single_image['height'] ? 'wider' : '';

                                            if ($contact_gallery_count > 1) {
                                                echo '<div class="swiper-slide centered-img">'.wp_get_attachment_image( $single_image_id, 'size-720_720', false, array('class' => 'dealer-slide-img ' . $single_image_class)).'</div>';
                                            } else {
                                                echo '<div class="right-box"><div class="corporate-store-contact-img-box  ' . $contact_image_class . '">' . wp_get_attachment_image( $contact_image_id, 'large' ) . '</div></div>';
                                            }
                                        endif;
                                    endforeach;

                                    if ($contact_gallery_count > 1) {
                                        echo '</div>
                                                      <div class="swiper-pagination"></div>
                                                    </div>
                                                </div>
                                              </div>';
                                    }
                                endif;

                            echo '</div>';
                        echo '</div>';
                        echo '<div class="bottom-box">';
                            echo '<div class="container">';
                                echo '<div class="left-box">';
                                    echo '<div class="inner-box">';
                                        if ($peoples_list) {
                                            echo '<h3 class="people-list-title">'.__('Sales & Service:','fw_campers').'</h3>';
                                            echo '<ul class="people-list">';
                                            foreach ($peoples_list as $single_people) {
                                                $person_image_id = $person_photo_class = $person_name = $person_email = '';
                                                $people_info    = ($single_people['info'] && is_array($single_people['info']) && count($single_people['info'])) ? $single_people['info'] : '';
                                                $person_photo   = ($single_people['photo'] && is_array($single_people['photo']) && count($single_people['photo'])) ? $single_people['photo'] : '';

                                                if ($person_photo) {
                                                    $person_image_id     = $person_photo['ID'] ? $person_photo['ID'] : '';
                                                    $person_photo_class  = $person_photo['width'] > $person_photo['height'] ? 'wider' : '';
                                                }

                                                if ($people_info) {
                                                    $person_name    = trim($people_info['name']) ? $people_info['name'] : '';
                                                    $person_email   = trim($people_info['email']) ? $people_info['email'] : '';
                                                }
                                                echo '<li><div class="people-box">';
                                                if ($person_image_id) {
                                                    echo '<div class="people-photo-box"><div class="centered-img'.$person_photo_class.'">'.wp_get_attachment_image( $person_image_id, 'medium').'</div></div>';
                                                }
                                                if ($person_name || $person_email) {
                                                    echo '<div class="people-info-box">';
                                                    if ($person_name) {
                                                        echo '<h4 class="people-name">'.$person_name.'</h4>';
                                                    }
                                                    if ($person_email) {
                                                        echo '<a href="mailto:'.esc_attr($person_email).'" title="'.esc_attr($person_email).'">'.$person_email.'</a>';
                                                    }
                                                    echo '</div>';
                                                }
                                                echo '</div></li>';
                                            }
                                            echo '</ul>';
                                        }
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                endif;
            endif;

            if ($about && is_array($about) && count($about) > 0) :
                $about_image_id = $about_image_class = '';
                $about_title    = $about_content = '';
                $about_image    = ($about['image'] && is_array($about['image']) && count($about['image']) > 0) ? $about['image'] : '';;
                $about_info     = ($about['content_box'] && is_array($about['content_box']) && count($about['content_box']) > 0) ? $about['content_box'] : '';

                if ($about_image && is_array($about_image) &&count($about_image) > 0) {
                    $about_image_id     = $about_image['ID'] ? $about_image['ID'] : '';
                    $about_image_class  = $about_image['width'] > $about_image['height'] ? 'wider' : '';
                }

                if ($about_info) {
                    $about_title    = trim($about_info['title']) ? $about_info['title'] : '';
                    $about_content  = trim($about_info['content']) ? $about_info['content'] : '';
                }


                if ($about_image_id || $about_title || $about_content) :
                    echo '<div class="corporate-store-about-box">';
                        echo '<div class="container">';
                            if ($about_image_id)
                                echo '<div class="corporate-store-about-img ' . $about_image_class . '">' . wp_get_attachment_image($about_image_id, 'large') . '</div>';

                            if ($about_title || $about_content) {
                                echo '<div class="corporate-store-about-info">';
                                    if ($about_title)
                                        echo '<h3 class="corporate-store-title line">'.$about_title.'</h3>';

                                    if ($about_content)
                                        echo '<div class="content small">'.$about_content.'</div>';
                                echo '</div>';
                            }
                        echo '</div>';
                    echo '</div>';
                endif;
            endif;


            if ($image && is_array($image) &&count($image) > 0) :
                $image_id = $image['ID'] ? $image['ID'] : '';
                $image_class = $image['width'] > $image['height'] ? 'wider' : '';

                if ($image_id)
                    echo '<div class="corporate-store-full-img ' . $image_class . '"><div class="container">' . wp_get_attachment_image($image_id, 'max-width-2800') . '</div></div>';

            endif;

            if ($services && is_array($services) && count($services) > 0) :
                $service_title = trim($services['title']) ? $services['title'] : '';
                $service_list  = ($services['services_list'] && is_array($services['services_list']) && count($services['services_list']) > 0) ? $services['services_list'] : '';

                if ($service_list || $service_title) :
                    echo '<div class="corporate-store-services-box">';
                        echo '<div class="container">';
                            if ($service_title)
                                echo '<h3 class="corporate-store-title">'.$service_title.'</h3>';

                            if ($service_list) :
                                echo '<ul class="corporate-store-services-list">';
                                    foreach ($service_list as $service) {
                                        if ($service['text'])
                                            echo '<li>'.$service['text'].'</li>';
                                    }
                                echo '</ul>';
                            endif;
                        echo '</div>';
                    echo '</div>';
                endif;
            endif;
            ?>
        </div>
    </section>

<?php get_footer(); ?>
