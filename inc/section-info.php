<?php
if (is_post_type_archive('event') || is_tax('event_category')) {
    $id = 339;
} elseif (is_post_type_archive('video') || is_tax('video_category')) {
    $id = 1020;
} elseif (is_page()) {
    $id = get_the_ID();
} else {
    $id = '';
}

$show_section_info = get_field('show_section_info', $id );
$section_info = get_field('section_info', $id );

if ($show_section_info) {
    if ($section_info && is_array($section_info) && count($section_info) > 0) {
        $section_title = $section_info['title'];
        $section_description = $section_info['description'];

        if ($section_title)
            echo '<h1 class="section-title smaller line">' . $section_title . '</h1>';

        if ($section_description)
            echo '<div class="section-desc content">' . $section_description . '</div>';
    }
}


