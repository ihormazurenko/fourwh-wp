<?php
    $title = get_the_title();
    $url = get_permalink();

    
    $external_button_group  = get_field('external_button_group');

    $label                  = translate('Learn More', 'fc_details');
    $target                 = '';

    $thumbnail_id           = get_post_thumbnail_id();
    $thumbnail_class        = '';
    $thumbnail_url          = '';

//    if( ! is_null( $thumbnail_id ) ) {
//        $thumbnail_arr = image_downsize($thumbnail_id, 'size-860_680');
//        $thumbnail_url = $thumbnail_arr[0];
//        $thumbnail_class = ($thumbnail_arr[1] > $thumbnail_arr[2]) ? 'wider' : '';
//    }
   
?>

<div class="swiper-slide">
    <a href="<?php echo esc_url( $url ); ?>" class="itemlink" title="<?php echo esc_attr( $title ); ?>" <?php echo $target; ?> >
        <div class="event-box">

            <div class="event-img-wrap <?php echo $thumbnail_class; ?>">

                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('front-section-thumb', array('alt' => esc_attr($title)));
                }
                ?>
            </div>
            <div class="event-info">
                <?php if ( $country ) : ?>
                    <span class="event-location"><?php echo $country; ?></span>
                <?php endif; ?>
                <h3 class="news-title"><?php echo $title; ?></h3>
            </div>
        </div>
    </a>
</div>