<?php
/**
 * Template Name: Truck Selector
 */
get_header();

$truck_sizes = get_field('truck_sizes');
?>

    <?php get_template_part('inc/hero', 'banner'); ?>

    <section class="section content-wrapper section-select-truck" id="truck-search">
        <div class="container">

            <?php get_template_part('inc/section', 'info'); ?>

            <?php
                if ( $truck_sizes && is_array( $truck_sizes ) && count( $truck_sizes ) > 0 ) :
                    echo '<ul class="select-truck-list">';
                    foreach ($truck_sizes as $key => $truck_size) :
                        $group_label    = $truck_size['label'];
                        $group_photo    = $truck_size['photo'];
                        $group_slug     = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($group_label))) );
                        $group_slug     = preg_replace('/(-)\1+/','-', $group_slug );
                        ?>
                        <li>
                            <div class="select-truck-box">
                                <input type="radio" id="truck-<?php echo esc_attr( $key ); ?>" name="your-truck" class="radio-truck" data-truck-type="<?php echo esc_attr( $group_slug ); ?>" value="<?php echo esc_attr( $group_slug ); ?>">
                                <label for="truck-<?php echo esc_attr( $key ); ?>">
                                    <div class="select-truck-img-wrap">
                                        <?php if ( $group_photo ) : ?>
                                            <img src="<?php echo esc_url( $group_photo ); ?>" alt="<?php echo esc_attr( $group_label ); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <?php if ( $group_label ) { ?>
                                        <h3 class="select-truck-name"><?php echo $group_label; ?></h3>
                                    <?php } ?>
                                </label>
                            </div>
                        </li>
                        <?php
                    endforeach;
                    echo "</ul>";
                endif;


                if ( $truck_sizes && is_array( $truck_sizes ) && count( $truck_sizes ) > 0 ) :
                    foreach ($truck_sizes as $size_key => $truck_size) :
                        $bed_length_label      = $truck_size['label'];
                        $bed_length_slug       = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($bed_length_label))) );
                        $bed_length_slug       = preg_replace('/(-)\1+/','-', $bed_length_slug );
                        $bed_length_group      = $truck_size['bed_length_group'];

                        if ( $bed_length_group && is_array( $bed_length_group ) && count( $bed_length_group ) > 0 ) :
                            $bed_length_title    = $bed_length_group['group_title'];
                            $bed_length_desc     = $bed_length_group['group_description'];
                            $bed_length     = $bed_length_group['bed_length'];

                            ?>
                                <div class="choose-bed-length-box" data-truck-group="<?php echo esc_attr( $bed_length_slug ); ?>">
                                    <?php if ( $bed_length_title ) : ?>
                                        <h2 class="section-title smaller line"><?php echo $bed_length_title; ?></h2>
                                    <?php endif; ?>
                                    <?php if ($bed_length_desc) : ?>
                                        <div class="section-desc content">
                                            <p><?php echo $bed_length_desc; ?></p>
                                        </div>
                                    <?php endif; ?>
                                        <ul class="select-truck-list bed-length">
                                        <?php
                                            if ( $bed_length && is_array( $bed_length ) && count( $bed_length ) > 0 ) :
                                                foreach ($bed_length as $key => $group ) :
                                                    $group_label            = $group['label'];
                                                    $group_photo            = $group['photo'];
                                                    $group_selector_type    = $group['selector_type'];
                                                    $group_single_model     = $group['single_model'][0];
                                                    $group_multiple_models  = $group['multiple_models'];
                                                    $taxonomy               = 'model_sizes';
                                                    $group_url              = '';
                                                    $group_btn_type         = '';


                                                    if ( $group_selector_type == 'multiple' ) {
                                                        $term = get_term_by('id', (int)$group_multiple_models, $taxonomy);
                                                        if ($term->count == 1) {
                                                            $single_page = get_posts(array(
                                                                'post_type' => 'model',
                                                                'numberposts' => -1,
                                                                'tax_query' => array(
                                                                    array(
                                                                        'taxonomy' => $taxonomy,
                                                                        'field' => 'id',
                                                                        'terms' => $term->term_id, // Where term_id of Term 1 is "1".
                                                                        'include_children' => true
                                                                    )
                                                                )
                                                            ));

                                                            if ($single_page && is_array($single_page) && count($single_page) > 0) {
                                                                $single_page_id = $single_page[0]->ID;
                                                                $group_url = $group_single_model ? get_permalink($single_page_id) : '';
                                                                $group_btn_type = 'single';
                                                            }

                                                        } else {
                                                            $group_url = $group_multiple_models ? get_term_link($group_multiple_models, $taxonomy) : '';
                                                            $group_btn_type = 'multiple';
                                                        }
                                                    } elseif ( $group_selector_type == 'single') {
                                                        $group_url = $group_single_model ? get_permalink($group_single_model) : '';
                                                        $group_btn_type = 'single';
                                                    }
                                                    ?>
                                                        <li>
                                                            <div class="select-truck-box">
                                                                <input type="radio" id="<?php echo $bed_length_slug.'_'.$key; ?>" name="your-bed-length" class="radio-truck" data-truck-btn="<?php echo $group_btn_type; ?>" data-truck-url="<?php echo esc_url($group_url); ?>" value="<?php echo esc_attr($group_label); ?>">
                                                                <label for="<?php echo $bed_length_slug.'_'.$key; ?>">
                                                                    <div class="select-truck-img-wrap">
                                                                        <?php if ($group_photo) { ?>
                                                                            <img src="<?php echo esc_url($group_photo); ?>" alt="<?php echo esc_attr($group_label); ?>">
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php if ( $group_label ) : ?>
                                                                        <h3 class="select-truck-name"><?php echo $group_label; ?></h3>
                                                                    <?php endif; ?>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php
                                                endforeach;
                                            endif;
                                        ?>
                                        </ul>
                                    <?php ?>
                                </div>
                            <?php
                        endif;
                        ?>

                    <?php endforeach; ?>
                    <div class="select-truck-btn-box">
                        <a href="" class="btn blue" target="_self" title="<?php esc_attr_e('Find my Camper', 'fw_campers'); ?>" data-find-truck><?php _e('Find my Camper', 'fw_campers'); ?></a>
                        <a href="" class="btn blue" target="_self" title="<?php esc_attr_e('Build Now', 'fw_campers'); ?>" data-build-truck><?php _e('Build Now', 'fw_campers'); ?></a>
                    </div>
                <?php endif; ?>
        </div>
    </section>

<?php get_footer(); ?>