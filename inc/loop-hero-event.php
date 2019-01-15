<?php
    $title = get_the_title();
    $url = get_permalink();

    $dates_start_U          = get_field('dates_start_U');
    $dates_end_U            = get_field('dates_end_U');
    $country                = get_field('country');
    $event_type             = get_field('event_type');
    $external_button_group  = get_field('external_button_group');

    $label                  = translate('Learn More', 'fc_details');
    $target                 = '';

    $thumbnail_id           = get_post_thumbnail_id();
    $thumbnail_class        = '';
    $thumbnail_url          = '';

    if( ! is_null( $thumbnail_id ) ) {
        $thumbnail_arr = image_downsize($thumbnail_id, 'size-860_680');
        $thumbnail_url = $thumbnail_arr[0];
        $thumbnail_class = ($thumbnail_arr[1] > $thumbnail_arr[2]) ? 'wider' : '';
    }

   if ( $event_type == 'external' ) {
        if ( $external_button_group && is_array( $external_button_group ) && count( $external_button_group ) > 0 ) {
            $label  = $external_button_group['label'] ? $external_button_group['label'] : $label;
            $url    = $external_button_group['link'];
            $target = $external_button_group['target'] ? 'target="_blank"' : '';
        }
    }
?>

<li>
    <a href="<?php echo esc_url( $url ); ?>" class="itemlink" title="<?php echo esc_attr( $title ); ?>" <?php echo $target; ?> >
        <div class="event-box">
            <div class="event-img-wrap <?php echo $thumbnail_class; ?>">
                <?php if ( $dates_start_U && $dates_end_U ) : ?>
                    <span class="event-date"><?php echo date( 'm.d.Y', strtotime($dates_start_U) ); ?></span>
                <?php endif; ?>
                <?php
                if ($thumbnail_url) {
                    echo '<img src="'.$thumbnail_url.'" alt="'.esc_attr($title).'">';
                }
                ?>
            </div>
            <div class="event-info">
                <?php if ( $country ) : ?>
                    <span class="event-location"><?php echo $country; ?></span>
                <?php endif; ?>
                <h3 class="event-title"><?php echo $title; ?></h3>
            </div>
        </div>
    </a>
</li>