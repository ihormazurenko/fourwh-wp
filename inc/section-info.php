<?php
if (is_post_type_archive('event') || is_tax('event_category')) {
    $id = 339;
} elseif (is_post_type_archive('video') || is_tax('video_category')) {
    $id = 1020;
} elseif (is_post_type_archive('model') || is_tax('model_sizes') || is_tax('model_categories') || is_page(2554)) {
    $id = 1236;
} elseif (is_page()) {
    $id = get_the_ID();
} else {
    $id = '';
}


if (is_tax('model_categories') && !strpos(get_queried_object()->slug, 'flat-bed')) {
    $model_category_id   = get_queried_object()->term_id;
    $model_category_name = get_queried_object()->name;
    $model_category_desc = get_queried_object()->description;
    $model_category_info = get_field('model_category_info', 'model_categories_'.$model_category_id);
//    $term = get_term_by('id', )
//    if (get_current_user_id() == 1) {
//        var_dump(get_queried_object());
//    }

    if ($model_category_info && is_array($model_category_info) && count($model_category_info) > 0) {
        $section_title = $model_category_info['title'] ? $model_category_info['title'] : __('Select your ','fw_campers').$model_category_name.__(' to Build','fw_campers');
        $section_description = $model_category_info['description'] ? $model_category_info['description'] : $model_category_desc;

        if ($section_title)
            echo '<h1 class="section-title smaller line">' . $section_title . '</h1>';

        if ($section_description)
            echo '<div class="section-desc content">' . $section_description . '</div>';
    }

} else {
    $show_section_info = get_field('show_section_info', $id );
    $section_info = get_field('section_info', $id );

    if ($show_section_info) {
        if ($section_info && is_array($section_info) && count($section_info) > 0) {
            $section_description = $section_info['description'];
            if (is_post_type_archive('model') || is_tax('model_sizes') || is_tax('model_categories') && !strpos(get_queried_object()->slug, 'flat-bed')) {
                $section_title = get_the_archive_title();
            } else {
                $section_title = $section_info['title'];
            }

            if ($section_title)
                echo '<h1 class="section-title smaller line">' . $section_title . '</h1>';

            if ($section_description)
                echo '<div class="section-desc content">' . $section_description . '</div>';
        }
    }
}


