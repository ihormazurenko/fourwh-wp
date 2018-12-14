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

   if ( $event_type == 'external' ) {
        if ( $external_button_group && is_array( $external_button_group ) && count( $external_button_group ) > 0 ) {
            $label  = $external_button_group['label'] ? $external_button_group['label'] : $label;
            $url    = $external_button_group['link'];
            $target = $external_button_group['target'] ? 'target="_blank"' : '';
        }
    }

?>

<a href="<?php echo esc_url( $url ); ?>" class="itemlink" title="<?php echo esc_attr($title); ?>" <?php echo $target; ?> >
    <div class="list-item">
        <?php if (has_post_thumbnail()) { ?>
           <div class="image">
                <?php the_post_thumbnail('medium_large', array(
                    'alt'   => esc_attr($title)
                )); ?>
            </div>
        <?php } ?>

        <div class="text">
            <h3><?php echo $title; ?></h3>
            <?php if ( ( $dates_start_U && $dates_end_U ) || $country ) : ?>
                <ul>
                    <?php if ( $dates_start_U && $dates_end_U ) : ?>
                        <li><i class="far fa-calendar-alt"></i> <?php echo funcDate( $dates_start_U, $dates_end_U ); ?></li>
                    <?php endif; ?>
                    <?php if ( $country ) : ?>
                        <li><i class="fas fa-map-marker"></i> <?php echo $country; ?></li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
            <span href="<?php echo esc_url( $url ); ?>" class="btn blue inverse" title="<?php echo esc_attr( $label ); ?>"><?php echo $label; ?></span>
        </div>

    </div>
</a>