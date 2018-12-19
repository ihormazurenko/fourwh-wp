<?php

global $wpdb, $fwc_options;

$fwc_options = [];
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
        $option_group       = get_the_terms($option_id, 'groups');

        echo '<pre>';
            var_dump($option_group);
        echo '</pre>';

        if ($option_info && is_array($option_info) && count($option_info) > 0) {
            $option_price = $option_info['price'] ? '$' . number_format($option_info['price'], 2, '.', ',') : '';

            if (is_array($option_group)) {
                $group_name = trim($option_group[0]->name);

                $fwc_options[$group_name][] = [
                    'option_id' => $option_id,
                    'name'      => $option_name,
                    'price'     => $option_price,
                    'thumbnail' => $option_photo_url,
                    'status'    => '',
                ];
            } else {
                $fwc_options['other'][] = [
                    'option_id' => $option_id,
                    'name'      => $option_name,
                    'price'     => $option_price,
                    'thumbnail' => $option_photo_url,
                    'status'    => '',
                ];
            }

        }
    endwhile;
} else {
    $fwc_options = [];
}
echo '<h1>Test</h1>';

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