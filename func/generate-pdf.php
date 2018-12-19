<?php
require_once(get_stylesheet_directory().'/lib/dompdf/lib/html5lib/Parser.php');
require_once(get_stylesheet_directory().'/lib/dompdf/src/Autoloader.php');

Dompdf\Autoloader::register();

use Dompdf\Dompdf;
use Dompdf\Options;


function generatePdf($customer_info) {
    if ($customer_info && is_array($customer_info) && count($customer_info) > 0) {
        date_default_timezone_set('UTC');
        $currentTime = date('mdy_His');

        $html = '';
        $product_id    = $customer_info['product_id'] ? $customer_info['product_id'] : '';
        $product_name  = $product_id ? get_the_title( $product_id ) : '';
        $total_price   = $customer_info['total-price'] ? $customer_info['total-price'] : 0;
        $total_weight  = $customer_info['total-weight'] ? $customer_info['total-weight'] : 0;
        $name          = $customer_info['your-name'] ? $customer_info['your-name'] : '';
        $email         = $customer_info['your-email'] ? $customer_info['your-email'] : '';
        $truck_info    = $customer_info['truck-info'] ? $customer_info['truck-info'] : '';
        $option_groups = $customer_info['option_group'] ? $customer_info['option_group'] : [];
        $option_ids    = $customer_info['option_id'] ? $customer_info['option_id'] : [];

        if (!empty($product_name)) {
            $html .= '<h1>'.$product_name.'</h1>';
        }

        if (($option_groups && is_array($option_groups) && count($option_groups) > 0) || ($option_ids && is_array($option_ids) && count($option_ids) > 0)) {
            $html .= '<p><strong>Option List:</strong></p>';
            $html .= '<ul>';

            if ( $option_groups && is_array( $option_groups ) && count( $option_groups ) > 0 ) {
                foreach ( $option_groups as $group => $option_id ) {
                    $option_name = get_the_title( $option_id );
                    if ( ! empty( $option_name ) ) {
                        $html .= '<li>' . $option_name . '</li>';
                    }
                }
            }

            if ( $option_ids && is_array( $option_ids ) && count( $option_ids ) > 0 ) {
                foreach ( $option_ids as $option_id => $value ) {
                    $option_name = get_the_title( $option_id );
                    if ( ! empty( $option_name ) ) {
                        $html .= '<li>' . $option_name . '</li>';
                    }
                }
            }

            $html .= '</ul>';
        }

        if (!empty($total_price)) {
            $html .= '<p><strong>Total Price:</strong> $' . number_format( $total_price, 2, '.', ',' ) . '</p>';
        }
        if (!empty($total_weight)) {
            $html .= '<p><strong>Total Weight:</strong> ' . number_format( $total_weight, 0, '.', ',' ) . 'lbs</p>';
        }

        if (!empty($html)) {
            $html_base = '<!DOCTYPE html>
					  <html>
						<head>
							<meta charset="utf-8">
							<style>							
							</style>
							<title></title>
						</head>
						<body>'.$html.'</body>
					   </html>';

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);

            // instantiate and use the dompdf class
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html_base);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            $output = $dompdf->output();

            $file_path = '/pdf/'.str_replace(' ', '_', $name).'_'.$currentTime.'.pdf';

            if(!file_put_contents(get_stylesheet_directory().$file_path, $output)){
//				echo 'Not OK!';
                return false;
            } else {
//				echo 'OK';

                return CHILD_DIR.$file_path;
            }
        }

    }
}