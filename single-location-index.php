<?php

$find_dealer_id = 391;
header("Location: ".get_permalink($find_dealer_id));

exit();

get_header();
?>

<section class="section section-content content-wrapper">
    <div id="content"></div>
    <div class="container">
        <p><?php  _e('Sorry, this page does not exist.', 'fw_campers'); ?></p>
    </div>
</section>


<?php get_footer(); ?>
