<?php
require_once(get_stylesheet_directory().'/lib/dompdf/lib/html5lib/Parser.php');
require_once(get_stylesheet_directory().'/lib/dompdf/src/Autoloader.php');

Dompdf\Autoloader::register();

use Dompdf\Dompdf;
use Dompdf\Options;


function generatePdf($build_data) {
    if (!empty($build_data)) {
        $model_name     = $build_data['model_name'];
        $total_price    = $build_data['total_price'];
        $total_weight   = $build_data['total_weight'];
        $summary        = $build_data['summary'];

        date_default_timezone_set(get_option('timezone_string'));
        $currentTime = date('mdy_His');
        $name = preg_replace('/[^\w]/','-', strtolower(strip_tags(trim($model_name))) );
        $name = preg_replace('/(-)\1+/','-', $name );
        $html = '';

        $style = '<style>
                    * {
                      -webkit-box-sizing: border-box;
                      -moz-box-sizing: border-box;
                      box-sizing: border-box; }
                    .resume-list {
                        margin-left: 0;
                        padding-left: 0;}
                      .resume-list > li {
                          margin-left: 0;
                          padding-left: 0;
                        list-style: none;
                        margin-bottom: 32px; }
                        .resume-list > li:not(.subtotal):not(.total) {
                          display: none; }
                        .resume-list > li:last-child {
                          margin-bottom: 0; }
                        .resume-list > li.subtotal {
                          margin-top: 0px;
                          margin-bottom: 30px;
                          padding: 30px 0 0;
                          border-top: 1px solid #62666a; }
                          .resume-group-list {
                            margin-left: 0;
                            padding-left: 0;
                          }
                          .resume-group-list > li {                         
                           list-style: none;}
                          .resume-list > li.subtotal .resume-group-list > li:not(:last-child) {
                            margin-bottom: 20px; }
                        .resume-list > li.total {
                          padding-top: 28px;
                          border-top: 1px solid #62666a; }
                          .resume-list > li.total .name,
                          .resume-list > li.total .value {
                            font-size: 24px;
                            color: #3a3a3a; }
                                                             
                    .resume-title {
                      margin-bottom: 12px;
                      font-size: 20px;
                      font-weight: 400;
                      line-height: 1.2;
                      letter-spacing: 0.02em;
                      word-spacing: .04em;
                      color: #3a3a3a; }
                      .resume-title a {
                        margin-left: 13px;
                        font-size: 16px;
                        font-weight: 400;
                        line-height: 1;
                        color: #00a3e0;
                        text-decoration: none; }
                        
                    
                    .resume-group-list > li:not(:last-child) {
                      margin-bottom: 8px; }
                    
                    .resume-group-item {
                      display: table;
                      width: 100%; }
                      .resume-group-item > * {
                        display: table-cell;
                        vertical-align: bottom; }
                      .resume-group-item .name {
                        width: 70%;
                        font-weight: 400;
                        color: #62666a;
                        letter-spacing: 0.02em;
                        word-spacing: .05em;
                        line-height: 1.2;
                        opacity: .8; }
                      .resume-group-item .value {
                        color: #3a3a3a;
                        letter-spacing: 0.02em;
                        line-height: 1.2;
                        text-align: right; }
                      .resume-table {
                          width: 100%; }
                          .resume-table tbody tr td {
                            padding: 5px;
                            font-weight: 400;
                            color: #62666a;
                            letter-spacing: 0.02em;
                            word-spacing: .05em;
                            line-height: 1.2;
                            opacity: .8; }
                            @media all and (max-width: 767px) {
                              .resume-table tbody tr td {
                                font-size: 16px; } }
                          .resume-table tbody tr > :first-child {
                            padding-left: 0;
                            width: 70%; }
                          .resume-table tbody tr > :last-child {
                            text-align: right;
                            color: #3a3a3a;
                            letter-spacing: 0.02em;
                            line-height: 1.2;
                            text-align: right; }
                    </style>';

        if ($model_name) {
            $html .= '<h1 class="section-title">' . $model_name . '</h1>';
        }

        $html .= '<h2 class="group-title">' . __('Summary', 'fw_campers') . '</h2>';

        if ( $summary && is_array( $summary ) && count( $summary ) > 0 ) {
            $html .= '<ul class="resume-list">';

                foreach ( $summary as $parent_group => $groups) {
                    $html .= '<li>';
                        $html .= '<div class="resume-parent-group">';
                        $html .= '<h3 class="group-title parent">' . $parent_group . '</h3>
                                  <ul class="resume-group-list">';
                                    foreach ($groups as $group => $items) {
                                        $html .= '<li>
                                                    <div class="resume-group">
                                                        <h4 class="resume-title">'.$group.'</h4>';
                                                $html .='<table class="resume-table">
                                                            <tbody>';
                                                            foreach ($items as $key => $value) {
                                                                $html .= '<tr>
                                                                            <td>' . $value['name'] . '</td>
                                                                            <td class="price">$' . number_format($value['price'], 2, '.', ',') . '</td>
                                                                        </tr>';
                                                            }
                                                $html .= ' </tbody>
                                                        </table>
                                                    </div>
                                                </li>';
                                    }
                            $html .= '</ul>';
                        $html .= '</div>';
                    $html .= '</li>';
                }

                if ($total_price || $total_weight) {
                    $html .= '    <li class="subtotal">
                                    <div class="resume-group">
                                        <ul class="resume-group-list">';
                                        if ($total_price){
                                            $html .= '<li>
                                                        <div class="resume-group-item">
                                                            <span class="name">' . __('Subtotal', 'fw_campers') . '</span>
                                                            <span class="price value">$' . number_format($total_price, 2, '.', ',') . '</span>
                                                        </div>
                                                    </li>';
                                        }
                                        if ($total_weight) {
                                            $html .= '<li>
                                                        <div class="resume-group-item">
                                                            <span class="name">' . __('Weight', 'fw_campers') . '</span>
                                                            <span class="weight value">' . number_format($total_weight, 0, '.', ',') . 'lbs</span>
                                                        </div>
                                                    </li>';
                                        }
                                $html .= '</ul>
                                    </div>
                                </li>';
                    if ($total_price) {
                        $html .= '<li class="total">
                                    <div class="resume-group">
                                        <ul class="resume-group-list">
                                            <li>
                                                <div class="resume-group-item">
                                                    <span class="name">' . __('Total Price', 'fw_campers') . '</span>
                                                    <span class="price value">$' . number_format($total_price, 2, '.', ',') . '</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>';
                    }
                }
            $html .= '</ul>';
        }

        $html_base = '<!DOCTYPE html>
					  <html>
						<head>
							<meta charset="utf-8">
							'. $style .'
							<title></title>
						</head>
						<body>'. $html.'</body>
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

            return get_template_directory_uri().$file_path;
        }
    }
}