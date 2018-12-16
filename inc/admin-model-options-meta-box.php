<?php
//for Model Option Page
global $wpdb, $fwc_models;

$fwc_models = [];
$args = array(
	'post_type'         => 'model',
	'post_status'       => 'publish',
	'posts_per_page'    => -1
);

$model_query = new WP_Query( $args );

if ( $model_query->have_posts() ) {
	while ( $model_query->have_posts() ) : $model_query->the_post();
		if (get_field('enable_customizer')) {
			$model_id           = $model_query->post->ID;
			$model_name         = get_the_title() ? get_the_title() : '';
			$model_customizer   = get_field('model_customizer');

			if ( $model_customizer && is_array($model_customizer) && count($model_customizer ) > 0) {
				$model_price            = get_field('model_price') ? '$'.number_format( get_field('model_price'), 2,'.', ',') : '';

				$fwc_models[] = [
					'model_id'    => $model_id,
					'name'          => $model_name,
					'price'         => $model_price,
                    'status'        => ''
				];
			}
		}
	endwhile;
} else {
	$fwc_models = [];
}



if ($fwc_models && is_array($fwc_models) && count($fwc_models) > 0) {

	$names = array_column( $fwc_models, 'name' );
	array_multisort( $names, SORT_NATURAL | SORT_FLAG_CASE, $fwc_models );

	add_action( 'add_meta_boxes_model_option', 'adding_models_relationship_meta_boxes' );
	function adding_models_relationship_meta_boxes( $post ) {
		add_meta_box( 'fourwh-model-relationships', 'Model Relationships', 'render_models_relationship_box', 'model_option', 'normal', 'default' );
	}

	function render_models_relationship_box(){
	    global $wpdb, $fwc_models;

	    $option_id = get_the_ID();
		$table_name = 'fourwh_model_relationship';
		$fwc_db_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE option_id = %d',$option_id),OBJECT);

		if ($fwc_db_relationship && is_array($fwc_db_relationship) && count($fwc_db_relationship) > 0) {
			foreach ($fwc_db_relationship as $relationship_obj) {
				foreach ($fwc_models as $key => $value) {
					if ($relationship_obj->model_id == $value['model_id'] && $relationship_obj->trash != 1) {
						$fwc_models[$key]['status'] = $relationship_obj->status;
					}
				}
			}
		}

		foreach ( $fwc_models as $value ) {
			?>
            <div class="inside relationship-box">
                <div class="relationship-inner">
                    <div class="relationship-label-box">
                        <label for="relationship_model_<?php echo $value['model_id'].'_'.$option_id; ?>"><?= $value['name']; ?></label>
                        <p class="description"><?= $value['price'] ? "({$value['price']})" : "–"; ?></p>
                    </div>
                    <div class="relationship-input-box">
                        <ul class="relationship-radio-list">
                            <li><label><input type="radio" name="relationship_model[<?= $value['model_id']; ?>][<?= $option_id; ?>]" <?= ($value['status'] == 'standard' ) ? 'checked' : ''; ?> value="standard">Standard</label></li>
                            <li><label><input type="radio" id="relationship_model_<?php echo $value['model_id'].'_'.$option_id; ?>" name="relationship_model[<?= $value['model_id']; ?>][<?= $option_id; ?>]" <?= ($value['status'] == 'optional' ) ? 'checked' : ''; ?> value="optional">Optional</label></li>
                            <li><label><input type="radio" name="relationship_model[<?= $value['model_id']; ?>][<?= $option_id; ?>]" <?= ($value['status'] == 'not_available' ) ? 'checked' : ''; ?> value="not_available">Not Available</label></li>
                        </ul>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}


wp_reset_postdata();

//save Model Option meta box data
add_action( 'save_post_model_option', 'save_models_relationship_meta' );
function save_models_relationship_meta( $post_id ) {

    global $wpdb;

	$option_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	if (isset($_REQUEST['relationship_model'])) {
		foreach ( $_REQUEST['relationship_model'] as $key => $value ) {
			$status = $value[$option_id] ? strtolower(trim($value[$option_id ])) : '';

			$relationship_check = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . $table_name . ' WHERE model_id = %d AND option_id = %d', [ $key, $option_id ] ), OBJECT );

			if ( ! empty( $relationship_check ) ) {

				if ( $relationship_check->status != $status ) {
					$update_relationship = [
						'status' => $status
					];
					$wpdb->update( $wpdb->prefix . $table_name, $update_relationship, array( 'id' => $relationship_check->id ) );
				}

			} else {
				$new_relationship = [
					'model_id' => $key,
					'option_id'  => $option_id,
					'status'     => $status,
					'trash'      => 0
				];
//				$wpdb->insert( $wpdb->prefix . $table_name, $new_relationship, [ '%d', '%d', '%s' ] );
				$wpdb->insert( $wpdb->prefix . $table_name, $new_relationship, [ '%d', '%d', '%s', '%d' ] );
			}
		};
	}
}


//change relationship status when Option move to trash
add_action( 'trashed_post', 'change_relationship_status_option' );
function change_relationship_status_option( $post_id ){

    global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'model_option' ) {
		return;
	}

    $option_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$trashed_relationship = [
		'trash' => 1
	];
	$wpdb->update( $wpdb->prefix.$table_name, $trashed_relationship, array( 'option_id' => $option_id ), '%d' );

}

//change relationship status when Option untrashed
add_action( 'untrashed_post', 'untrashed_relationship_status_option' );
function untrashed_relationship_status_option( $post_id ){

	global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'model_option' ) {
		return;
	}

	$option_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$trashed_relationship = [
		'trash' => 0
	];
	$wpdb->update( $wpdb->prefix.$table_name, $trashed_relationship, array( 'option_id' => $option_id ), '%d' );
}

//delete relationship from DB when Options delete
add_action( 'before_delete_post', 'delete_model_options' );
function delete_model_options( $post_id ){

  global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'model_option' ) {
		return;
	}

	$option_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$wpdb->delete(  $wpdb->prefix.$table_name, array( 'option_id'=> $option_id ), array( '%d' ) );
}
