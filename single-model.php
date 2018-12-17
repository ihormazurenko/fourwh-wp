<?php
get_header();

$current_fp = get_query_var('fpage');

?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php
        if (!$current_fp) {
            get_template_part( 'single', 'model-index' );
        } else if ($current_fp == 'build') {
            get_template_part( 'single', 'model-build' );
        };
    ?>
<?php endwhile;  else:  ?>

    <section class="section section-content content-wrapper">
        <div class="container">
            <p><?php  _e('Sorry, this page does not exist.', 'fw_campers'); ?></p>
        </div>
    </section>

<?php endif;  ?>

<?php get_footer(); ?>