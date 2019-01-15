<?php
/**
 * Template Name: Career
 */
get_header();
$career = get_field('career');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-career">
        <div class="container">
            <?php get_template_part('inc/section', 'info'); ?>

            <?php get_template_part('inc/section', 'content'); ?>

            <?php
                if ( $career && is_array( $career ) && count( $career ) > 0 ) :
                   $image                   = $career['image']['sizes']['large'] ? $career['image']['sizes']['large'] : $career['image']['url'];
                   $content                 = $career['content'];
                   $positions               = $career['positions_list'];
                   $positions_title         = $career['positions_title'];
                   $benefits               = $career['benefits_list'];
                   $benefits_title         = $career['benefits_title'];
                   $people_qualities        = $career['people_qualities'];
                   $people_qualities_title  = $career['people_qualities_title'];
                   $why_we                  = $career['why_we'];

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

                   if ( $positions_title || ( $positions && is_array( $positions ) && count( $positions ) > 0 ) ) :
                       if ( $positions_title ) :
                            ?>
                                <h2 class="group-title center"><?php echo $positions_title; ?></h2>
                            <?php
                       endif;

                       if ( $positions ) :
                            ?>
                           <ul class="career-positions-list">
                                <?php foreach ( $positions as $value ) : ?>
                                    <li><?php echo $value['text']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php
                       endif;
                   endif;

                    if ( $people_qualities_title || ( $people_qualities && is_array( $people_qualities ) && count( $people_qualities ) > 0 ) ) :
                        if ( $people_qualities_title ) :
                            ?>
                                <h2 class="group-title center"><?php echo $people_qualities_title; ?></h2>
                            <?php
                        endif;

                        if ( $positions ) :
                            ?>
                            <ul class="qualities-list">
                                <?php foreach ( $people_qualities as $quality ) : ?>
                                <li>
                                    <div class="qualities-box">
                                        <div class="qualities-img-wrap">
                                            <img src="<?php echo esc_attr( $quality['icon'] )?>" alt="<?php echo esc_attr( $quality['text'] ); ?>">
                                        </div>
                                        <h3 class="qualities-title"><?php echo $quality['text']; ?></h3>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php
                        endif;
                    endif;

                    if ( $benefits_title || ( $benefits && is_array( $benefits ) && count( $benefits ) > 0 ) ) :
                         if ( $benefits_title ) :
                              ?>
                                  <h2 class="group-title center"><?php echo $benefits_title; ?></h2>
                              <?php
                         endif;

                         if ( $benefits ) :
                              ?>
                             <ul class="career-positions-list">
                                  <?php foreach ( $benefits as $value ) : ?>
                                      <li><?php echo $value['text']; ?></li>
                                  <?php endforeach; ?>
                              </ul>
                              <?php
                         endif;
                    endif;

                    if ( $why_we && is_array( $why_we ) && count( $why_we ) > 0 ) :
                        $why_we_content = $why_we['content'];
                        $why_we_button  = $why_we['button'];

                        if ( $why_we_content || ( $why_we_button && is_array( $why_we_button ) && count( $why_we_button ) > 0 ) ) :
                            ?>
                                <div class="apply-info-box">
                                    <?php if ( $why_we_content ) : ?>
                                        <div class="content big"><?php echo $why_we_content; ?></div>
                                    <?php endif; ?>

                                    <?php if ($why_we_button) : ?>
                                        <?php
                                            $label      = $why_we_button['label'];
                                            $link_type  = $why_we_button['link_type'];
                                            $target     = $why_we_button['target'] ? 'target="_blank"' : '';
                                            $link       = '';

                                            if ( $link_type == 'internal' ) {
                                                $link = $why_we_button['internal_link'] ? $why_we_button['internal_link'] : '';
                                            } elseif ( $link_type == 'external') {
                                                $link = $why_we_button['external_link'] ? $why_we_button['external_link'] : '';
                                            }
                                        ?>
                                        <?php if (!empty( $label ) && !empty( $link ) ) : ?>
                                            <a href="<?php echo esc_url( $link ); ?>" class="btn blue big" title="<?php echo esc_attr( $label ); ?>"><?php echo $label; ?></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php
                        endif;
                    endif;

                endif;
            ?>
        </div>
    </section>

<?php get_footer(); ?>