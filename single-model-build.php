<?php
global $wpdb;

$page_id = get_the_ID();
$enable_customizer = get_field('enable_customizer');

if (!$enable_customizer)  :
    if ($_SERVER['HTTP_REFERER'] != null) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: ".get_permalink());
        exit();
    }
else :
    $model_customizer   = get_field('customizer');
    $model_price        = get_field('model_price') ? get_field('model_price') : 0;
    $model_weight       = get_field('model_weight') ? get_field('model_weight') : 0;

    $model_price_print  = $model_price ? '$' . number_format( $model_price, 2, '.', ',' ) : '$0' ;
    $model_weight_print = $model_weight ? number_format( $model_weight, 0, '.', ',' ) . 'lbs' : '0lbs';

    if ($model_customizer && is_array($model_customizer) && count($model_customizer) > 0) {
        $customizer_title   = $model_customizer['title'] ? $model_customizer['title'] : __('Build My Camper: ', 'fw_campers').get_the_title();
        $customizer_content = $model_customizer['content'] ? trim($model_customizer['content']) : '';
        $customize_exterior = $model_customizer['customize_exterior'] ? $model_customizer['customize_exterior'] : '';
    }

    $model_id = get_the_ID();
    $model_name = get_the_title();
    $table_name = 'fourwh_model_relationship';
    $model_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE model_id = %d',$model_id),OBJECT);

    $options_ids    = [];
    $options_arr    = [];
    $group_desc_arr = [];
    $status_arr     = [];
    $taxonomy       = 'groups';

    foreach ($model_relationship as $key => $value) {
        if ($value->status != 'not_available' && $value->status != '' && $value->trash != 1) {
            $options_ids[]                  = $value->option_id;
            $status_arr[$value->option_id]  = $value->status;
        }
    }

    $option_args = array(
        'post_type'         => 'model_option',
        'post_status'       => 'publish',
        'post__in'          => $options_ids,
        'posts_per_page'    => -1,
        'orderby'           => 'post__in'
    );

    $option_query = new WP_Query( $option_args );
    if ( $option_query->have_posts() )  :
        while ( $option_query->have_posts()) : $option_query->the_post();
            $option_id          = $option_query->post->ID;

            $meta = new stdClass;
            foreach( (array) get_post_meta($option_id ) as $k => $v ) $meta->$k = $v[0];

            $option_name        = get_the_title() ? get_the_title() : '';
            $option_price       = $meta->option_info_price ? $meta->option_info_price : 0;
            $option_weight      = $meta->option_info_weight ? $meta->option_info_weight : 0;
            $option_desc        = $meta->description ? $meta->description : '';
            $option_status      = $status_arr[$option_id];
            $option_group       = get_the_terms($option_id, 'groups');



            if ( strtolower($option_group[0]->name) === strtolower('Cushion Fabric Colors') || strtolower($option_group[0]->name) === strtolower('Exterior Siding') ) {
                $option_thumb_id    = $meta->thumbnail ? $meta->thumbnail : '';
                $option_thumb_arr   = $option_thumb_id ? image_downsize($option_thumb_id, 'thumbnail') : '';
                $option_thumb_url   = $option_thumb_arr[0] ? $option_thumb_arr[0] : '';
                $option_thumb_class = ($option_thumb_arr[1] > $option_thumb_arr[2]) ? 'wider' : '';

                $option_medium_large_photo_id    = $meta->photo ? $meta->photo : $meta->thumbnail;
                $option_medium_large_photo_arr   = $option_medium_large_photo_id ? image_downsize($option_medium_large_photo_id, 'medium_large') : '';
                $option_medium_large_photo_url   = $option_medium_large_photo_arr[0] ? $option_medium_large_photo_arr[0] : '';
                $option_medium_large_photo_class = ($option_medium_large_photo_arr[1] > $option_medium_large_photo_arr[2]) ? 'wider' : '';

                $option_full_photo_id    = $meta->photo ? $meta->photo : $meta->thumbnail;
                $option_full_photo_arr   = $option_full_photo_id ? image_downsize($option_full_photo_id, 'full') : '';
                $option_full_photo_url   = $option_full_photo_arr[0] ? $option_full_photo_arr[0] : '';
                $option_full_photo_class = ($option_full_photo_arr[1] > $option_full_photo_arr[2]) ? 'wider' : '';
            } else {
                $option_thumb_id    = $meta->thumbnail ? $meta->thumbnail : '';
                $option_thumb_arr   = $option_thumb_id ? image_downsize($option_thumb_id, 'medium_large') : '';
                $option_thumb_url   = $option_thumb_arr[0] ? $option_thumb_arr[0] : '';
                $option_thumb_class = ($option_thumb_arr[1] > $option_thumb_arr[2]) ? 'wider' : '';

                $option_full_photo_id    = $meta->photo ? $meta->photo :  $meta->thumbnail;
                $option_full_photo_arr   = $option_full_photo_id ? image_downsize($option_full_photo_id, 'full') : '';
                $option_full_photo_url   = $option_full_photo_arr[0] ? $option_full_photo_arr[0] : '';
                $option_full_photo_class = ($option_full_photo_arr[1] > $option_full_photo_arr[2]) ? 'wider' : '';
            }

            if (is_array($option_group)) {
                $group_id         = trim($option_group[0]->term_id);
                $group_name         = trim($option_group[0]->name);
                $group_desc         = trim($option_group[0]->description);
                $parent_group_id    = $option_group[0]->parent != 0 ? $option_group[0]->parent : '';
                $parent_group_name  = $parent_group_id ? get_term($parent_group_id) : 'other';
                $group_check_type   = get_field('people_select', $taxonomy.'_'.$group_id);

                if ( $parent_group_name->name ) {
                    if ( strtolower($option_group[0]->name) === strtolower('Cushion Fabric Colors') || strtolower($option_group[0]->name) === strtolower('Exterior Siding') ) {
                        $options_arr[$parent_group_name->name][$group_name][] = [
                            'option_id'                 => $option_id,
                            'name'                      => $option_name,
                            'price'                     => $option_price,
                            'weight'                    => $option_weight,
                            'full_photo'                => $option_full_photo_url,
                            'full_photo_class'          => $option_full_photo_class,
                            'medium_large_photo'        => $option_medium_large_photo_url,
                            'medium_large_photo_class'  => $option_medium_large_photo_class,
                            'thumbnail'                 => $option_thumb_url,
                            'thumbnail_class'           => $option_thumb_class,
                            'status'                    => $option_status,
                            'desc'                      => $option_desc,
                        ];
                    } else {
                        $options_arr[$parent_group_name->name][$group_name][] = [
                            'option_id'         => $option_id,
                            'name'              => $option_name,
                            'price'             => $option_price,
                            'weight'            => $option_weight,
                            'full_photo'        => $option_full_photo_url,
                            'full_photo_class'  => $option_full_photo_class,
                            'thumbnail'         => $option_thumb_url,
                            'thumbnail_class'   => $option_thumb_class,
                            'status'            => $option_status,
                            'desc'              => $option_desc,
                        ];
                    }
                } else {
                    $options_arr['Other'][$group_name][] = [
                        'option_id'         => $option_id,
                        'name'              => $option_name,
                        'price'             => $option_price,
                        'weight'            => $option_weight,
                        'full_photo'        => $option_full_photo_url,
                        'full_photo_class'  => $option_full_photo_class,
                        'thumbnail'         => $option_thumb_url,
                        'thumbnail_class'   => $option_thumb_class,
                        'status'            => $option_status,
                        'desc'              => $option_desc,
                    ];
                }

                $group_desc_arr[$group_name]['desc']        = $group_desc;
                $group_desc_arr[$group_name]['check-type']  = $group_check_type;
            } else {
                $options_arr['Other']['Other'][] = [
                    'option_id'         => $option_id,
                    'name'              => $option_name,
                    'price'             => $option_price,
                    'weight'            => $option_weight,
                    'full_photo'        => $option_full_photo_url,
                    'full_photo_class'  => $option_full_photo_class,
                    'thumbnail'         => $option_thumb_url,
                    'thumbnail_class'   => $option_thumb_class,
                    'status'            => $option_status,
                    'desc'              => $option_desc,
                ];

                $group_desc_arr['Other']['desc']        = '';
                $group_desc_arr['Other']['check-type']  = 'multiple';
            }

        endwhile;

        //sort groups
        $sort_options = [];
        ksort($options_arr);
        foreach ($options_arr as $parent => $groups) {
            ksort($groups);
            foreach ($groups as $group => $items) {
                ksort($items);
                foreach ($items as $key => $value) {
                    $sort_options[$parent][$group][$key] = $value;
                }
            }
        }

        $options_arr = $sort_options;

        //move "Cushion Fabric Colors" to the top of group
        if ( $options_arr['Interior Options']['Cushion Fabric Colors'] ) :
            $options_arr['Interior Options'] = array('Cushion Fabric Colors' => $options_arr['Interior Options']['Cushion Fabric Colors']) + $options_arr['Interior Options'];
        endif;

        //move "Exterior Siding" to the top of group
        if ($options_arr['Exterior Options']['Exterior Siding']) :
            $options_arr['Exterior Options'] = array('Exterior Siding' => $options_arr['Exterior Options']['Exterior Siding']) + $options_arr['Exterior Options'];
        endif;

        //move parent Other to end
        if ($options_arr['Other']) :
            $temp = $options_arr['Other'];
            unset($options_arr['Other']);
            $options_arr['Other'] = $temp;
        endif;

        //move "Other" to the top of group
        if ($options_arr['Other']['Other']) :
            $temp = $options_arr['Other']['Other'];
            unset($options_arr['Other']['Other']);
            $options_arr['Other']['Other'] = $temp;
        endif;

        //enable custom exterior
        $exterior_arr = [];

        if ($model_customizer) :
            if ($customize_exterior && is_array($customize_exterior) && count($customize_exterior) > 0) :
                foreach ($customize_exterior as $key => $value) {
                    $exterior_price         = $value['price'] ? $value['price'] : '';
                    $exterior_full_photo    = $value['photo'] ? $value['photo'] : '';
                    $exterior_thumbnail     = $value['thumbnail'] ? $value['thumbnail'] : '';
                    $necessary_option_id    = $value['select_option'][0] ? $value['select_option'][0] : '';

                    $exterior_arr[$necessary_option_id] = [
                        'full_photo'    => $exterior_full_photo,
                        'thumbnail'     => $exterior_thumbnail,
                        'price'         => $exterior_price,
                    ];
                }

                if (is_array($exterior_arr) && count($exterior_arr) > 0) :
                    $options_exterior_arr = $options_arr['Exterior Options']['Exterior Siding'];
                    if (isset($options_exterior_arr)) :

                        foreach ($options_exterior_arr as $key => $value) {
                            $opt_id = $value['option_id'];

                            if (array_key_exists($opt_id, $exterior_arr)) {
                                $new_price      = $exterior_arr[$opt_id]['price'] ? $exterior_arr[$opt_id]['price'] : '';

                                $new_thumbnail = $exterior_arr[$opt_id]['thumbnail'] ? $exterior_arr[$opt_id]['thumbnail'] : '';
                                $new_thumbnail_url = $new_thumbnail['sizes']['thumbnail'] ? $new_thumbnail['sizes']['thumbnail'] : $new_thumbnail['url'];
                                $new_thumbnail_class = $new_thumbnail_url['width'] > $new_thumbnail_url['height'] ? 'wider' : '';

                                $new_medium_large = $exterior_arr[$opt_id]['full_photo'] ? $exterior_arr[$opt_id]['full_photo'] : $exterior_arr[$opt_id]['thumbnail'];
                                $new_medium_large_url = $new_medium_large['sizes']['medium_large'] ? $new_medium_large['sizes']['medium_large'] : $new_medium_large['url'];
                                $new_medium_large_class = $new_medium_large_url['width'] > $new_medium_large_url['height'] ? 'wider' : '';

                                $new_full_photo = $exterior_arr[$opt_id]['full_photo'] ? $exterior_arr[$opt_id]['full_photo'] : $exterior_arr[$opt_id]['thumbnail'];
                                $new_full_photo_url = $new_full_photo['sizes']['full'] ? $new_full_photo['sizes']['full'] : $new_full_photo['url'];
                                $new_full_photo_class = $new_full_photo_class['width'] > $new_full_photo_class['height'] ? 'wider' : '';


                                if ($new_price) {
                                    $options_arr['Exterior Options']['Exterior Siding'][$key]['price'] = $new_price;
                                }

                                if ($new_thumbnail) {
                                    $options_arr['Exterior Options']['Exterior Siding'][$key]['thumbnail']                = $new_thumbnail_url;
                                    $options_arr['Exterior Options']['Exterior Siding'][$key]['thumbnail_class']          = $new_thumbnail_class;
                                }

                                if ($new_medium_large) {
                                    $options_arr['Exterior Options']['Exterior Siding'][$key]['medium_large_photo']       = $new_medium_large_url;
                                    $options_arr['Exterior Options']['Exterior Siding'][$key]['medium_large_photo_class'] = $new_medium_large_class;
                                }

                                if ($new_full_photo) {
                                    $options_arr['Exterior Options']['Exterior Siding'][$key]['full_photo']               = $new_full_photo_url;
                                    $options_arr['Exterior Options']['Exterior Siding'][$key]['full_photo_class']         = $new_full_photo_class;
                                }
                            }
                        }
                    endif;
                endif;

            endif;
        endif;

        //group Cushion Fabric Colors
        $options_fabric_arr = $options_arr['Interior Options']['Cushion Fabric Colors'];

        if (isset($options_fabric_arr)) :
            $fabric_price_arr = array_column( $options_fabric_arr, 'price' );
            $fabric_name_arr = array_column( $options_fabric_arr, 'name' );
            $fabric_status_arr = array_column( $options_fabric_arr, 'status' );

            array_multisort( $fabric_price_arr, SORT_NUMERIC , $fabric_name_arr, SORT_NATURAL | SORT_FLAG_CASE, $options_fabric_arr );

            if ( ! in_array( $fabric_status_arr, 'standard' ) ) {
                $options_fabric_arr[1]['status'] = 'standard';
            }

            $options_arr['Interior Options']['Cushion Fabric Colors'] = $options_fabric_arr;

        endif;

        //group Exterior Siding
        $options_exterior_opt_arr = $options_arr['Exterior Options']['Exterior Siding'];

        if (isset($options_exterior_opt_arr)) :
            $exterior_opt_price_arr = array_column( $options_exterior_opt_arr, 'price' );
            $exterior_opt_name_arr = array_column( $options_exterior_opt_arr, 'name' );
            $exterior_opt_status_arr = array_column( $options_exterior_opt_arr, 'status' );

            array_multisort( $exterior_opt_price_arr, SORT_NUMERIC , $exterior_opt_name_arr, SORT_NATURAL | SORT_FLAG_CASE, $options_exterior_opt_arr );

            if ( ! in_array( $exterior_opt_status_arr, 'standard' ) ) {
                $options_exterior_opt_arr[0]['status'] = 'standard';
            }

            $options_arr['Exterior Options']['Exterior Siding'] = $options_exterior_opt_arr;

        endif;

//        if (get_current_user_id() == 1) :
//            var_dump($group_desc_arr);
//        endif;

    else:
        $options_arr = [];
    endif;

    wp_reset_postdata();

    if( $options_arr && is_array( $options_arr ) && count( $options_arr ) > 0 ) :
        ?>
        <section class="section-build-my-camper">

            <div class="anchor-nav-box build">
                <div class="container">
                    <div class="top-box">
                        <div class="left-box">
                            <a href="<?php echo get_permalink($page_id); ?>" class="back-link" title="<?php esc_attr_e('Back to Models', 'fw_campers'); ?>">&#171; <?php _e('Back to Models','fw-campers'); ?></a>
                            <?php if ( $customizer_title ) { ?>
                                <h1 class="anchor-box-title"><?php echo $customizer_title; ?></h1>
                            <?php } ?>

                        </div>
                        <div class="right-box">
                            <div class="total-camper-box">
                                <span class="price"><?php echo $model_price_print; ?></span>
                                <span class="weight"><?php echo __('Weight: ', 'fw_campers') . $model_weight_print; ?></span>
                            </div>
                        </div>
                    </div>
                    <nav class="anchor-nav">
                        <ul>
                            <?php
                                foreach ($options_arr as $parent_group => $groups) :
                                    $element_id = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($parent_group))) );
                                    $element_id = preg_replace('/(-)\1+/','-', $element_id );
                                    ?>
                                <li>
                                    <a href="#<?php echo $element_id; ?>" title="<?php echo esc_attr( ucwords($parent_group) ); ?>"><?php echo ucwords($parent_group); ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <a href="#summary" title="<?php esc_attr_e('Summary', 'fw_campers'); ?>"><?php _e('Summary','fw-campers'); ?></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <?php if ( !empty($customizer_content) ) { ?>
                <div class="customizer-content-box">
                    <div class="container">
                        <div class="content">
                            <?php echo $customizer_content; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="camper-customizer-box">
                <div class="container">

                    <form action="" class="customizer-form">

                        <div class="no-display">
                            <input type="hidden" name="model_id" data-model="<?php echo get_the_title($model_id); ?>"  value="<?php echo $model_id; ?>" data-model-price="<?php echo $model_price; ?>" data-model-weight="<?php echo $model_weight; ?>">
                            <input type="hidden" name="total-price"  data-total-price value="<?php echo $model_price; ?>">
                            <input type="hidden" name="total-weight"  data-total-weight value="<?php echo $model_weight; ?>">
                        </div>
                        <?php
                            foreach ($options_arr as $parent_group => $groups) :
                                $parent_id         = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($parent_group))) );
                                $parent_id         = preg_replace('/(-)\1+/','-', $parent_id );
                                $parent_group_desc = $group_desc_arr[$parent_group]['desc'];
                                ?>
                                <div class="group-parent-box" id="<?php echo $parent_id; ?>">
                                    <div class="group-header">
                                        <h2 class="section-title small line"><?php echo ucwords($parent_group); ?></h2>
                                        <?php if ($parent_group_desc) : ?>
                                            <div class="section-desc content"><?php echo $parent_group_desc; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (is_array($groups) && count($groups) > 0) : ?>
                                        <?php
                                            foreach ($groups as $group => $items) :
                                                $element_id  = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($group))) );
                                                $element_id  = preg_replace('/(-)\1+/','-', $element_id );
                                                $group_desc  = $group_desc_arr[$group]['desc'];
                                                $group_check = $group_desc_arr[$group]['check-type'];

                                                if ( strtolower($group) === strtolower('Cushion Fabric Colors') || strtolower($group) === strtolower('Exterior Siding') ) :
                                                    $data_attr = (strtolower($group) === strtolower('Cushion Fabric Colors')) ? 'interior' : 'exterior';
                                                    ?>
                                                    <div id="<?php echo $element_id; ?>" class="group-box color-selector-box">
                                                        <div class="group-header">
                                                            <h2 class="group-title"><?php echo ucwords($group); ?></h2>
                                                            <?php if ($group_desc) : ?>
                                                                <div class="section-desc content small"><?php echo $group_desc; ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php
                                                        if (is_array($items) && count($items) > 0) :
                                                            $items_count = count($items);
                                                            ?>
                                                            <div class="left-box">
                                                                <div class="group-img-wrap centered-img">
                                                                    <?php
                                                                    foreach ($items as $key => $value) :
                                                                        if ( strtolower($value['status']) == strtolower('standard') ) {
                                                                            $item_id                    = trim($value['option_id']);
                                                                            $item_name                  = trim($value['name']);
                                                                            $item_full_photo            = trim($value['full_photo']);
                                                                            $item_medium_large_photo    = $value['medium_large_photo'] ? trim($value['medium_large_photo']) : $item_full_photo;
                                                                        }
                                                                    endforeach;
                                                                    ?>
                                                                    <?php if ( $item_full_photo ) { ?>
                                                                        <a class="icon-zoom"
                                                                           href="<?php echo esc_url($item_full_photo); ?>"
                                                                           title="<?php esc_attr_e('Zoom', 'fw_campers'); ?>"></a>
                                                                    <?php } ?>
                                                                    <img src="<?php echo esc_url( $item_medium_large_photo ); ?>" class="group-img active" alt="<?php echo esc_attr( $item_name ); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php
                                                        if (is_array($items) && count($items) > 0) :
                                                            ?>
                                                            <div class="right-box">
                                                                <h3 class="box-title"><?php echo ucwords($group); ?></h3>
                                                                    <?php
                                                                    $img_count   = 0;
                                                                    $items_count = count($items);
                                                                    $item_prev_price = 0;

                                                                    foreach ($items as $key => $value) :
                                                                        $item_id                        = trim($value['option_id']);
                                                                        $item_name                      = trim($value['name']);
                                                                        $item_price                     = trim($value['price']);
                                                                        $item_weight                    = trim($value['weight']);
                                                                        $item_full_photo                = trim($value['full_photo']);
                                                                        $item_full_photo_class          = trim($value['full_photo_class']);
                                                                        $item_medium_large_photo        = trim($value['medium_large_photo']);
                                                                        $item_medium_large_photo_class  = trim($value['medium_large_photo_class']);
                                                                        $item_thumbnail                 = trim($value['thumbnail']);
                                                                        $item_thumbnail_class           = trim($value['thumbnail_class']);
                                                                        $item_class                     = (strtolower($value['status']) == strtolower('standard')) ? 'checked' : '';

                                                                        if ($img_count == 0) {
                                                                            ?>
                                                                            <div class="color-title-box">
                                                                                <h4 class="box-title"><?php _e('Standard Options', 'fw_campers'); ?></h4>
                                                                            </div>
                                                                            <ul class="color-list">
                                                                            <?php
                                                                        }
                                                                        if ($item_price != 0 && $item_prev_price == 0) {
                                                                            ?>
                                                                            </ul>
                                                                            <div class="color-title-box">
                                                                                <h4 class="box-title"><?php _e('Premium Options', 'fw_campers'); ?></h4>
                                                                            </div>
                                                                            <ul class="color-list">
                                                                            <?php
                                                                        }
                                                                        if ($img_count == $items_count) {
                                                                            ?>
                                                                            </ul>
                                                                            <?php
                                                                        }

                                                                        $img_count++;
                                                                        $item_prev_price = $item_price;

                                                                        ?>
                                                                        <li>
                                                                            <div class="color-box color-gainsboro">
                                                                                <input class="color-selector"
                                                                                       type="radio"
                                                                                       name="option_group[<?php echo $element_id; ?>]"
                                                                                       id="option_<?php echo $item_id; ?>"
                                                                                       value="<?php echo $item_name; ?>" <?php echo $item_class; ?>
                                                                                       data-color="truck_color_<?php echo $item_id; ?>"
                                                                                       data-price="<?php echo $item_price; ?>"
                                                                                       data-weight="<?php echo $item_weight; ?>"
                                                                                       data-img-full="<?php echo esc_url($item_full_photo); ?>"
                                                                                       data-img-medium-large="<?php echo esc_url($item_medium_large_photo); ?>"
                                                                                       data-img-medium-large-class="<?php echo esc_url($item_medium_large_photo_class); ?>"
                                                                                       data-group-name="<?php echo $group; ?>"
                                                                                       data-option-parent-group="<?php echo $parent_group; ?>"
                                                                                       data-option-group="<?php echo $element_id; ?>"
                                                                                       data-preview="<?php echo $data_attr; ?>"
                                                                                       data-option-name = "<?php echo trim($item_name); ?>"
                                                                                       data-option>
                                                                                <label for="option_<?php echo $item_id; ?>" data-tippy-content="<?php echo $item_name . '<br>$' . $item_price; ?>">
                                                                                    <span class="color centered-img <?php echo $item_thumbnail_class; ?>">
                                                                                        <img src="<?php echo esc_url( $item_thumbnail ); ?>" alt="<?php echo esc_attr( $item_name ); ?>">
                                                                                    </span>
                                                                                    <span class="color-name"><?php echo $item_name; ?></span>
                                                                                </label>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                            <?php else : ?>
                                                <div id="<?php echo $element_id; ?>" class="group-box">
                                                    <div class="group-header">
                                                        <h2 class="group-title"><?php echo ucwords($group); ?></h2>
                                                        <?php if ($group_desc) : ?>
                                                            <div class="section-desc content small"><?php echo $group_desc; ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if (is_array($items) && count($items) > 0) : ?>
                                                        <ul class="item-list">
                                                            <?php foreach ($items as $key => $value) : ?>
                                                                <li>
                                                                    <?php
                                                                        $item_id                = trim($value['option_id']);
                                                                        $item_name              = trim($value['name']);
                                                                        $item_price             = trim($value['price']);
                                                                        $item_weight            = trim($value['weight']);
                                                                        $item_full_photo        = trim($value['full_photo']);
                                                                        $item_full_photo_class  = trim($value['full_photo_class']);
                                                                        $item_thumbnail         = trim($value['thumbnail']);
                                                                        $item_thumbnail_class   = trim($value['thumbnail_class']);
                                                                        $item_desc              = $value['desc'];
                                                                        $item_status            = $value['status'];
                                                                        $item_standard          = ($item_status == 'standard') ? 'checked data-standard="standard"' : '';
                                                                    ?>
                                                                    <div class="item-box <?php if ( !$item_thumbnail ) { echo 'without-image'; } ?>">
                                                                        <?php if ( $item_thumbnail ) { ?>
                                                                            <a class="icon-zoom"
                                                                               href="<?php echo esc_url($item_full_photo); ?>"
                                                                               title="<?php esc_attr_e('Zoom', 'fw_campers'); ?>"></a>
                                                                        <?php } ?>
                                                                        <?php if ($group != 'other' && $group_check == 'single') { ?>
                                                                            <input id="option_<?php echo $item_id; ?>"
                                                                                   class="radio-item"
                                                                                   type="radio"
                                                                                   name="option_group[<?php echo $element_id; ?>]"
                                                                                   value="<?php echo $item_id; ?>" <?php echo $item_standard; ?>
                                                                                   data-price="<?php echo $item_price; ?>"
                                                                                   data-weight="<?php echo $item_weight; ?>"
                                                                                   data-group-name="<?php echo $group; ?>"
                                                                                   data-option-parent-group="<?php echo $parent_group; ?>"
                                                                                   data-option-group="<?php echo $element_id; ?>"
                                                                                   data-option-name = "<?php echo trim($item_name); ?>"
                                                                                   data-option>
                                                                        <?php } else { ?>
                                                                            <input id="option_<?php echo $item_id; ?>"
                                                                                   class="radio-item"
                                                                                   type="checkbox"
                                                                                   name="option_id[<?php echo $item_id; ?>]"
                                                                                   value="<?php echo $item_name; ?>" <?php echo $item_standard; ?>
                                                                                   data-price="<?php echo $item_price; ?>"
                                                                                   data-weight="<?php echo $item_weight; ?>"
                                                                                   data-group-name="<?php echo $group; ?>"
                                                                                   data-option-parent-group="<?php echo $parent_group; ?>"
                                                                                   data-option-group="<?php echo $element_id; ?>"
                                                                                   data-option-name = "<?php echo trim($item_name); ?>"
                                                                                   data-option>
                                                                        <?php } ?>
                                                                        <label for="option_<?php echo $item_id; ?>">

                                                                            <?php if ( $item_thumbnail ) { ?>
                                                                                <div class="item-img-wrap centered-img <?php echo $item_thumbnail_class; ?>">
                                                                                    <img src="<?php echo esc_url( $item_thumbnail ); ?>" alt="<?php echo esc_attr( $option_name ); ?>">
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ( $item_price || $item_weight || $item_name ) { ?>
                                                                                <div class="item-info-box">
                                                                                    <?php if ( $item_name ) { ?>
                                                                                        <div class="item-title-box">
                                                                                            <h3 class="item-title"><?php echo $item_name; ?></h3>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <?php if ( $item_price || $item_weight ) { ?>
                                                                                        <div class="item-price-weight-box">
                                                                                            <?php if ($item_price) { ?>
                                                                                                <span class="item-price"><?php echo __('Price - $', 'fw_campers') . number_format( $item_price, 2, '.', ',' ); ?></span>
                                                                                            <?php } ?>
                                                                                            <?php if ($item_weight) { ?>
                                                                                                <span class="item-weight"><?php echo __('Weight - ', 'fw_campers') . number_format( $item_weight, 0, '.', ',' ) . __('lbs', 'fw_campers'); ?></span>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    <?php } ?>

                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($item_desc) { ?>
                                                                                <a href="#" class="more-info-btn" title="<?php esc_attr_e('More Info','fw_campers'); ?>"><?php _e('More Info','fw_campers'); ?> <span class="arrow-down"></span></a>
                                                                                <div class="item-info-box content small more">
                                                                                    <?php echo $item_desc; ?>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>


                                <?php // endif; ?>
                        <?php endforeach; ?>
                        <div class="no-display">
                            <input type="submit" class="btn blue customizer-btn" value="<?php esc_attr_e('Submit', 'fw_campers'); ?>">
                        </div>
                    </form>
                </div>
            </div>

            <div id="summary" class="camper-summary-box">
                <div class="container">
                    <div class="group-header">
                        <h2 class="group-title"><?php _e('Summary','fw_campers') ?></h2>
                    </div>
                    <div class="camper-summary-top-box">
                        <div class="left-box">
                            <h3 class="box-title"><?php _e('My Customized Camper','fw_campers') ?></h3>
                            <ul class="my-customized-view-list">
                                <?php //if ( $options_arr['Exterior Options']['Exterior Siding'] ) : ?>
                                    <li>
                                        <a href="" title="" data-exterior-preview>
                                            <div class="my-customized-view-img-wrap centered-img wider">
                                                <img src="" alt="">
                                            </div>
                                        </a>
                                    </li>
                                <?php //endif; ?>
                                <?php //if ( $options_arr['Interior Options']['Cushion Fabric Colors'] ) : ?>
                                    <li>
                                        <a href="" title="" data-interior-preview>
                                            <div class="my-customized-view-img-wrap centered-img wider">
                                                <img  src="" alt="">
                                            </div>
                                        </a>
                                    </li>
                                <?php //endif; ?>
                            </ul>
                        </div>
                        <div class="right-box">
                            <div class="total-price-box">
                                <div class="total-price-row">
                                    <span class="box-title small"><?php _e('Total Camper Price','fw_campers') ?></span>
                                    <span class="price value"><?php echo $model_price_print; ?></span>

                                </div>
                                <div class="total-price-row">
                                    <span class="box-title small"><?php _e('Weight','fw_campers') ?></span>
                                    <span class="weight value"><?php echo $model_weight_print; ?></span>
                                </div>
                                <a href="#" onclick="window.print();return false;" class="btn blue inverse" title="<?php esc_attr_e('Print Summary','fw_campers') ?>"><?php _e('Print Summary','fw_campers') ?></a>
                                <a href="#" class="btn blue inverse save-pdf-btn" title="<?php esc_attr_e('Save as PDF','fw_campers') ?>"><?php _e('Save as PDF','fw_campers') ?></a>
                                <div id="ajax-pdf-content">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="camper-summary-bottom-box">
                        <div class="left-box">
                            <ul class="resume-list">
                            <?php
                                foreach ($options_arr as $parent_group => $groups) :
                                    $parent_id = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($parent_group))) );
                                    $parent_id = preg_replace('/(-)\1+/','-', $parent_id );
                                    ?>
                                    <li data-option-parent-resume-group="<?php echo $parent_group; ?>">
                                        <div class="resume-parent-group">
                                            <h3 class="group-title parent"><?php echo ucwords($parent_group); ?></h3>
                                            <ul class="resume-group-list">
                                            <?php
                                            foreach ($groups as $group => $items) :
                                                $element_id = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($group))) );
                                                $element_id = preg_replace('/(-)\1+/','-', $element_id );
                                                ?>
                                                    <li data-option-resume-group="<?php echo $element_id; ?>">
                                                        <div class="resume-group">
                                                            <h4 class="resume-title"><?php echo ucwords($group); ?><a href="#<?php echo $element_id; ?>" title="<?php esc_attr_e('Edit','fw_campers')?>"><?php _e('Edit','fw_campers')?> &raquo;</a></h4>
<!--                                                            <ul class="resume-group-list">-->
                                                            <table class="resume-table">
                                                                <tbody>
                                                                    <?php foreach ($items as $key => $value) :
                                                                        $item_id     = trim($value['option_id']);
                                                                        $item_name   = trim($value['name']);
                                                                        $item_price  = trim($value['price']);
                                                                        $item_status = $value['status'];
                                                                        $item_class  = ($item_status == 'standard') ? '' : 'style="display: none;"';
                                                                        ?>
                                                                        <tr <?php echo $item_class; ?> data-option-id="option_<?php echo $item_id; ?>" >
                                                                            <td><?php echo $item_name; ?></td>
                                                                            <td class="price"><?php echo __('$', 'fw_campers') . number_format( $item_price, 2, '.', ',' ); ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
<!--                                                            </ul>-->
                                                        </div>
                                                    </li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>

                                <li class="subtotal">
                                    <div class="resume-group">
                                        <ul class="resume-group-list">
                                            <li>
                                                <div class="resume-group-item">
                                                    <span class="name"><?php _e('Subtotal','fw_campers') ?></span>
                                                    <span class="price value"><?php echo $model_price_print; ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="resume-group-item">
                                                    <span class="name"><?php _e('Weight','fw_campers'); ?></span>
                                                    <span class="weight value"><?php echo $model_weight_print; ?></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="total">
                                    <div class="resume-group">
                                        <ul class="resume-group-list">
                                            <li>
                                                <div class="resume-group-item">
                                                    <span class="name"><?php _e('Total Price','fw_campers'); ?></span>
                                                    <span class="price value"><?php echo $model_price_print; ?></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="right-box">
                            <h4 class="group-title small">Request A Quote</h4>
                            <?php
                                if ( shortcode_exists( 'contact-form-7' ) ) {
                                    echo do_shortcode('[contact-form-7 id="1129" title="Camper Build Form"]');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            var ajaxurl = '<?php echo home_url(); ?>/wp-admin/admin-ajax.php';
        </script>
        <?php
    endif;
 endif;
