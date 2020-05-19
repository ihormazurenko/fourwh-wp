<?php
    $title = get_the_title();
    $url = get_permalink();
    $term = '';
    $category = get_the_terms($post->ID, 'video_category');

    if(isset($category) && is_array($category)) :
        $term = array_pop($category);
    endif;

    $label                  = translate('Watch Video', 'fc_details');
    $target                 = '';

?>

<a href="<?php echo esc_url( $url ); ?>" class="itemlink" title="<?php echo esc_attr($title); ?>" <?php echo $target; ?> >
    <div class="list-item">
        <?php if (has_post_thumbnail()) { ?>
        <div class="image">
                <?php the_post_thumbnail('max-width-2800', array(
                    'alt'   => esc_attr($title)
                )); ?><i class="fas fa-play-circle"></i>
            </div>
        <?php } ?>

        <div class="text">
            <?php if($term) : ?>
                <h6><?php print $term->name; ?></h6> 
            <?php endif; ?>
            <h3><?php echo $title; ?></h3>
            
            <span href="<?php echo esc_url( $url ); ?>" class="btn blue inverse" title="<?php echo esc_attr( $label ); ?>"><?php echo $label; ?></span>

        </div>

    </div>
</a>
