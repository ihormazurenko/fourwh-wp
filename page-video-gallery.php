<?php
/**
 * Template Name: Video Gallery
 */
get_header(); ?>

<section class="section content-wrapper section-gallery">
  <div id="content"></div>
  <div class="container">
    <?php the_title('<h1 class="section-title smaller line">', '</h1>'); ?>
    <div class="content">

      <?php
      $taxonomy = 'video_category';

      //videos
      global $wp_query;

      $paged = get_query_var('paged') ? get_query_var('paged') : 1;

      $args = array(
          'post_type'        => 'video',
          'post_status'      => 'publish',
          'paged'            => $paged,
          'orderby'          => 'date',
          'order'            => 'DESC',
      );


      $args['tax_query'][] = array(
          array(
              'taxonomy' => $taxonomy,
              'field'    => 'slug',
              'terms'    => array('gallery'),
              'operator' => 'IN'
          )
      );


      $new_query = new WP_Query( $args );

      if ($new_query->have_posts()) {
          echo '<div class="video-gallery content">';
          while ( $new_query->have_posts() ) : $new_query->the_post();

              get_template_part('inc/loop', 'video-gallery');

          endwhile;

          echo "</div>";

          get_template_part('inc/pagination');

      } else {
          echo '<p class="no-results">' . __('Sorry, videos not found...', 'fw_campers') . '</p>';
      }

      wp_reset_query();

      ?>
		
    </div>
  </div>
</section>

<?php get_footer(); ?>