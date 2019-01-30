<?php
/**
 * Template Name: Testimonials
 */
get_header();
$testimonials = get_field('testimonial_list');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-testimonials">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <?php
                if ( $testimonials && is_array( $testimonials ) && count( $testimonials ) > 0 ) :
                   
                   foreach ( $testimonials as $testimonial ) : 

                   $title        = $testimonial['title'];
                   $text         = $testimonial['text'];
                   $name         = $testimonial['name'];
                   $location   = $testimonial['city_state'];

                   ?>

                      <div class="testimonial_item">
                        <div class="left">
                          <span class="name"><?php echo $name ; ?></span>
                          <span class="location"><?php echo $location ; ?></span>
                        </div>
                        <div class="right">
                          <h4><?php echo $title ; ?></h4>
                          <p><?php echo $text ; ?></p>
                        </div>
                      </div>
                   <?php endforeach; 
                    

                endif;
            ?>
        </div>
    </section>

<?php get_footer(); ?>