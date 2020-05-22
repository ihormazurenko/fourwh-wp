<?php

get_header();

$current_fp = get_query_var('flocation');
//var_dump($current_fp);
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php
	if (!$current_fp) {
		get_template_part( 'single', 'location-index' );
	} else if ($current_fp == 'showroom') {
		get_template_part( 'single', 'location-showroom' );
	} else if ($current_fp == 'campers-for-sale') {
	  get_template_part( 'single', 'location-campers-for-sale' );
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

