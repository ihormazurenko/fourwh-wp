<?php

get_header();

$current_fp    = get_query_var('flocation');
$show_showroom = get_field('show_our_showroom');
$show_sale     = get_field('show_campers_for_sale');
//var_dump($current_fp);
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php
	if (!$current_fp) {
		get_template_part( 'single', 'location-index' );
	} else if ($current_fp == 'showroom' && $show_showroom) {
		get_template_part( 'single', 'location-showroom' );
	} else if ($current_fp == 'campers-for-sale' && $show_sale) {
	  get_template_part( 'single', 'location-campers-for-sale' );
  } else {
      get_template_part( 'single', 'location-index' );
  }
	?>
<?php endwhile;  else:  ?>

  <section class="section section-content content-wrapper">
    <div id="content"></div>
    <div class="container">
      <p><?php  _e('Sorry, this page does not exist.', 'fw_campers'); ?></p>
    </div>
  </section>

<?php endif; ?>

<?php get_footer(); ?>

