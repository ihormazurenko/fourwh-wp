<?php
get_header();

$title            = get_the_title();
$url              = get_permalink();
$locations        = get_field('location');

$show_our_showroom  = get_field('show_our_showroom');
$our_showroom       = $show_our_showroom ? get_field('our_showroom') : '';

$show_campers_for_sale = get_field('show_campers_for_sale');

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-location">
        <div id="content"></div>
        <div class="container">

            <?php
                if ($our_showroom && is_array($our_showroom) && count($our_showroom) > 0) :
                    $showroom_title             =  trim($our_showroom['title']) ? $our_showroom['title'] : '';
                    $showroom_description       =  $our_showroom['description'] ? $our_showroom['description'] : '';
                    $showroom_address           =  $our_showroom['address'] ? $our_showroom['address'] : '';
//                    $showroom_campers_for_sale  =  $our_showroom['campers_for_sale'] ? $our_showroom['campers_for_sale'] : '';
                    $showroom_showroom_video    =  $our_showroom['showroom_video'] ? $our_showroom['showroom_video'] : '';

                    if ($showroom_title || $showroom_description) :

                        if ($showroom_title)
                            echo '<h1 class="section-title smaller line">' . $showroom_title . '</h1>';

                        if ($show_campers_for_sale)
                            echo '<div class="centered-btn-box"><a class="btn blue" href="'.get_permalink().'campers-for-sale/" title="'.esc_attr__('See Campers for Sale','fw_campers').'">'.__('See Campers for Sale','fw_campers').'</a></div>';

                        if ($showroom_description)
                            echo '<div class="section-desc content">' . $showroom_description . '</div>';

                        if ($showroom_address)
                            echo '<div class="showroom-address-box"><i class="fas fa-map-marked"></i>'.$showroom_address.'</div>';

                    endif;

                    get_template_part('inc/section', 'campers-for-sale');

                endif;
            ?>


        </div>
    </section>

    <?php
      if ($showroom_showroom_video && is_array($showroom_showroom_video) && count($showroom_showroom_video) > 0) :
        $video_url = trim($showroom_showroom_video['video_url']) ? $showroom_showroom_video['video_url'] : '';
        $video_thumb_url    = $showroom_showroom_video['image'] ? $showroom_showroom_video['image']['sizes']['max-width-2800'] : getVideoThumbnail($video_url);
        if ($video_url && $video_thumb_url) :
          ?>
          <section class="section content-wrapper section-our-showroom">
            <div class="container">
              <?php
                echo '<h2 class="section-title smaller">' . __('See Our Showroom','fw_campers') . '</h2>';

                echo '<a href="' . $video_url . '?autoplay=1&muted=0&loop=1" class="youtube-video blue" title="' . __('See Our Showroom','fw_campers') . '">
                        <div class="video-preview">
                          <img src="' . $video_thumb_url . '" alt="' . __('See Our Showroom','fw_campers') . '">
                        </div>';
                echo '</a>';
              ?>
            </div>
          </section>
          <?php
      endif;
    endif;
  ?>

<?php get_footer(); ?>
