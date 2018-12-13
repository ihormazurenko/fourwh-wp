<?php
get_header();

$title                  = get_the_title();
$dates                  = get_field('dates');
$country                = get_field('country');
$event_type             = get_field('event_type');
$information            = get_field('information');
$external_button_group  = get_field('external_button_group');


?>

    <section class="section content-wrapper section-event">
        <div class="container">

            <h1 class="section-title smaller line"><?php echo $title; ?></h1>

            <div class="video-list content">

                <div class="list-item">

                    <?php if (has_post_thumbnail()) { ?>
                        <div class="image">
                            <?php the_post_thumbnail('large', array(
                                'alt'   => esc_attr($title)
                            )); ?>
                        </div>
                    <?php } ?>

                    <div class="text">
                        <?php if ( $dates || $country ) : ?>
                            <ul>
                                <?php if ( $dates && is_array( $dates ) && count( $dates ) > 0 ) : ?>
                                    <?php
                                        $start = $dates['start'];
                                        $end = $dates['end'];

                                        if (strtotime( $start ) <= strtotime( $end )) {
                                            $date = funcDate($start, $end, true);
                                        } else {
                                            $date = $start;
                                        }

                                    ?>
                                    <li><i class="far fa-calendar-alt"></i> <?php echo $date; ?></li>
                                <?php endif; ?>
                                <?php if ( $country ) : ?>
                                    <li><i class="fas fa-map-marker"></i> <?php echo $country; ?></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                        <?php
                            if ( $event_type == 'internal' ) :
                                if ( $information && is_array( $information ) && count( $information ) > 0 ) :
                                    $location   = $information['location'];
                                    $details    = $information['details'];

                                    if ( $location ) {
                                        ?>
                                        <h5><?php _e('Location', 'fw_campers'); ?></h5>
                                        <div class="address"><?php echo $location; ?></div>
                                        <?php
                                    }
                                    if ( $details ) {
                                        ?>
                                        <h5><?php _e('Details', 'fw_campers'); ?></h5>
                                        <?php echo $details; ?>
                                        <?php
                                    }
                                endif;
                            elseif ( $event_type == 'external' ) :
                                if ( $external_button_group && is_array( $external_button_group ) && count( $external_button_group ) > 0 ) {
                                    $label  = $external_button_group['label'];
                                    $link   = $external_button_group['link'];
                                    $target = $external_button_group['target'] ? 'target="_blank"' : '';

                                    echo '<a href="' . esc_url( $link ) . '" title="' . esc_attr( $label ) . '" class="btn blue inverse" '.$target.'>' . $label . '</a>';
                                }
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>