<?php
/**
 * Template Name: Factory Inventory
 */
get_header();
$section_inventory = get_field('section_inventory');

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-inventory-details">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <?php
            if ( $section_inventory && is_array( $section_inventory ) && count( $section_inventory ) > 0 ) :
                foreach ( $section_inventory as $section) :
                    $section_title = $section['section_title'];
                    $details_list = $section['details_list'];

                    if ( $section_title ) {
                        ?>
                            <h2 class="group-title"><?php echo $section_title; ?></h2>
                        <?php
                    }
                    if ( $details_list && is_array( $details_list ) && count( $details_list ) > 0 ) :
                        ?>
                        <div class="inventory-detail-list-wrap">
                            <ul class="inventory-detail-list">
                            <?php
                                foreach ( $details_list as $detail ) :
                                    $title = $detail['title'];
                                    $description = $detail['description'];
                                    $photos = $detail['photo'];
                                    $photo_count = count($detail['photo']);
//                                    $photo_url = $photo['sizes']['medium_large'] ? $photo['sizes']['medium_large'] : $photo['url'];
                                    $information_group = $detail['information_group'];
                                    $check_group = $detail['check_group'];
                                    $serial_number = '';
                                    $price_approx = '';
                                    $email = '';
                                    $phone = '';
                                    $full_size_mode = '';
                                    $latest_model = '';

                                    if ( $information_group ) {
                                        $serial_number = $information_group['serial_number'];
                                        $price_approx = $information_group['price_approx'];
                                        $email = $information_group['email'];
                                        $phone = $information_group['phone'];
                                    }

                                    if ( $check_group ) {
                                        $full_size_mode = $check_group['full_size_mode'];
                                        $latest_model = $check_group['latest_model'];
                                    }

                                    if ( $full_size_mode ) :
                                        ?>
                                            <li class="full-inventory-info">
                                                <div class="inventory-detail-box">
                                                    <div class="left-box">
                                                        <?php
                                                            if ($photos && is_array($photos) && count($photos) >  0) :
                                                                if ($photo_count > 1) {
                                                                    echo '<div class="dealer-slider">
                                                                    <div class="swiper-container">
                                                                        <div class="swiper-wrapper">';
                                                                }
                                                                foreach ($photos as $key => $photo) :
                                                                    $image_url = $photo['sizes']['max-width-2800'] ? $photo['sizes']['max-width-2800'] : $photo['url'];
                                                                    $image_class = $photo['width'] > $photo['height'] ? 'wider' : '';

                                                                    if ($photo_count > 1) {
                                                                        echo '<div class="swiper-slide" style="background-image: url('.$image_url .') "></div>';
                                                                    } else {
                                                                        ?>
                                                                        <div class="centered-img <?php echo $image_class; ?>">
                                                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                                                            <?php if ( $latest_model ) { ?>
                                                                                <span class="centered-img-label"><?php _e('Latest Model','fw_campers'); ?></span>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                endforeach;
                                                                if ($photo_count > 1) {
                                                                    echo '</div>
                                                                  <div class="swiper-pagination"></div>
                                                                </div>
                                                            </div>';
                                                                }
                                                            endif;
                                                            ?>
                                                    </div>
                                                    <div class="right-box">
                                                        <div class="inventory-info-wrap">
                                                            <?php if ( $title ) { ?>
                                                                <h3 class="inventory-detail-title"><?php echo $title; ?></h3>
                                                            <?php } ?>
                                                            <div class="inventory-info-box content">
                                                            <?php
                                                                if ( $description ) {
                                                                    echo $description . '</br>';
                                                                }

                                                                if ( $serial_number ) {
                                                                    echo '<p><b>' . __('Serial number:', 'fw_campers') . '</b> ' . $serial_number . '</p>';
                                                                }

                                                                if ( $price_approx ) {
                                                                    echo '<p><b>' . __('Price Approx:', 'fw_campers') . '</b> ' . $price_approx . '</p>';
                                                                }

                                                                if ( $email ) {
                                                                    echo '<p><b>' . __('Email:', 'fw_campers') . '</b> ' . $email . '</p>';
                                                                }

                                                                if ( $phone ) {
                                                                    echo '<p><b>' . __('Phone:', 'fw_campers') . '</b> ' . $phone . '</p>';
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                    <?php else : ?>
                                        <li>
                                            <div class="inventory-detail-box">
                                            <?php
                                                if ($photos && is_array($photos) && count($photos) >  0) :
                                                    if ($photo_count > 1) {
                                                        echo '<div class="dealer-slider">
                                                                <div class="swiper-container">
                                                                    <div class="swiper-wrapper">';
                                                    }
                                                    foreach ($photos as $key => $photo) :
                                                        $image_url = $photo['sizes']['large'] ? $photo['sizes']['large'] : $photo['url'];
                                                        $image_class = $photo['width'] > $photo['height'] ? 'wider' : '';

                                                        if ($photo_count > 1) {
                                                            echo '<div class="swiper-slide" style="background-image: url('.$image_url .') "></div>';
                                                        } else {
                                                            ?>
                                                            <div class="centered-img <?php echo $image_class; ?>">
                                                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                                                <?php if ( $latest_model ) { ?>
                                                                    <span class="centered-img-label"><?php _e('Latest Model','fw_campers'); ?></span>
                                                                <?php } ?>
                                                            </div>
                                                            <?php
                                                        }
                                                    endforeach;
                                                    if ($photo_count > 1) {
                                                        echo '</div>
                                                              <div class="swiper-pagination"></div>
                                                            </div>
                                                        </div>';
                                                    }
                                                    endif;
                                                ?>
                                                <div class="inventory-info-wrap">
                                                    <?php if ( $title ) { ?>
                                                        <h3 class="inventory-detail-title"><?php echo $title; ?></h3>
                                                    <?php } ?>
                                                    <?php if ( $serial_number || $price_approx ) { ?>
                                                        <div class="inventory-info-box content">
                                                            <?php
                                                                echo '<p>';
                                                                    if ( $price_approx ) {
                                                                       echo __('Price Approx:', 'fw_campers') . ' ' . $price_approx;
                                                                    }

                                                                    if ( $serial_number ) {
                                                                        echo '</br>'. __('Serial number:', 'fw_campers') . ' ' . $serial_number;
                                                                    }
                                                                echo '</p>';
                                                            ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ( $description ) { ?>
                                                        <a href="#" class="more-info-btn" title="<?php esc_attr_e('See More', 'fw_campers'); ?>"><?php _e('See More', 'fw_campers'); ?> <span class="arrow-down"></span></a>
                                                        <div class="inventory-info-box content more">
                                                            <?php
                                                                echo '<p>';
                                                                    if ( $email ) {
                                                                        echo __('Email:', 'fw_campers') . ' ' . $email;
                                                                    }

                                                                    if ( $phone ) {
                                                                        echo '</br>' . __('Phone:', 'fw_campers') . ' ' . $phone;
                                                                    }
                                                                echo '</p>';

                                                                if ( $description ) {
                                                                    echo $description;
                                                                }
                                                            ?>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                    endif;
                                endforeach;
                            ?>
                            </ul>
                        </div>
                        <?php
                    endif;
                endforeach;
            endif;
            ?>

        </div>
    </section>

<?php get_footer(); ?>