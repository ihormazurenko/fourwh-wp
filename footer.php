        </main>
<?php
    $columns_arr   = [];
    $column_1      = get_field('columns_1', 'option');
    $column_2      = get_field('columns_2', 'option');
    $column_3      = get_field('columns_3', 'option');
    $column_4      = get_field('columns_4', 'option');
    $columns_arr    = [$column_1, $column_2, $column_3, $column_4];

    $social_column = get_field('social_columns', 'option');
?>

        <footer id="footer">
            <div class="container">
                <?php
                    if (($columns_arr && is_array($columns_arr) && count($columns_arr) > 0) || ($social_column && is_array($social_column) && count($social_column) > 0)) {
                ?>
                    <ul class="footer-list">
                        <?php
                            if ($columns_arr) {
                                foreach ($columns_arr as $column) {
                                    if ($column && is_array($column) && count($column) > 0) {
                                        echo '<li>';
                                        foreach ($column as $group) {
                                            if ($group && is_array($group) && count($group) > 0) {
                                                foreach ($group as $group_value) {
                                                    $group_title = $group_value['group_title'];
                                                    $group_links = $group_value['links'];

                                                    if (($group_title && is_array($group_title) && count($group_title) > 0) || ($group_links && is_array($group_links) && count($group_links)) > 0) {
                                                        echo '<div class="footer-box">';
                                                            if ($group_title) {
                                                                $label = $group_title['label'];
                                                                $link_type = $group_title['link_type'];
                                                                $target = $group_title['target'] ? 'target="_blank"' : '';

                                                                if ($link_type == 'internal') {
                                                                    $link = $group_title['internal_link'] ? $group_title['internal_link'] : '';
                                                                } elseif ($link_type == 'external') {
                                                                    $link = $group_title['external_link'] ? $group_title['external_link'] : '';
                                                                } elseif ($link_type == 'not_link') {
                                                                    $link = '';
                                                                }

                                                                if (!empty($label)) {
                                                                    if (!empty($link)) {
                                                                        echo '<a href="' . $link . '" class="footer-title" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>';
                                                                    } else {
                                                                        echo '<span class="footer-title">' . $label . '</span>';
                                                                    }
                                                                }
                                                            }

                                                            if ($group_links) {
                                                                foreach ($group_links as $value) {
                                                                    $link_data = $value['link'];

                                                                    if ($link_data && is_array($link_data) && count($link_data) > 0) {
                                                                        $label = $link_data['label'];
                                                                        $link_type = $link_data['link_type'];
                                                                        $target = $link_data['target'];

                                                                        if ($link_type == 'internal') {
                                                                            $link = $link_data['internal_link'] ? $link_data['internal_link'] : '';
                                                                        } elseif ($link_type == 'external') {
                                                                            $link = $link_data['external_link'] ? $value['external_link'] : '';
                                                                        } else {
                                                                            $link = '';
                                                                        }

                                                                        if (!empty($label)) {
                                                                            if (!empty($link)) {
                                                                                echo '<a href="' . $link . '" class="footer-link" title="' . esc_attr($label) . '" ' . $target . '>' . $label . '</a>';
                                                                            } else {
                                                                                echo '<span class="footer-link">' . $label . '</span>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                        }
                                        echo '</li>';
                                    }
                                }
                            }

                            if ($social_column) {
                                $group_title = $social_column['group_title'];
                                $social_links =  $social_column['social_links'];

                                if (($social_links && is_array($social_links) && count($social_links) > 0) || $group_title) {

                                    echo '<li><div class="footer-box">';
                                        if ($group_title) {
                                            echo '<span class="footer-title">'.$group_title.'</span>';
                                        }
                                        if ($social_links) {
                                            echo '<ul class="social-list">';
                                                foreach ($social_links as $value) {
                                                    $social_icon = $value['icon'];
                                                    $social_link = $value['link'];

                                                    echo '<li>';
                                                        if (!empty($social_link)) {
                                                            if ($social_icon == 'facebook') {
                                                                $title = 'Facebook';
                                                                $icon = '<i class="fab fa-facebook-f"></i>';
                                                            } elseif ($social_icon == 'twitter') {
                                                                $title = 'Twitter';
                                                                $icon = '<i class="fab fa-twitter"></i>';
                                                            } elseif ($social_icon == 'google') {
                                                                $title = 'Google+';
                                                                $icon = '<i class="fab fa-google-plus-g"></i>';
                                                            } elseif ($social_icon == 'vimeo') {
                                                                $title = 'Vimeo';
                                                                $icon = '<i class="fab fa-vimeo-v"></i>';
                                                            }

                                                            echo ' <a href="'.$social_link.'" title="'.esc_attr($title).'" target="_blank">'.$icon.'</a>';
                                                        }
                                                    echo '</li>';
                                                }
                                            echo '</ul>';
                                        }
                                    echo '</div></li>';
                                }
                            }
                        ?>
                    </ul>
                <?php
                    }
                ?>
            </div>
            <div class="footer-bottom-box">
                <div class="container">
                    <?php
                        $current_year = date("Y");

                        if ($current_year == 2018) {
                            echo '<p class="copyright">© Copyright Four Wheel Campers 2018. All rights reserved</p>';
                        } elseif ($current_year > 2018) {
                            echo '<p class="copyright">© Copyright Four Wheel Campers 2018-'.$current_year.' All rights reserved</p>';
                        }
                    ?>
                </div>
            </div>
        </footer>
    </div><!--/wrap-->

    <?php wp_footer(); ?>
</body>
</html>