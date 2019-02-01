<?php

function ajax_save_pdf() {

    if (!empty($_POST) && !empty($_POST['model_name']) && !empty($_POST['summary']) && !empty($_POST['total_price']) && !empty($_POST['total_weight'])) {
        $build_data = [
            'model_name'    => trim($_POST['model_name']),
            'total_price'   => trim($_POST['total_price']),
            'total_weight'  => trim($_POST['total_weight']),
            'summary'       => $_POST['summary'],
        ];

        if (generatePdf($build_data)) {
            echo '<a href="'.generatePdf($build_data).'" class="customizer-order-link" title="Download Order" target="_blank" rel="nofollow noopener">Download Order for - '.$_POST['model_name'].'</a>';
        }
    }

    die();
}

add_action('wp_ajax_save_pdf', 'ajax_save_pdf');
add_action('wp_ajax_nopriv_save_pdf', 'ajax_save_pdf');

function ajax_generate_img() {

    if (!empty($_POST) && !empty($_POST['floorplan_id'])) {
        echo wp_get_attachment_image( $_POST['floorplan_id'], 'max-width-2800', false, array('class' => 'fadein-style'));
    }

    die();
}

add_action('wp_ajax_generate_img', 'ajax_generate_img');
add_action('wp_ajax_nopriv_generate_img', 'ajax_generate_img');