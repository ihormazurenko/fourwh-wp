<?php
get_header();

$title            = get_the_title();
$url              = get_permalink();
$locations        = get_field('location');

$show_showroom            = get_field('show_our_showroom');
$our_showroom             = $show_showroom ? get_field('our_showroom') : '';
$showroom_showroom_video  = '';


$show_sale          = get_field('show_campers_for_sale');
$sale_type          = get_field('campers_for_sale_type'); //true - block type, false - link
$group_button_sale  = get_field('campers_for_sale_link');
$group_button_sale  = ($group_button_sale && is_array($group_button_sale) && count($group_button_sale) > 0) ? $group_button_sale : '';
$sale_btn           = '';

if ($show_sale) {
    $label      = (!$sale_type && trim($group_button_sale['label'])) ? $group_button_sale['label'] : __('See Campers for Sale','fw_campers');
    $link_type  = (!$sale_type && $group_button_sale['link_type']) ? $group_button_sale['link_type'] : 'internal';
    $target     = (!$sale_type && $group_button_sale['target']) ? 'target="_blank" rel="nofollow noopener"' : '';

    if ($link_type == 'internal') {
        $link = (!$sale_type && $group_button_sale['internal_link']) ? $group_button_sale['internal_link'] : get_permalink().'campers-for-sale/';
    } elseif ($link_type == 'external') {
        $link = (!$sale_type && $group_button_sale['external_link']) ? $group_button_sale['external_link'] : get_permalink().'campers-for-sale/';
    }

    $sale_btn = (!empty($label) && !empty($link)) ? '<a href="' . $link . '" class="btn blue" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>' : '';
}


$show_facility          = get_field('show_our_facility');
$group_button_facility  = $show_facility ? get_field('our_facility') : '';
$group_button_facility  = ($group_button_facility && is_array($group_button_facility) && count($group_button_facility) > 0) ? $group_button_facility : '';
$facility_btn           = '';

if ($group_button_facility) {
    $label      = trim($group_button_facility['label']) ? $group_button_facility['label'] : __('Our Facility','fw_campers');
    $link_type  = $group_button_facility['link_type'] ? $group_button_facility['link_type'] : 'internal';
    $target     = $group_button_facility['target'] ? 'target="_blank" rel="nofollow noopener"' : '';

    if ($link_type == 'internal') {
        $link = $group_button_facility['internal_link'] ? $group_button_facility['internal_link'] : '';
    } elseif ($link_type == 'external') {
        $link = $group_button_facility['external_link'] ? $group_button_facility['external_link'] : '';
    }

    $facility_btn = (!empty($label) && !empty($link)) ? '<a href="' . $link . '" class="btn blue" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>' : '';
}

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

                        if (($show_sale && $sale_btn || ($show_facility && $facility_btn))) {
                            ?>
                            <div class="categories">
                                <ul>
                                    <?php
                                        if ($show_sale && $sale_btn) {
                                          echo '<li>'.$sale_btn.'</li>';
                                        }

                                        if ($show_facility && $facility_btn) {
                                            echo '<li>'.$facility_btn.'</li>';
                                        }
                                    ?>

                                </ul>
                            </div>
                            <?php
                        }

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
