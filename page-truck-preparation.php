<?php
/**
 * Template Name: Truck Preparation
 */
get_header();
$steps = get_field('lr_steps');
$bottom_content = get_field('bottom_content');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-truck-preparation">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <?php
                if ( $steps && is_array( $steps ) && count( $steps ) > 0 ) :
                   
                   ?>

                    <div class="prep-steps content">
                      <?php foreach ( $steps as $key=>$step ) : 
                        $title = $step['title'];
                        $image = $step['image'];
                        $image_size = 'original';
                        $text = $step['text'];

                        ?>
                        <div class="prep-step">
                            <div class="image"><?php print wp_get_attachment_image( $image, $image_size ); ?></div>
                            <div class="text">
                                <h3><?php echo $title; ?></h3>
                                <?php echo $text; ?>                                
                            </div>
                        </div>
                        <?php endforeach; ?>
                      </div>

                      <?php if($bottom_content) :   ?>
                        <div class="prep_subcontent content">
                            <?php print $bottom_content; ?>
                        </div>
                      <?php endif; ?>
                <?php endif; ?>

    
                 
        </div>
    </section>

<?php get_footer(); ?>