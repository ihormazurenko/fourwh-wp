<?php
    global $fwc_coordinate;

    $title          = get_the_title();
    $locations      = get_field('location');
    $marker_info    = get_field('marker_info');
    $map            = get_field('map');

    if ( $locations && is_array( $locations ) && count( $locations ) > 0 ) :
        $label                  = $locations['label'] ? $locations['label'] : __('Our Dealer:', 'fw_campers');
        $short_description      = $locations['short_description'];
        $expanded_description   = $locations['expanded_description'];
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
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( $short_description || $title ) : ?>
                <div class="service-info-box">
                    <?php
                        if ( $title ) {
                            echo '<h4>'.$title.'</h4>';
                        }

                        if ( $short_description ) {
                            echo $short_description;
                        }
                    ?>
                </div>
            <?php endif; ?>
            <?php if ( $expanded_description ) : ?>
                <a href="#" class="more-info-btn" title="<?php esc_attr_e('More Info', 'fw_campers') ?>"><?php _e('More Info', 'fw_campers'); ?><span class="arrow-down"></span></a>
                <div class="service-info-box more">
                    <?php echo $expanded_description; ?>
                </div>
            <?php endif; ?>
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
        $marker_description = $marker_info['description'] ? $marker_info['description'] : $short_description;
        $marker_description = preg_replace('/[\n\r]/', '', htmlentities($marker_description));
    }

    $fwc_coordinate[] = [$marker_label, $marker_description, $lat, $lng];


endif; ?>


