<?php
/**
 * Template Name: Rent
 */
get_header();
$rental = get_field('rental');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-career">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <?php
                if ( $rental && is_array( $rental ) && count( $rental ) > 0 ) :
                   $image                   = $rental['image']['sizes']['large'] ? $rental['image']['sizes']['large'] : $rental['image']['url'];
                   $content                 = $rental['content'];
                   $provide               = $rental['provide_list'];
                   $provide_title         = $rental['provide_title'];
                   $features               = $rental['features_list'];
                   $features_title         = $rental['features_title'];
                   $available_rentals        = $rental['available_rentals_list'];
                   $available_rentals_title  = $rental['available_rentals_title'];
                   

                   if ( $image || $content ) :
                       ?>
                       <div class="career-info-box">
                           <div class="left-box">
                               <?php if ( $image ) : ?>
                                   <div class="career-img-wrap">
                                       <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( the_title() ); ?>">
                                   </div>
                               <?php endif; ?>
                           </div>
                           <div class="right-box">
                               <?php if( $content ) : ?>
                                   <div class="career-desc-box">
                                       <div class="inner-box content">
                                           <?php echo $content; ?>
                                       </div>
                                   </div>
                               <?php endif; ?>
                           </div>
                       </div>
                        <?php
                   endif;

                   if ( $provide_title || ( $provide && is_array( $provide ) && count( $provide ) > 0 ) ) :
                       if ( $provide_title ) :
                            ?>
                                <h2 class="group-title center"><?php echo $provide_title; ?></h2>
                            <?php
                       endif;

                       if ( $provide ) :
                            ?>
                           <ul class="career-positions-list">
                                <?php foreach ( $provide as $value ) : ?>
                                    <li><?php echo $value['text']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php
                       endif;
                   endif;

                    

                    if ( $features_title || ( $features && is_array( $features ) && count( $features ) > 0 ) ) :
                         if ( $features_title ) :
                              ?>
                                  <h2 class="group-title center"><?php echo $features_title; ?></h2>
                              <?php
                         endif;

                         if ( $features ) :
                              ?>
                             <ul class="career-positions-list">
                                  <?php foreach ( $features as $value ) : ?>
                                      <li><?php echo $value['text']; ?></li>
                                  <?php endforeach; ?>
                              </ul>
                              <?php
                         endif;
                    endif;

                    

                    

                    if ( $available_rentals_title || ( $available_rentals && is_array( $available_rentals ) && count( $available_rentals ) > 0 ) ) :
                        if ( $available_rentals_title ) :
                            ?>
                                <h2 class="group-title"><?php echo $available_rentals_title; ?></h2>
                            <?php
                        endif;

                        if ( $available_rentals ) :


                            ?>
                            <ul class="inventory-list">
                                <?php 
                                foreach ( $available_rentals as $key=>$rental ) : 
                                  $rental_title = $rental['title'];
                                  $rental_subtitle = $rental['subtitle'];
                                  $rental_description = $rental['description'];
                                  $rental_website = $rental['rental_website'];
                                  $rental_photo = $rental['icon'];

                                  $image_size = 'max-width-2800';

                                  if($key % 2) :
                                  ?>
                                  <li>
                                      <div class="inventory-box">
                                          <div class="inner-box">
                                              <div class="inner-content-wrap">
                                                  <h3 class="inventory-title"><?php print $rental_title; ?></h3>
                                                  <?php if($rental_subtitle) : ?>
                                                    <h4 class="inventory-subtitle"><?php print $rental_subtitle; ?></h4>
                                                  <?php endif; ?>
      
                                                  <?php if($rental_description) : ?>
                                                    <div class="content">
                                                        <?php echo $rental_description; ?>
                                                    </div>
                                                  <?php endif; ?>

                                              </div>
                                              <a href="<?php echo $rental_website; ?>" class="btn blue inverse" title="Go Store">Learn More</a>
                                          </div>
                                          <div class="inner-box">
                                              <div class="centered-img wider">
                                                  <?php print wp_get_attachment_image( $rental_photo, $image_size ); ?>
                                              </div>
                                          </div>
                                      </div>
                                  </li>
                                  <?php else : ?>
                                  <li>
                                      <div class="inventory-box">
                                          <div class="inner-box"> 
                                              <div class="centered-img wider">
                                                  <?php print wp_get_attachment_image( $rental_photo, $image_size ); ?>
                                              </div>
                                          </div>
                                          <div class="inner-box">
                                              <div class="inner-content-wrap">
                                                  <h3 class="inventory-title"><?php print $rental_title; ?></h3>
                                                  <?php if($rental_subtitle) : ?>
                                                    <h4 class="inventory-subtitle"><?php print $rental_subtitle; ?></h4>
                                                  <?php endif; ?>
      
                                                  <?php if($rental_description) : ?>
                                                    <div class="content">
                                                        <?php echo $rental_description; ?>
                                                    </div>
                                                  <?php endif; ?>

                                              </div>
                                              <a href="<?php echo $rental_website; ?>" class="btn blue inverse" title="Go Store">Learn More</a>
                                          </div>
                                      </div>
                                  </li>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            <?php
                        endif;
                    endif;
                    ?>

                  
                  
                    
                <?php

                endif;
            ?>
        </div>
    </section>

<?php get_footer(); ?>