<?php
//
//function ajax_option_customizer() {
//
//    function convert_number($num) {
//        return number_format( trim($num), 2, '.', ',' );
//    }
//
//    if (!empty($_POST) && !empty($_POST['formser'])) {
//        $formser = $_POST['formser'];
//
//        $formser = [];
//        parse_str($_POST['formser'], $formser);
//
//        $name               = $formser['your-name'] ? $formser['your-name'] : '';
//        $customizer_form    = get_field('customizer_form', 'option');
//
//        if ($customizer_form && is_array($customizer_form) && count($customizer_form) > 0) {
//            $sales_email = $customizer_form['email'] ? trim($customizer_form['email']) : '';
//            if (!empty($sales_email)) {
//                $sales_email = explode(",", str_replace(' ', '', $sales_email));
//
//                echo '<div class="customizer-order-box">';
//                sendMail($sales_email, $formser);
//
//                echo '<p>Your order is processing.</p>';
//
//                if (generatePdf($formser)) {
//                    echo '<a href="'.generatePdf($formser).'" class="customizer-order-link" title="Download Order" target="_blank" rel="nofollow noopener">Download Order for '.$name.'</a>';
//                }
//                echo '</div>';
//            }
//        }
//    }
//
//    die();
//}
//
//add_action('wp_ajax_option_customizer', 'ajax_option_customizer');
//add_action('wp_ajax_nopriv_option_customizer', 'ajax_option_customizer');