<?php
    $title    = get_the_title();
    $url      = get_permalink();
    $term     = '';
    $category = get_the_terms($post->ID, 'video_category');

    if( isset($category) && is_array($category) ) :
        $term = array_pop($category);
    endif;
?>
          
<a href="<?php echo esc_url( $url ); ?>" class="itemlink_gallery" title="<?php echo esc_attr($title); ?>">
  <div class="list-item">

    <?php if (has_post_thumbnail()) { ?>

      <div class="image">
        <?php the_post_thumbnail('max-width-2800', array(
            'alt'   => esc_attr($title)
        )); ?><i class="fas fa-play-circle"></i>
      </div>

      <div class="text">
        <h5><?php echo $title; ?></h5>
      </div>

    <?php } ?>

  </div>
</a>