<?php
    global $fwc_coordinate;

    $id             = get_the_ID();
    $title          = get_the_title();
    $locations      = get_field('location');
    $marker_info    = get_field('marker_info');
    $map            = get_field('map');

    $show_showroom          = get_field('show_our_showroom');
    $showroom_type          = get_field('our_showroom_type');
    $group_button_showroom  = get_field('our_showroom_link');
    $group_button_showroom  = ($group_button_showroom && is_array($group_button_showroom) && count($group_button_showroom) > 0) ? $group_button_showroom : '';
    $showroom_btn           = '';

    $show_sale          = get_field('show_campers_for_sale');
    $sale_type          = get_field('campers_for_sale_type'); //true - block type, false - link
    $group_button_sale  = get_field('campers_for_sale_link');
    $group_button_sale  = ($group_button_sale && is_array($group_button_sale) && count($group_button_sale) > 0) ? $group_button_sale : '';
    $sale_btn           = '';
/*
    $show_facility          = get_field('show_our_facility');
    $group_button_facility  = $show_facility ? get_field('our_facility') : '';
    $group_button_facility  = ($group_button_facility && is_array($group_button_facility) && count($group_button_facility) > 0) ? $group_button_facility : '';
    $facility_btn           = '';
*/
    $website_url    = $website_title = '';
    $active_style   = $active_class = '';
    $active_info    = '';

    if ( $locations && is_array( $locations ) && count( $locations ) > 0 ) :
        $location_label         = $locations['label'] ? trim($locations['label'], ':') : __('Our Dealer:', 'fw_campers');
        $address                = trim($locations['contact_address']) ? $locations['contact_address'] : '';
        $phone                  = trim($locations['contact_phone']) ? $locations['contact_phone'] : '';
        $email                  = trim($locations['contact_email']) ? $locations['contact_email'] : '';
        $website                = $locations['contact_website'] ? $locations['contact_website'] : '';
//        $short_description      = $locations['short_description'];
        $additional_description      = trim($locations['additional_description']) ? $locations['additional_description'] : '';
//        $expanded_description   = $locations['expanded_description'];

        if ($website && is_array($website) && count($website) > 0) {
            $website_url   = trim( $website['url'] ) ? $website['url'] : '';
            $website_title = trim( $website['title'] ) ? $website['title'] : str_replace(["https://", "http://", "/"], "", $website_url);
        }

        if (isset($_GET['dealer-id']) && $_GET['dealer-id'] == $id) {
          $active_style = 'style="display: block;"';
          $active_class = 'open';
          $active_info  = 1;
        }

        if ($show_sale) {
            $label      = (!$sale_type && trim($group_button_sale['label'])) ? $group_button_sale['label'] : __('See Campers for Sale','fw_campers');
            $link_type  = (!$sale_type && $group_button_sale['link_type']) ? $group_button_sale['link_type'] : 'internal';
            $target     = (!$sale_type && $group_button_sale['target']) ? 'target="_blank" rel="nofollow noopener"' : '';

            if ($link_type == 'internal') {
                $link = (!$sale_type && $group_button_sale['internal_link']) ? $group_button_sale['internal_link'] : get_permalink().'campers-for-sale/';
            } elseif ($link_type == 'external') {
                $link = (!$sale_type && $group_button_sale['external_link']) ? $group_button_sale['external_link'] : get_permalink().'campers-for-sale/';
            }

            $sale_btn = (!empty($label) && !empty($link)) ? '<a href="' . $link . '" class="btn blue" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>' : '';
        }


        if ($show_showroom) {
            $label      = (!$showroom_type && trim($group_button_showroom['label'])) ? $group_button_showroom['label'] : __('See Our Showroom','fw_campers');
            $link_type  = (!$showroom_type && $group_button_showroom['link_type']) ? $group_button_showroom['link_type'] : 'internal';
            $target     = (!$showroom_type && $group_button_showroom['target']) ? 'target="_blank" rel="nofollow noopener"' : '';

            if ($link_type == 'internal') {
                $link = (!$showroom_type && $group_button_showroom['internal_link']) ? $group_button_showroom['internal_link'] : get_permalink().'showroom/';
            } elseif ($link_type == 'external') {
                $link = (!$showroom_type && $group_button_showroom['external_link']) ? $group_button_showroom['external_link'] : get_permalink().'showroom/';
            }

            $showroom_btn = (!empty($label) && !empty($link)) ? '<a href="' . $link . '" class="btn blue" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>' : '';
        }

       /*
        if ($group_button_facility) {
            $label      = trim($group_button_facility['label']) ? $group_button_facility['label'] : __('Our Facility','fw_campers');
            $link_type  = $group_button_facility['link_type'] ? $group_button_facility['link_type'] : 'internal';
            $target     = $group_button_facility['target'] ? 'target="_blank" rel="nofollow noopener"' : '';

            if ($link_type == 'internal') {
                $link = $group_button_facility['internal_link'] ? $group_button_facility['internal_link'] : '';
            } elseif ($link_type == 'external') {
                $link = $group_button_facility['external_link'] ? $group_button_facility['external_link'] : '';
            }

            $facility_btn = (!empty($label) && !empty($link)) ? '<a href="' . $link . '" class="btn blue" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>' : '';
        }
      */

    ?>
    <li>
        <div class="service-box">
            <div class="service-top-box">
                <div class="service-img-wrap">
                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/icon_forest.png" alt="Icon">
                </div>
                <?php if ( $location_label ) : ?>
                    <div class="service-title-box">
                        <h3 class="service-title"><?php echo $location_label; ?></h3>
                        <?php
                            if ( $show_showroom ) {
                                echo '<span class="showroom-available-btn"><i class="far fa-eye"></i>'.__('Showroom available','fw_campers').'</span>';
                            }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( $title ) : ?>
                <div class="service-info-box">
                    <?php
                        if ( $title ) {
                            echo '<h4>'.$title.'</h4>';
                        }
                    ?>
                </div>
            <?php endif; ?>
	          <?php if ($address || $phone || $email || $website_url || $additional_description) : ?>
                <div class="service-info-box more" <?php echo $active_style; ?>>
                    <?php
                          echo '<ul class="service-contact-list">';

                          if ($website_url && $website_title) {
                            echo '<li><i class="fas fa-globe"></i><div><a href="'. $website_url .'" target="_blank" rel="nofollow noopener" title="'. esc_attr($website_title) .'">'.$website_title.'</a></div></li>';
                          }

                          if ($address) {
                              echo '<li><i class="fas fa-map-marked"></i><div>'.$address.'</div></li>';
                          }

                          if ($phone) {
                              $phone_pattern = '/[^\d+]+/';
                              $phone_replacements = '';
                              echo '<li><i class="fas fa-mobile-alt"></i><div><a href="tel:'. preg_replace($phone_pattern, $phone_replacements, $phone) .'" title="'. esc_attr( $phone ) .'">'.$phone.'</a></div></li>';
                          }

                          if ($email) {
                              echo '<li><i class="fas fa-at"></i><div><a href="mailto:'. $email .'" target="_blank" rel="nofollow noopener" title="'. esc_attr($email) .'">'.$email.'</a></div></li>';
//	                                <a href="mailto:" target="_blank" rel="nofollow noopener" title=""></a>
                          }

                          echo '</ul>';

                          echo $additional_description;
                    ?>
                </div>
                <button class="more-info-btn service-style btn blue-light <?php echo $active_class; ?>" title="<?php esc_attr_e('Contact Details', 'fw_campers') ?>"><?php _e('Contact Details', 'fw_campers'); ?><span class="arrow-down"></span></button>
            <?php endif; ?>

            <?php
                // if (current_user_can('administrator')) {
                    if ($show_sale && $sale_btn) {
                      echo $sale_btn;
                    }
                    if ($show_showroom && $showroom_btn) {
                      echo $showroom_btn;
                    }
                // }
            ?>

        </div>
<!--        <a href="http://" target="_blank" rel="nofollow"></a>-->
    </li>
    <?php

    $marker_info = get_field('marker_info');
    $map = get_field('map');

    if ($map && is_array($map) && count($map) > 0) {
        $lat = $map['lat'] ? (float)$map['lat'] : '';
        $lng = $map['lng'] ? (float)$map['lng'] : '';
    }
    if ($marker_info && is_array($marker_info) && count($marker_info) > 0) {
        $marker_label = $marker_info['label'] ? $marker_info['label'] : get_the_title();
        $marker_description = $marker_info['description'] ? $marker_info['description'] : $additional_description;

        if ($show_showroom) {
            $marker_description = '<div class="showroom-available-box"><span class="showroom-available-btn"><i class="far fa-eye"></i>'.__('Showroom available','fw_campers').'</span></div>' .$marker_description;
        }

        // if (current_user_can('administrator')) {
            if ($show_sale && $sale_btn) {
                $marker_description .= $sale_btn;
            }
            if ($show_showroom && $showroom_btn) {
                $marker_description .= $showroom_btn;
            }
        // }

        $marker_description = preg_replace('/[\n\r]/', '', htmlentities($marker_description));
    }


    $fwc_coordinate[] = [$marker_label, $marker_description, $lat, $lng, $active_info];


endif; ?>
