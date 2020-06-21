<?php
get_header();

$title            = get_the_title();
$find_dealer_id   = 391;

$show_campers_for_sale  = get_field('show_campers_for_sale');
$campers_for_sale       = $show_campers_for_sale ? get_field('campers_for_sale') : '';

$show_showroom          = get_field('show_our_showroom');
$showroom_type          = get_field('our_showroom_type');
$group_button_showroom  = get_field('our_showroom_link');
$group_button_showroom  = ($group_button_showroom && is_array($group_button_showroom) && count($group_button_showroom) > 0) ? $group_button_showroom : '';
$showroom_btn           = '';

if ($show_showroom) {
    $label      = (!$showroom_type && trim($group_button_showroom['label'])) ? $group_button_showroom['label'] : __('See Our Showroom','fw_campers');
    $link_type  = (!$showroom_type && $group_button_showroom['link_type']) ? $group_button_showroom['link_type'] : 'internal';
    $target     = (!$showroom_type && $group_button_showroom['target']) ? 'target="_blank" rel="nofollow noopener"' : '';

    if ($link_type == 'internal') {
        $link = (!$showroom_type && $group_button_showroom['internal_link']) ? $group_button_showroom['internal_link'] : get_permalink().'showroom/';
    } elseif ($link_type == 'external') {
        $link = (!$showroom_type && $group_button_showroom['external_link']) ? $group_button_showroom['external_link'] : get_permalink().'showroom/';
    }

    $showroom_btn = (!empty($label) && !empty($link)) ? '<a href="' . $link . '" class="btn blue" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>' : '';
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
    <section class="section content-wrapper section-location ">
        <div id="content"></div>
        <div class="container">

            <?php
                if ($campers_for_sale && is_array($campers_for_sale) && count($campers_for_sale) > 0) :
                    $showroom_title = trim($campers_for_sale['title']) ? $campers_for_sale['title'] : '';
//                    $our_facility   = trim($campers_for_sale['our_facility']) ? $campers_for_sale['our_facility'] : '';
//                    $campers_list   = $campers_for_sale['campers_list'] ? $campers_for_sale['campers_list'] : '';

                    if ($showroom_title)
                        echo '<h1 class="section-title smaller line">' . $showroom_title . '</h1>';
                    ?>

                    <div class="categories">
                        <ul>
                            <?php

                                echo '<li><a href="'.get_permalink($find_dealer_id).'?dealer-id='.get_the_ID().'" class="btn blue-light small back-btn" title="'.__('Back to dealer locations','fw_campers').'"><i class="fas fa-angle-left"></i>'.__('Back to dealer locations','fw_campers').'</a></li>';

                                if ($show_showroom && $showroom_btn) {
                                    echo '<li>'.$showroom_btn.'</li>';
                                }

                                if ($show_facility && $facility_btn) {
                                  echo '<li>'.$facility_btn.'</li>';
                                }

                            ?>
                        </ul>
                    </div>

                    <?php
                    get_template_part('inc/section', 'campers-for-sale');
                endif;
            ?>
        </div>
    </section>

<?php get_footer(); ?>
