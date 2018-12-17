<?php
/**
 * Template Name: Dealer Inventory
 */
get_header();
$rows = get_field('rows');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-career">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <?php
                if ( $rows && is_array( $rows ) && count( $rows ) > 0 ) :
                      ?>
                      <ul class="inventory-list">
                          <?php 
                          foreach ( $rows as $key=>$row ) : 
                            $title = $row['title'];
                            $subtitle = $row['subtitle'];
                            $description = $row['description'];
                            $website = $row['website'];
                            $image = $row['image'];
                            $image_size = 'original';

                            if($key % 2) :
                            ?>
                            <li>
                                <div class="inventory-box">
                                    <div class="inner-box">
                                        <div class="inner-content-wrap">
                                            <h3 class="inventory-title"><?php print $title; ?></h3>
                                            <?php if($subtitle) : ?>
                                              <h4 class="inventory-subtitle"><?php print $subtitle; ?></h4>
                                            <?php endif; ?>

                                            <?php if($description) : ?>
                                              <div class="content">
                                                  <?php echo $description; ?>
                                              </div>
                                            <?php endif; ?>

                                        </div>
                                        <a target="_blank" href="<?php echo $website; ?>" class="btn blue inverse" title="Go Store">Learn More</a>
                                    </div>
                                    <div class="inner-box">
                                        <div class="centered-img wider">
                                            <?php print wp_get_attachment_image( $image, $image_size ); ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php else : ?>
                            <li>
                                <div class="inventory-box">
                                    <div class="inner-box">
                                        <div class="centered-img wider">
                                            <?php print wp_get_attachment_image( $image, $image_size ); ?>
                                        </div>
                                    </div>
                                    <div class="inner-box">
                                        <div class="inner-content-wrap">
                                            <h3 class="inventory-title"><?php print $title; ?></h3>
                                            <?php if($subtitle) : ?>
                                              <h4 class="inventory-subtitle"><?php print $subtitle; ?></h4>
                                            <?php endif; ?>

                                            <?php if($description) : ?>
                                              <div class="content">
                                                  <?php echo $description; ?>
                                              </div>
                                            <?php endif; ?>

                                        </div>
                                        <a target="_blank" href="<?php echo $website; ?>" class="btn blue inverse" title="Go Store">Learn More</a>
                                    </div>
                                </div>
                            </li>
                            <?php endif; ?>
                          <?php endforeach; ?>
                      </ul>
    
                <?php

                endif;
            ?>
        </div>
    </section>

<?php get_footer(); ?>