<?php
    global $fwc_coordinate;

    $id             = get_the_ID();
    $title          = get_the_title();
    $locations      = get_field('location');
    $marker_info    = get_field('marker_info');
    $map            = get_field('map');
    $show_showroom  = get_field('show_our_showroom');
    $show_sale      = get_field('show_campers_for_sale');
    $website_url    = $website_title = '';
    $active_style   = $active_class = '';
    $active_info    = '';

    if ( $locations && is_array( $locations ) && count( $locations ) > 0 ) :
        $label                  = $locations['label'] ? trim($locations['label'], ':') : __('Our Dealer:', 'fw_campers');
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

    ?>
    <li>
        <div class="service-box">
            <div class="service-top-box">
                <div class="service-img-wrap">
                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/icon_forest.png" alt="Icon">
                </div>
                <?php if ( $label ) : ?>
                    <div class="service-title-box">
                        <h3 class="service-title"><?php echo $label; ?></h3>
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

  <?php if (current_user_can('administrator')) { ?>
            <?php if ($show_sale) { ?>
                <a href="<?php echo get_permalink(); ?>campers-for-sale/" class="btn blue" title="<?php esc_attr_e('See Campers for Sale', 'fw_campers') ?>"><?php _e('See Campers for Sale', 'fw_campers'); ?></a>
            <?php } ?>

            <?php if ($show_showroom) { ?>
                <a href="<?php echo get_permalink(); ?>showroom/" class="btn blue" title="<?php esc_attr_e('See Our Showroom', 'fw_campers') ?>"><?php _e('See Our Showroom', 'fw_campers'); ?></a>
            <?php } ?>
  <?php } ?>

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

        if (current_user_can('administrator')) {
            if ($show_sale) {
                $marker_description .= '<p><a href="'. get_permalink() .'campers-for-sale/" class="btn blue" title="'. __('See Campers for Sale', 'fw_campers')  .'">'. __('See Campers for Sale', 'fw_campers') .'</a></p>';
            }
        }

        $marker_description = preg_replace('/[\n\r]/', '', htmlentities($marker_description));
    }


    $fwc_coordinate[] = [$marker_label, $marker_description, $lat, $lng, $active_info];


endif; ?>
