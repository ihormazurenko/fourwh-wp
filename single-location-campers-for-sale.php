<?php
get_header();

$title            = get_the_title();
$find_dealer_id   = 391;

$show_campers_for_sale  = get_field('show_campers_for_sale');
$show_our_showroom      = get_field('show_our_showroom');
$campers_for_sale       = $show_campers_for_sale ? get_field('campers_for_sale') : '';

?>
    <section class="section content-wrapper section-location ">
        <div id="content"></div>
        <div class="container">

            <?php
                if ($campers_for_sale && is_array($campers_for_sale) && count($campers_for_sale) > 0) :
                    $showroom_title = trim($campers_for_sale['title']) ? $campers_for_sale['title'] : '';
                    $our_facility   = trim($campers_for_sale['our_facility']) ? $campers_for_sale['our_facility'] : '';
//                    $campers_list   = $campers_for_sale['campers_list'] ? $campers_for_sale['campers_list'] : '';

                    if ($showroom_title)
                        echo '<h1 class="section-title smaller line">' . $showroom_title . '</h1>';
                    ?>

                    <div class="categories">
                        <ul>
                            <?php

                                echo '<li><a href="'.get_permalink($find_dealer_id).'?dealer-id='.get_the_ID().'" class="btn blue-light small back-btn" title="'.__('Back to dealer locations','fw_campers').'"><i class="fas fa-angle-left"></i>'.__('Back to dealer locations','fw_campers').'</a></li>';

                            if ($show_our_showroom) {
                                echo '<li><a href="'.get_permalink().'showroom/" class="btn blue small" title="'.__('See Our Showroom','fw_campers').'">'.__('See Our Showroom','fw_campers').'</a></li>';
                            }

                            if ($our_facility) {
                              echo '<li><a href="'.esc_url($our_facility).'" class="btn blue small" title="'.__('Our Facility','fw_campers').'" target="_blank" rel="nofollow noopener">'.__('Our Facility','fw_campers').'</a></li>';
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
