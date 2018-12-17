<?php
global $wpdb;

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
    $model_customizer   = get_field('model_customizer');
    $model_price        = get_field('model_price') ? number_format( get_field('model_price'), 2, '.', ',' ) : 0;
    $model_weight       = get_field('model_weight') ? get_field('model_weight') : 0;

    $model_id = get_the_ID();
    $model_name = get_the_title();
    $table_name = 'fourwh_model_relationship';
    $model_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE model_id = %d',$model_id),OBJECT);

    $options_ids = [];
    $options_arr = [];
    $group_arr = [];
    $name_arr = [];
    foreach ($model_relationship as $key => $value) {
        if ($value->status != 'not_available' && $value->status != '' && $value->trash != 1) {

            $options_ids[] = $value->option_id;
            $option_groups = get_the_terms($value->option_id, 'groups');

            $options_arr[$value->option_id] = [
                'status' => $value->status,
                'group_name' => !is_null($option_groups[0]->name) ? $option_groups[0]->name : 'Other',
                'group_slug' => !is_null($option_groups[0]->slug) ? $option_groups[0]->slug : 'z'
            ];

            $group_arr[] = !is_null($option_groups[0]->slug) ? $option_groups[0]->slug : 'z';
            $name_arr[] = get_the_title() ? get_the_title() : '';
        }
    }

    array_multisort( $group_arr, SORT_NATURAL | SORT_FLAG_CASE, $name_arr,SORT_NATURAL | SORT_FLAG_CASE,  $options_ids );

    $option_args = array(
        'post_type'         => 'model_option',
        'post_status'       => 'publish',
        'post__in'          => $options_ids,
        'posts_per_page'    => -1,
        'orderby'           => 'post__in'
    );
    /*
    $option_query = new WP_Query( $option_args );
    if ( $option_query->have_posts() ) {
        $option_group_name_last = '';
        $count = count($options_ids);
        $i = 0;

        echo '<form id="customizer-form" class="option-form" action="" method="POST">
                                                        <ul class="option-list">
                                                            <li class="hidden">
                                                                <div class="option-box">
                                                                    <input type="hidden" name="model_id"  value="'.$model_id.'" data-model-price="'.$model_price.'" data-model-weight="'.$model_weight.'">
                                                                    <input type="hidden" name="total-price"  data-total-price value="'.$model_price.'">
                                                                    <input type="hidden" name="total-weight"  data-total-weight value="'.$model_weight.'">
                                                                </div>
                                                            </li>';
        while ( $option_query->have_posts()) : $option_query->the_post();
            $option_id = get_the_ID();
            $meta = new stdClass;
            $i++;

            foreach( (array) get_post_meta($id ) as $k => $v ) $meta->$k = $v[0];
            $option_name = get_the_title() ? get_the_title() : '';
            $option_price = $meta->option_info_price ? $meta->option_info_price : 0;
            $option_weight = $meta->option_info_weight ? $meta->option_info_weight : 0;
            $option_img_id = $meta->photo ? $meta->photo : '';
            $option_img_url = $option_img_id ? wp_get_attachment_url($option_img_id) : '';
            $option_description = $meta->description ? $meta->description : '';
            $option_status = $options_arr[$option_id]['status'];
            $option_standard = ($option_status == 'standard') ? 'checked data-standard="standard"' : '';
            $option_group_name = $options_arr[$option_id]['group_name'];
            $option_group_slug = $options_arr[$option_id]['group_slug'];

            if ($option_group_name_last != $option_group_slug && $option_group_name_last == '' && $option_group_slug != 'z') {
                $option_group_name_last = $option_group_slug;
                echo '<li><h3 class="option">'.$option_group_name.'</h3><ul>';
            } elseif ($option_group_name_last != $option_group_slug && $option_group_name_last == '' && $option_group_slug == 'z') {
                $option_group_name_last = $option_group_slug;
                echo '<li><h3 class="option">'.$option_group_name.'</h3><ul class="other">';
            } elseif ($option_group_name_last != $option_group_slug && $option_group_name_last != '' && $option_group_slug != 'z') {
                $option_group_name_last = $option_group_slug;
                echo '</ul></li>';
                echo '<li><h3 class="option">'.$option_group_name.'</h3><ul>';
            } elseif ($option_group_name_last != $option_group_slug && $option_group_name_last != '' && $option_group_slug == 'z') {
                $option_group_name_last = $option_group_slug;
                echo '</ul></li>';
                echo '<li><h3 class="option">'.$option_group_name.'</h3><ul class="other">';
            }

            echo '<li>                                                           
                                                                        <div class="option-box">';
            if ($option_group_slug != 'z') {
                echo '<input id="option_'.$option_id.'" type="radio" name="option_group['.$option_group_slug.']" value="'.$option_id.'" '.$option_standard.' data-price="'.$option_price.'" data-weight="'.$option_weight.'" data-option>';
            } else {
                echo '<input id="option_'.$option_id.'" type="checkbox" name="option_id['.$option_id.']" value="'.$option_name.'" '.$option_standard.' data-price="'.$option_price.'" data-weight="'.$option_weight.'" data-option>';
            }
            echo '<label for="option_'.$option_id.'">
                                                                                <div class="option-inner-box">
                                                                                    <div class="option-cell">
                                                                                        <h4>'.$option_name.'</h4>';
            //if ($option_description) { echo '<p>'.$option_description.'</p>'; }
            if ($option_price) { echo '<p class="price">Price - $'.number_format( $option_price, 2, '.', ',' ).'</p>'; }
            if ($option_weight) { echo '<p class="weight"> Weight - '.number_format( $option_weight, 0, '.', ',' ).'lbs</p>'; }
            echo '</div>
                                                                                    <div class="option-cell img-cell">';
            if ($option_img_url) { echo '<div class="option-img-wrap"><img src="'.wp_get_attachment_url($option_img_id).'" alt="'.esc_attr($option_name).'"></div>'; }
            echo '</div>                                                                                                                                                                                                                                                                                        
                                                                                </div> 
                                                                            </label>
                                                                        </div>                                                           
                                                                    </li>';

            if ($i == $count) {
                echo '</ul></li>';
            }

        endwhile;

        echo '<li>
                                                                <ul class="info">
                                                                    <li>
                                                                        <input id="your-name" class="input-style wpcf7-text" type="text" name="your-name" placeholder="Your Name*" required>
                                                                    </li>
                                                                    <li>                                                                   
                                                                        <input id="your-email" class="input-style wpcf7-text" type="email" name="your-email" placeholder="Your Email*" required>
                                                                    </li>
                                                                    <li>                                                                   
                                                                        <textarea id="truck-info" name="truck-info" class="input-style wpcf7-textarea" placeholder="Truck Information"></textarea>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                      <div class="option-form-btn-box">
                                                            <button class="wpcf7-submit" type="submit">Submit</button>
                                                            <span class="option-ajax-loader"></span>
                                                        </div>  
                                                    </form>
                                                    <div id="ajax-content"></div>';
    }


    wp_reset_postdata();
*/
    ?>
    <section class="section-build-my-camper">

        <div class="anchor-nav-box build">
            <div class="container">
                <div class="top-box">
                    <div class="left-box">
                        <a href="<?php echo get_permalink() ?>" class="back-link" title="<?php esc_attr_e('Back to Models', 'fw_campers'); ?>">&#171; Back to Models</a>
                        <h1 class="anchor-box-title">Build My Camper</h1>
                    </div>
                    <div class="right-box">
                        <div class="total-camper-box">
                            <span class="price">$<?php echo $model_price; ?></span>
                            <span class="weight"><?php echo __('Weight: ', 'fw_campers') . $model_weight . __('lbs', 'fw_campers'); ?></span>
                        </div>
                    </div>
                </div>
                <nav class="anchor-nav">
                    <ul>
                        <li>
                            <a href="#exterior" class="active" title="Exterior">Exterior</a>
                        </li>
                        <li>
                            <a href="#fabric" title="Fabric">Fabric</a>
                        </li>
                        <li>
                            <a href="#awning" title="Awning">Awning</a>
                        </li>
                        <li>
                            <a href="#batteries" title="Batteries">Batteries</a>
                        </li>
                        <li>
                            <a href="#dinettes" title="Dinettes">Dinettes</a>
                        </li>
                        <li>
                            <a href="#summary" title="Dinettes">Summary</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="camper-customizer-box">
            <div class="container">
                <form action="" class="customizer-form">
                    <div id="exterior" class="group-box color-selector-box">
                        <div class="group-header">
                            <h2 class="group-title">Exterior Color</h2>
                        </div>
                        <div class="left-box">
                            <div class="group-img-wrap centered-img wider">
                                <img src="img/exterior_color.jpg" class="active" alt="Exterior" data-truck-color="#dcdcdc">
                                <img src="img/interior_fabric.jpg" alt="Exterior" data-truck-color="#fad0d5">
                                <img src="img/exterior_color.jpg" alt="Exterior" data-truck-color="#fed9a1">
                                <img src="img/interior_fabric.jpg" alt="Exterior" data-truck-color="#5ce5aa">
                                <img src="img/exterior_color.jpg" alt="Exterior" data-truck-color="#f9e7c7">
                                <img src="img/interior_fabric.jpg" alt="Exterior" data-truck-color="#9f8e8e">
                            </div>
                        </div>
                        <div class="right-box">
                            <h3 class="box-title">Exterior Color</h3>
                            <ul class="color-list">
                                <li>
                                    <div class="color-box">
                                        <input type="radio" name="exterior_color" id="exterior_color_1" value="gainsboro" checked  data-color="#dcdcdc">
                                        <label for="exterior_color_1" data-tippy-content="Gainsboro"><span class="color gainsboro"></span><span class="color-name">Gainsboro</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box">
                                        <input type="radio" name="exterior_color" id="exterior_color_2" value="pink"  data-color="#fad0d5">
                                        <label for="exterior_color_2" data-tippy-content="Pink"><span class="color pink"></span><span class="color-name">Pink</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box">
                                        <input type="radio" name="exterior_color" id="exterior_color_3" value="creamy"  data-color="#fed9a1">
                                        <label for="exterior_color_3" data-tippy-content="Creamy"><span class="color creamy"></span><span class="color-name">Creamy</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box">
                                        <input type="radio" name="exterior_color" id="exterior_color_4" value="aquamarine"  data-color="#5ce5aa">
                                        <label for="exterior_color_4" data-tippy-content="Aquamarine"><span class="color aquamarine"></span><span class="color-name">Aquamarine</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box">
                                        <input type="radio" name="exterior_color" id="exterior_color_5" value="coral" data-color="#f9e7c7">
                                        <label for="exterior_color_5" data-tippy-content="Coral"><span class="color coral"></span><span class="color-name">Coral</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box">
                                        <input type="radio" name="exterior_color" id="exterior_color_6" value="dusty-grey"  data-color="#9f8e8e">
                                        <label for="exterior_color_6" data-tippy-content="Gusty Grey"><span class="color dusty-grey"></span><span class="color-name">Gusty Grey</span></label>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div id="fabric" class="group-box color-selector-box">
                        <div class="group-header">
                            <h2 class="group-title">Interior Fabric</h2>
                        </div>
                        <div class="left-box">
                            <div class="group-img-wrap centered-img wider">
                                <img src="img/exterior_color.jpg" class="active" alt="Exterior" data-truck-color="#dcdcdc">
                                <img src="img/interior_fabric.jpg" alt="Exterior" data-truck-color="#fad0d5">
                                <img src="img/exterior_color.jpg" alt="Exterior" data-truck-color="#fed9a1">
                                <img src="img/interior_fabric.jpg" alt="Exterior" data-truck-color="#5ce5aa">
                            </div>
                        </div>
                        <div class="right-box">
                            <h3 class="box-title">Interior Fabric</h3>
                            <ul class="color-list">
                                <li>
                                    <div class="color-box color-gainsboro">
                                        <input class="color-selector" type="radio" name="fabric_color" id="fabric_color_1" value="gainsboro" checked data-color="#dcdcdc">
                                        <label for="fabric_color_1" data-tippy-content="Gainsboro"><span class="color gainsboro"></span><span class="color-name">Gainsboro</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box color-pink">
                                        <input class="color-selector" type="radio" name="fabric_color" id="fabric_color_2" value="pink" data-color="#fad0d5">
                                        <label for="fabric_color_2" data-tippy-content="Pink"><span class="color pink"></span><span class="color-name">Pink</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box color-creamy">
                                        <input class="color-selector" type="radio" name="fabric_color" id="fabric_color_3" value="creamy" data-color="#fed9a1">
                                        <label for="fabric_color_3" data-tippy-content="Creamy"><span class="color creamy"></span><span class="color-name">Creamy</span></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="color-box color-aquamarine">
                                        <input class="color-selector" type="radio" name="fabric_color" id="fabric_color_4" value="aquamarine" data-color="#5ce5aa">
                                        <label for="fabric_color_4" data-tippy-content="Aquamarine"><span class="color aquamarine"></span><span class="color-name">Aquamarine</span></label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="awning" class="group-box">
                        <div class="group-header">
                            <h2 class="group-title">Awning</h2>
                        </div>
                        <ul class="item-list">
                            <li>
                                <div class="item-box">
                                    <input id="awning_1" type="radio" name="awning" class="radio-item" value="awning_1">
                                    <label for="awning_1">
                                        <div class="item-img-wrap centered-img wider">
                                            <img src="img/awning_1.jpg" alt="8' Side Awning w/ Light">
                                        </div>
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <!--<div class="item-icon-wrap">-->
                                                <!--<img src="img/icon_battery.png" alt="Battery">-->
                                                <!--</div>-->
                                                <h3 class="item-title">8' Side Awning w/ Light</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $1,195.00</span>
                                                <span class="item-weight"></span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="item-box">
                                    <input id="awning_2" type="radio" name="awning" class="radio-item" value="awning_1">
                                    <label for="awning_2">
                                        <div class="item-img-wrap centered-img wider">
                                            <img src="img/awning_2.jpg" alt="Bat 270 Degree Wraparound">
                                        </div>
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <!--<div class="item-icon-wrap">-->
                                                <!--<img src="img/icon_battery.png" alt="Battery">-->
                                                <!--</div>-->
                                                <h3 class="item-title">Bat 270 Degree Wraparound</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $1,750.00</span>
                                                <span class="item-weight"></span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div id="batteries" class="group-box">
                        <div class="group-header">
                            <h2 class="group-title">Batteries</h2>
                        </div>
                        <ul class="item-list">
                            <li>
                                <div class="item-box without-image">
                                    <input id="batteries_1" type="radio" name="batteries" class="radio-item" value="batteries_1">
                                    <label for="batteries_1">
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <div class="item-icon-wrap">
                                                    <img src="img/icon_battery.png" alt="Battery">
                                                </div>
                                                <h3 class="item-title">Dual 6 Volt Battery Upgrade</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $600.00</span>
                                                <span class="item-weight"></span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info  <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="item-box without-image">
                                    <input id="batteries_2" type="radio" name="batteries" class="radio-item" value="batteries_2">
                                    <label for="batteries_2">
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <div class="item-icon-wrap">
                                                    <img src="img/icon_battery.png" alt="Battery">
                                                </div>
                                                <h3 class="item-title">2nd deep cycle battery (dual battery setup)</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $395.00</span>
                                                <span class="item-weight"></span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info  <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div id="dinettes" class="group-box">
                        <div class="group-header">
                            <h2 class="group-title">Dinettes</h2>
                        </div>
                        <ul class="item-list">
                            <li>
                                <div class="item-box">
                                    <input id="dinettes_1" type="radio" name="dinettes" class="radio-item" value="dinettes_1">
                                    <label for="dinettes_1">
                                        <div class="item-img-wrap centered-img ">
                                            <img src="img/dinettes_1.jpg" alt="">
                                        </div>
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <!--<div class="item-icon-wrap">-->
                                                <!--<img src="img/icon_battery.png" alt="Battery">-->
                                                <!--</div>-->
                                                <h3 class="item-title">Side Dinette Seating w/ Swivel Table</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $550.00</span>
                                                <span class="item-weight">Weight - 25lbs</span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="item-box">
                                    <input id="dinettes_2" type="radio" name="dinettes" class="radio-item" value="dinettes_2">
                                    <label for="dinettes_2">
                                        <div class="item-img-wrap centered-img ">
                                            <img src="img/dinettes_2.jpg" alt="">
                                        </div>
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <!--<div class="item-icon-wrap">-->
                                                <!--<img src="img/icon_battery.png" alt="Battery">-->
                                                <!--</div>-->
                                                <h3 class="item-title">Front Dinette Seating w/ Swivel Table</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $1,500.00</span>
                                                <span class="item-weight">Weight - 25lbs</span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="item-box">
                                    <input id="dinettes_3" type="radio" name="dinettes" class="radio-item" value="dinettes_3">
                                    <label for="dinettes_3">
                                        <div class="item-img-wrap centered-img ">
                                            <img src="img/dinettes_3.jpg" alt="">
                                        </div>
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <!--<div class="item-icon-wrap">-->
                                                <!--<img src="img/icon_battery.png" alt="Battery">-->
                                                <!--</div>-->
                                                <h3 class="item-title">Front Dinette w/ Table & Cassette Toilet Only (No Shower)</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $2,800.00</span>
                                                <span class="item-weight">Weight - 65lbs</span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="item-box">
                                    <input id="dinettes_4" type="radio" name="dinettes" class="radio-item" value="dinettes_4">
                                    <label for="dinettes_4">
                                        <div class="item-img-wrap centered-img ">
                                            <img src="img/dinettes_4.jpg" alt="">
                                        </div>
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <!--<div class="item-icon-wrap">-->
                                                <!--<img src="img/icon_battery.png" alt="Battery">-->
                                                <!--</div>-->
                                                <h3 class="item-title">Front Dinette w/ Inside & Outside Shower Only (No Cassette)</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $3,000.00</span>
                                                <span class="item-weight">Weight - 30lbs</span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="item-box">
                                    <input id="dinettes_5" type="radio" name="dinettes" class="radio-item" value="dinettes_5">
                                    <label for="dinettes_5">
                                        <div class="item-img-wrap centered-img ">
                                            <img src="img/dinettes_5.jpg" alt="">
                                        </div>
                                        <div class="item-info-box">
                                            <div class="item-title-box">
                                                <!--<div class="item-icon-wrap">-->
                                                <!--<img src="img/icon_battery.png" alt="Battery">-->
                                                <!--</div>-->
                                                <h3 class="item-title">Front Dinette Self-Contained (inside cassette toilet & shower)</h3>
                                            </div>
                                            <div class="item-price-weight-box">
                                                <span class="item-price">Price - $4,800.00</span>
                                                <span class="item-weight">Weight - 45lbs</span>
                                            </div>
                                        </div>
                                        <a href="#" class="more-info-btn">More Info <span class="arrow-down"></span></a>
                                        <div class="item-info-box content small more">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                In a metus nibh. Cras gravida diam dui, sed finibus ipsum dignissim non.
                                                Sed sed feugiat eros.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <p>
                                            <ul>
                                                <li>In a metus nibh. Cras gravida diam dui.</li>
                                                <li>Sed finibus ipsum dignissim non.</li>
                                                <li>Sed sed feugiat eros.</li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <div id="summary" class="camper-summary-box">
            <div class="container">
                <div class="group-header">
                    <h2 class="group-title">Summary</h2>
                </div>
                <div class="camper-summary-top-box">
                    <div class="left-box">
                        <h3 class="box-title">My Customized Camper</h3>
                        <ul class="my-customized-view-list">
                            <li>
                                <a href="img/exterior_color.jpg" title="Exterior Color">
                                    <div class="my-customized-view-img-wrap centered-img wider">
                                        <img src="img/exterior_color.jpg" alt="Exterior Color">
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="img/interior_fabric.jpg" title="Interior Fabric">
                                    <div class="my-customized-view-img-wrap centered-img wider">
                                        <img src="img/interior_fabric.jpg" alt="Interior Fabric">
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="right-box">
                        <div class="total-price-box">
                            <div class="total-price-row">
                                <span class="box-title small">Total Camper Price</span>
                                <span class="value">$17,995.00</span>

                            </div>
                            <div class="total-price-row">

                                <span class="box-title small">Weight</span>
                                <span class="value">975lbs</span>
                            </div>
                            <a href="#" class="btn blue inverse" title="Print Summary">Print Summary</a>
                            <a href="#" class="btn blue inverse" title="Save as PDF">Save as PDF</a>
                        </div>
                    </div>
                </div>
                <div class="camper-summary-bottom-box">
                    <div class="left-box">
                        <ul class="resume-list">
                            <li>
                                <div class="resume-group">
                                    <h4 class="resume-title">Exterior Color<a href="#" title="">Edit &raquo;</a></h4>
                                    <ul class="resume-group-list">
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">White Diamond Exterior Super Color</span>
                                                <span class="value">$0</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">Ebony Interior Fabric</span>
                                                <span class="value">$0</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">Standard 18-in Pewter Gray Machine-Finished Wheels</span>
                                                <span class="value">$0</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="resume-group">
                                    <h4 class="resume-title">Exterior Color<a href="#" title="">Edit &raquo;</a></h4>
                                    <ul class="resume-group-list">
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">White Diamond Exterior Super Color</span>
                                                <span class="value">$0</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">Ebony Interior Fabric</span>
                                                <span class="value">$0</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="resume-group">
                                    <h4 class="resume-title">Exterior Color<a href="#" title="">Edit &raquo;</a></h4>
                                    <ul class="resume-group-list">
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">White Diamond Exterior Super Color</span>
                                                <span class="value">$0</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="resume-group">
                                    <h4 class="resume-title">Exterior Color<a href="#" title="">Edit &raquo;</a></h4>
                                    <ul class="resume-group-list">
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">White Diamond Exterior Super Color</span>
                                                <span class="value">$0</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="subtotal">
                                <div class="resume-group">
                                    <ul class="resume-group-list">
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">Subtotal</span>
                                                <span class="value">$17,995.00</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">Placement Charge</span>
                                                <span class="value">$995</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="resume-group-item">
                                                <span class="name">Weight</span>
                                                <span class="value">975lbs</span>
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
                                                <span class="name">Total Price</span>
                                                <span class="value">$17,000</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="right-box">
                        <h4 class="group-title small">Request A Quote</h4>
                        <form action="" class="form-quote">
                            <ul class="form-quote-list">
                                <li>
                                    <input name="your-name" type="text" class="input-style" placeholder="Name">
                                </li>
                                <li>
                                    <input name="your-email" type="email" class="input-style" placeholder="Email">
                                </li>
                                <li>
                                    <input name="subject" type="text" class="input-style" placeholder="Subject">
                                </li>
                                <li>
                                    <textarea name="massege" class="input-style" placeholder="Massege"></textarea>
                                </li>
                            </ul>
                            <div class="form-quote-btn-box">
                                <input type="submit" value="Submit" class="btn blue">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>