<?php
    $title = get_the_title();
    $url = get_permalink();

    
    $label                  = translate('Watch Video', 'fc_details');
    $target                 = '';

   

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
            
            <span href="<?php echo esc_url( $url ); ?>" class="btn blue inverse" title="<?php echo esc_attr( $label ); ?>"><?php echo $label; ?></span>
        </div>

    </div>
</a>