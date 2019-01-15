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
                            $images = $row['image'];
                            $images_count = count($images);

                            if($key % 2) :
                                ?>
                                <li>
                                    <div class="inventory-box">
                                        <div class="inner-box">
                                            <div class="inner-wrap">
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
                                                <a target="_blank" rel="nofollow" href="<?php echo $website; ?>" class="btn blue inverse" title="Go Store">Learn More</a>
                                            </div>
                                        </div>
                                        <div class="inner-box">
                                            <?php
                                            if ($images && is_array($images) && count($images) >  0) :
                                                if ($images_count > 1) {
                                                    echo '<div class="dealer-slider">
                                                                <div class="swiper-container">
                                                                    <div class="swiper-wrapper">';
                                                }
                                                foreach ($images as $key => $image) :
                                                    $image_url = $image['sizes']['max-width-2800'] ? $image['sizes']['max-width-2800'] : $image['url'];
                                                    $image_class = $image['width'] > $image['height'] ? 'wider' : '';

                                                    if ($images_count > 1) {
                                                        echo '<div class="swiper-slide" style="background-image: url('.$image_url .') "></div>';
                                                    } else {
                                                        ?>
                                                        <div class="centered-img <?php echo $image_class; ?>">
                                                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                                        </div>
                                                        <?php
                                                    }
                                                endforeach;
                                                if ($images_count > 1) {
                                                    echo '</div>
                                                              <div class="swiper-pagination"></div>
                                                            </div>
                                                        </div>';
                                                }
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </li>
                            <?php else : ?>
                                <li>
                                    <div class="inventory-box">
                                        <div class="inner-box">
                                            <?php
                                                if ($images && is_array($images) && count($images) >  0) :
                                                    if ($images_count > 1) {
                                                        echo '<div class="dealer-slider">
                                                                <div class="swiper-container">
                                                                    <div class="swiper-wrapper">';
                                                    }
                                                        foreach ($images as $key => $image) :
                                                            $image_url = $image['sizes']['max-width-2800'] ? $image['sizes']['max-width-2800'] : $image['url'];
                                                            $image_class = $image['width'] > $image['height'] ? 'wider' : '';

                                                                if ($images_count > 1) {
                                                                    echo '<div class="swiper-slide" style="background-image: url('.$image_url .') "></div>';
                                                                } else {
                                                                    ?>
                                                                    <div class="centered-img <?php echo $image_class; ?>">
                                                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                                                    </div>
                                                                    <?php
                                                                }
                                                        endforeach;
                                                    if ($images_count > 1) {
                                                        echo '</div>
                                                              <div class="swiper-pagination"></div>
                                                            </div>
                                                        </div>';
                                                    }
                                                endif;
                                            ?>
                                        </div>
                                        <div class="inner-box">
                                            <div class="inner-wrap">
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
                                                <a target="_blank" rel="nofollow" href="<?php echo $website; ?>" class="btn blue inverse" title="Go Store">Learn More</a>
                                            </div>
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