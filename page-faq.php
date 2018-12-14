<?php
/**
 * Template Name: FAQ
 */
get_header();

$form           = get_field('contact_us_form');
$contact_info   = get_field('contact_info');

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-faq">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <div class="faq-questions content">
                
                <?php

                // check if the repeater field has rows of data
                if( have_rows('questions') ):

                    // loop through the rows of data
                    while ( have_rows('questions') ) : the_row(); ?>

                        
                        <h4 class="accordion"><?php print the_sub_field('question'); ?> <i class="fa fa-chevron-down"></i></h4>
                        <div class="panel">
                          <?php print the_sub_field('answer'); ?>
                        </div>

                <?php 
                   endwhile;

                else :
                    // no rows found
                endif;
                ?>
                
               
            </div>

            <?php if ( $form || ( $contact_info && is_array( $contact_info ) && count( $contact_info ) > 0 ) ) : ?>
                <div class="contact-wrapper">
                    <div class="text content">
                        <?php
                            if ( $contact_info ) :
                                foreach ( $contact_info as $value ) :
                                    $title              = $value['title'];
                                    $information_list   = $value['information'];
                                    ?>
                                        <?php if ( $title ) : ?>
                                            <h4><?php echo $title; ?></h4>
                                        <?php endif; ?>
                                        <?php if ( $information_list && is_array( $information_list ) && count( $information_list ) > 0 ) : ?>
                                            <ul>
                                               <?php foreach ( $information_list as $item ) : ?>
                                                    <li><?php echo $item['icon'] . ' ' . $item['text']; ?></li>
                                               <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                    <?php
                                endforeach;
                            endif;
                        ?>
                    </div>

                    <div class="form">
                        <?php if ( is_object( $form ) ) : ?>
                            <?php echo do_shortcode('[contact-form-7 id="' . $form->ID . '" title="' . $form->post_title . '"]'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php get_footer(); ?>