<?php

global $wpdb, $fwc_options;

$fwc_options = [];
$taxonomy = 'groups';
$no_image_available = get_bloginfo("template_url").'/img/no_image_available.jpg';
$option_args = array(
    'post_type' => 'model_option',
    'post_status' => 'publish',
    'posts_per_page' => -1
);

$option_query = new WP_Query($option_args);

if ($option_query->have_posts()) {
    while ($option_query->have_posts()) : $option_query->the_post();
        $option_id = $option_query->post->ID;
        $option_name        = get_the_title() ? get_the_title() : '';
        $option_info        = get_field('option_info');
        $option_photo       = get_field('photo');
        $option_photo_url   = $option_photo['sizes']['thumbnail'] ? $option_photo['sizes']['thumbnail'] : $no_image_available ;
        $option_group       = get_the_terms($option_id, $taxonomy);


        if ($option_info && is_array($option_info) && count($option_info) > 0) {
            $option_price = $option_info['price'] ? '$' . number_format($option_info['price'], 2, '.', ',') : '';

            if (is_array($option_group)) {
                $group_name = trim($option_group[0]->name);
                $parent_group_id    = $option_group[0]->parent != 0 ? $option_group[0]->parent : '';
                $parent_group_name = $parent_group_id ? get_term($parent_group_id) : 'other';

                if ( $parent_group_name->name ) {
                    $fwc_options[$parent_group_name->name][$group_name][] = [
                        'option_id' => $option_id,
                        'name' => $option_name,
                        'price' => $option_price,
                        'thumbnail' => $option_photo_url,
                        'status' => '',
                    ];
                } else {
                    $fwc_options['Other'][$group_name][] = [
                        'option_id' => $option_id,
                        'name'      => $option_name,
                        'price'     => $option_price,
                        'thumbnail' => $option_photo_url,
                        'status'    => '',
                    ];
                }
            } else {
                $fwc_options['Other']['Other'][] = [
                    'option_id' => $option_id,
                    'name'      => $option_name,
                    'price'     => $option_price,
                    'thumbnail' => $option_photo_url,
                    'status'    => '',
                ];
            }

        }
    endwhile;

    //sort groups
    $sort_options = [];
    ksort($fwc_options);
    foreach ($fwc_options as $parent => $groups) {
        ksort($groups);
        foreach ($groups as $group => $items) {
            ksort($items);
            foreach ($items as $key => $value) {
                $sort_options[$parent][$group][$key] = $value;
            }
        }
    }

    $fwc_options = $sort_options;

    //move "Cushion Fabric Colors" to the top of group
    if ($fwc_options['Interior Options']['Cushion Fabric Colors']) {
        $fwc_options['Interior Options'] = array('Cushion Fabric Colors' => $fwc_options['Interior Options']['Cushion Fabric Colors']) + $fwc_options['Interior Options'];
    }

    //move "Exterior Siding" to the top of group
    if ($fwc_options['Exterior Options']['Exterior Siding']) {
        $fwc_options['Exterior Options'] = array('Exterior Siding' => $fwc_options['Exterior Options']['Exterior Siding']) + $fwc_options['Exterior Options'];
    }

    //move parent Other to end
    if ($fwc_options['Other']) {
        $temp = $fwc_options['Other'];
        unset($fwc_options['Other']);
        $fwc_options['Other'] = $temp;
    }
    //move "Other" to the top of group
    if ($fwc_options['Other']['Other']) {
        $temp = $fwc_options['Other']['Other'];
        unset($fwc_options['Other']['Other']);
        $fwc_options['Other']['Other'] = $temp;
    }
} else {
    $fwc_options = [];
}

echo '<h1>Test</h1>';
//echo '<pre>';
//var_dump($fwc_options);
//$sort_options = [];
//ksort($fwc_options);
//foreach ($fwc_options as $parent => $groups) {
//    ksort($groups);
//    foreach ($groups as $group => $items) {
//        ksort($items);
//        foreach ($items as $key => $value) {
//            $sort_options[$parent][$group][$key] = $value;
//        }
//    }
//}

echo '<ul>';
foreach ($fwc_options as $parent => $groups) {
    echo '<li>'.$parent;
        echo '<ul style="padding-left: 20px;">';
        foreach ($groups as $group => $items) {
            echo '<li>'.$group.'</li>';
            echo '<ul style="padding-left: 20px;">';
            foreach ($items as $key => $value) {
                echo '<li>'.$value['name'].'---'.$value['price'].'</li>';
            }
            echo '</ul>';
        }
        echo '</ul>';
    echo '</li>';
}
echo '</ul>';
//echo '</pre>';
/*
echo '<h1>Test Page</h1>';

if (is_array($fwc_options) && count($fwc_options) > 0) {
    echo "<ul>";
    foreach ($fwc_options as $key => $items) {
        echo '<li style="display: inline-block; padding: 10px;">'.$key.'</li>';
    }
    echo '</ul>';


    echo "<div style='border: 2px solid red'>";
    foreach ($fwc_options as $key => $items) {
        echo '<div style="border: 3px dashed orange;">';
        foreach ($items as $value) {
            echo '<p>'.$value['name'].'</p>';
        }
        echo  '</div>';
    }
    echo '</ul>';
}



echo '<pre>';
var_dump($fwc_options);
echo '</pre>';
?>
<a href="" title=""></a>
*/