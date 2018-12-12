<?php
/**
 * Template Name: Contact Us
 */
get_header();

$form           = get_field('contact_us_form');
$contact_info   = get_field('contact_info');

//if (is_array($form) && is_object($form[0])) {
//    echo "<div class='form-page-wrap'>";
//    echo do_shortcode('[contact-form-7 id="'.$form[0]->ID.'" title="'.$form[0]->post_title.'"]');
//    echo "</div>";
//}

?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-contact">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

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