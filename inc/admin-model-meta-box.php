<?php
//for Model Page
global $wpdb, $fwc_options;

add_action( 'current_screen', 'current_screen_hook' );
function current_screen_hook( $current_screen ) {
    if ('model' == $current_screen->post_type && 'post' == $current_screen->base) {
        global $wpdb, $fwc_options;

        $fwc_options = [];
        $option_args = array(
            'post_type' => 'model_option',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $option_query = new WP_Query($option_args);

        if ($option_query->have_posts()) {
            while ($option_query->have_posts()) : $option_query->the_post();
                $option_id = $option_query->post->ID;
                $option_name = get_the_title() ? get_the_title() : '';
                $option_info = get_field('option_info');
                $option_group = get_the_terms($option_id, 'groups');

                if ($option_info && is_array($option_info) && count($option_info) > 0) {
                    $option_price = $option_info['price'] ? '$' . number_format($option_info['price'], 2, '.', ',') : '';

                    if (is_array($option_group)) {
                        $group_name = trim($option_group[0]->name);

                        $fwc_options[$group_name][] = [
                            'option_id' => $option_id,
                            'name' => $option_name,
                            'price' => $option_price,
                            'status' => '',
                        ];
                    } else {
                        $fwc_options['other'][] = [
                            'option_id' => $option_id,
                            'name' => $option_name,
                            'price' => $option_price,
                            'status' => '',
                        ];
                    }

                }
            endwhile;
        } else {
            $fwc_options = [];
        }
    }

    wp_reset_postdata();


    if ($fwc_options && is_array($fwc_options) && count($fwc_options) > 0) {
        add_action('add_meta_boxes_model', 'adding_options_relationship_meta_boxes');

        //save Model Option meta box data
        add_action('save_post_model', 'save_options_relationship_meta');

        //change relationship status when model move to trash
        add_action('trashed_post', 'change_relationship_status_model');

        //change relationship status when Model untrashed
        add_action('untrashed_post', 'untrashed_relationship_status_model');

        //delete relationship from DB when model delete
        add_action('before_delete_post', 'delete_model');

        add_action('admin_enqueue_scripts', 'load_admin_accordion_script');
    }

}


function adding_options_relationship_meta_boxes($post) {
    add_meta_box('fourwh-model-relationships', 'Model Relationships', 'render_options_relationship_box', 'model', 'normal', 'default');
}


function render_options_relationship_box() {
    global $wpdb, $fwc_options;

    $model_id = get_the_ID();
    $table_name = 'fourwh_model_relationship';
    $fwc_db_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . $table_name . ' WHERE model_id = %d', $model_id), OBJECT);

    if ($fwc_db_relationship && is_array($fwc_db_relationship) && count($fwc_db_relationship) > 0) {
        foreach ($fwc_db_relationship as $relationship_obj) {
            foreach ($fwc_options as $group => $items) {
                foreach ($items as $key => $value) {
                    if ($relationship_obj->option_id == $value['option_id'] && $relationship_obj->trash != 1) {
                        $fwc_options[$group][$key]['status'] = $relationship_obj->status;
                    }
                }
            }
        }
    }

    ksort($fwc_options);

    if ($fwc_options['other']) {
        $temp = $fwc_options['other'];
        unset($fwc_options['other']);
        $fwc_options['other'] = $temp;
    }


    ?>
    <div class="fwc-accordion-wrap relationship-accordion">
        <?php
        $count = 0;
        foreach ($fwc_options as $group => $items) {
            if ($count != 0) {
                echo '<div class="accordion"><h3>' . ucwords($group ). '</h3></div>';
                echo '<div class="panel">';
            } else {
                echo '<div class="accordion active"><h3>' . ucwords($group ). '</h3></div>';
                echo '<div class="panel" style="display: block">';
            }
            $count++;
            foreach ($items as $key => $value) {
                ?>
                <div class="inside relationship-box">
                    <div class="relationship-inner">
                        <div class="relationship-label-box">
                            <label for="relationship_model_<?php echo $value['option_id'] . '_' . $model_id; ?>"><?= $value['name']; ?></label>
                            <p class="description"><?= $value['price'] ? "({$value['price']})" : "–"; ?></p>
                        </div>
                        <div class="relationship-input-box">
                            <ul class="relationship-radio-list">
                                <li><label><input type="radio"
                                                  name="relationship_model[<?= $value['option_id']; ?>][<?= $model_id; ?>]" <?= ($value['status'] == 'standard') ? 'checked' : ''; ?>
                                                  value="standard">Standard</label></li>
                                <li><label><input type="radio"
                                                  id="relationship_model_<?php echo $value['option_id'] . '_' . $model_id; ?>"
                                                  name="relationship_model[<?= $value['option_id']; ?>][<?= $model_id; ?>]" <?= ($value['status'] == 'optional') ? 'checked' : ''; ?>
                                                  value="optional">Optional</label></li>
                                <li><label><input type="radio"
                                                  name="relationship_model[<?= $value['option_id']; ?>][<?= $model_id; ?>]" <?= ($value['status'] == 'not_available') ? 'checked' : ''; ?>
                                                  value="not_available">Not Available</label></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        }
        ?>
    </div>
    <?php
}


function save_options_relationship_meta($post_id)
{

    global $wpdb;

    $model_id = $post_id;
    $table_name = 'fourwh_model_relationship';

    if (isset($_REQUEST['relationship_model'])) {
        foreach ($_REQUEST['relationship_model'] as $key => $value) {
            $status = $value[$model_id] ? strtolower(trim($value[$model_id])) : '';

            $relationship_check = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . $table_name . ' WHERE model_id = %d AND option_id = %d', [$model_id, $key]), OBJECT);

            if (!empty($relationship_check)) {

                if ($relationship_check->status != $status) {
                    $update_relationship = [
                        'status' => $status
                    ];
                    $wpdb->update($wpdb->prefix . $table_name, $update_relationship, array('id' => $relationship_check->id));
                }

            } else {
                $new_relationship = [
                    'model_id' => $model_id,
                    'option_id' => $key,
                    'status' => $status,
                    'trash' => 0
                ];
//				$wpdb->insert( $wpdb->prefix . $table_name, $new_relationship, [ '%d', '%d', '%s' ] );
                $wpdb->insert($wpdb->prefix . $table_name, $new_relationship, ['%d', '%d', '%s', '%d']);
            }
        };
    }
}


function change_relationship_status_model($post_id)
{

    global $wpdb;

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'model') {
        return;
    }

    $model_id = $post_id;
    $table_name = 'fourwh_model_relationship';

    $trashed_relationship = [
        'trash' => 1
    ];
    $wpdb->update($wpdb->prefix . $table_name, $trashed_relationship, array('model_id' => $model_id), '%d');
}


function untrashed_relationship_status_model($post_id)
{

    global $wpdb;

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'model') {
        return;
    }

    $model_id = $post_id;
    $table_name = 'fourwh_model_relationship';

    $trashed_relationship = [
        'trash' => 0
    ];
    $wpdb->update($wpdb->prefix . $table_name, $trashed_relationship, array('model_id' => $model_id), '%d');
}


function delete_model($post_id)
{

    global $wpdb;

    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'model') {
        return;
    }

    $model_id = $post_id;
    $table_name = 'fourwh_model_relationship';

    $wpdb->delete($wpdb->prefix . $table_name, array('model_id' => $model_id), array('%d'));
}


function load_admin_accordion_script() {
    wp_enqueue_script('custom-wp-admin-accordion-script', get_stylesheet_directory_uri() . '/assets/js/custom/custom-wp-admin-scripts.js', array('jquery'), null, true);
}