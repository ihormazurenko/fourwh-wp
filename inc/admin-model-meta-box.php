<?php
//for Model Page
global $wpdb, $fwc_options;

$fwc_options = [];
$args = array(
	'post_type'         => 'model_option',
	'post_status'       => 'publish',
	'posts_per_page'    => -1
);

$option_query = new WP_Query( $args );

if ( $option_query->have_posts() ) {
	while ( $option_query->have_posts() ) : $option_query->the_post();
        $option_id = $option_query->post->ID;
        $option_name = get_the_title() ? get_the_title() : '';
        $option_price = get_field('option_price') ? '$' . number_format( get_field('option_price'), 2, '.', ',' ) : '';

        $fwc_options[] = [
            'option_id' => $option_id,
            'name'      => $option_name,
            'price'     => $option_price,
            'status'    => ''
        ];

	endwhile;
} else {
	$fwc_options = [];
}



if ($fwc_options && is_array($fwc_options) && count($fwc_options) > 0) {

	$names = array_column( $fwc_options, 'name' );
	array_multisort( $names, SORT_NATURAL | SORT_FLAG_CASE, $fwc_options );

	add_action( 'add_meta_boxes_model', 'adding_options_relationship_meta_boxes' );
	function adding_options_relationship_meta_boxes( $post ) {
		add_meta_box( 'fourwh-model-relationships', 'Model Relationships', 'render_options_relationship_box', 'model', 'normal', 'default' );
	}

	function render_options_relationship_box(){
	    global $wpdb, $fwc_options;

	    $model_id = get_the_ID();
		$table_name = 'fourwh_model_relationship';
		$fwc_db_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE model_id = %d',$model_id),OBJECT);

		if ($fwc_db_relationship && is_array($fwc_db_relationship) && count($fwc_db_relationship) > 0) {
			foreach ($fwc_db_relationship as $relationship_obj) {
				foreach ($fwc_options as $key => $value) {
					if ($relationship_obj->option_id == $value['option_id'] && $relationship_obj->trash != 1) {
						$fwc_options[$key]['status'] = $relationship_obj->status;
					}
				}
			}
		}

		foreach ( $fwc_options as $value ) {
			?>
            <div class="inside relationship-box">
                <div class="relationship-inner">
                    <div class="relationship-label-box">
                        <label for="relationship_model_<?php echo $value['option_id'].'_'.$model_id; ?>"><?= $value['name']; ?></label>
                        <p class="description"><?= $value['price'] ? "({$value['price']})" : "–"; ?></p>
                    </div>
                    <div class="relationship-input-box">
                        <ul class="relationship-radio-list">
                            <li><label><input type="radio" name="relationship_model[<?= $value['option_id']; ?>][<?= $model_id; ?>]" <?= ($value['status'] == 'standard' ) ? 'checked' : ''; ?> value="standard">Standard</label></li>
                            <li><label><input type="radio" id="relationship_model_<?php echo $value['option_id'].'_'.$model_id; ?>" name="relationship_model[<?= $value['option_id']; ?>][<?= $model_id; ?>]" <?= ($value['status'] == 'optional' ) ? 'checked' : ''; ?> value="optional">Optional</label></li>
                            <li><label><input type="radio" name="relationship_model[<?= $value['option_id']; ?>][<?= $model_id; ?>]" <?= ($value['status'] == 'not_available') ? 'checked' : ''; ?> value="not_available">Not Available</label></li>
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
add_action( 'save_post_model', 'save_options_relationship_meta' );
function save_options_relationship_meta( $post_id ) {

	global $wpdb;

	$model_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	if (isset($_REQUEST['relationship_model'])) {
		foreach ( $_REQUEST['relationship_model'] as $key => $value ) {
			$status = $value[$model_id] ? strtolower(trim($value[$model_id ])) : '';

			$relationship_check = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . $table_name . ' WHERE model_id = %d AND option_id = %d', [ $model_id, $key ] ), OBJECT );

			if ( ! empty( $relationship_check ) ) {

				if ( $relationship_check->status != $status ) {
					$update_relationship = [
						'status' => $status
					];
					$wpdb->update( $wpdb->prefix . $table_name, $update_relationship, array( 'id' => $relationship_check->id ) );
				}

			} else {
				$new_relationship = [
					'model_id'   => $model_id,
					'option_id'  => $key,
					'status'     => $status,
					'trash'      => 0
				];
//				$wpdb->insert( $wpdb->prefix . $table_name, $new_relationship, [ '%d', '%d', '%s' ] );
				$wpdb->insert( $wpdb->prefix . $table_name, $new_relationship, [ '%d', '%d', '%s', '%d' ] );
			}
		};
	}
}


//change relationship status when model move to trash
add_action( 'trashed_post', 'change_relationship_status_model' );
function change_relationship_status_model( $post_id ){

	global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'model' ) {
		return;
	}

	$model_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$trashed_relationship = [
		'trash' => 1
	];
	$wpdb->update( $wpdb->prefix.$table_name, $trashed_relationship, array( 'model_id' => $model_id ), '%d' );
}

//change relationship status when Model untrashed
add_action( 'untrashed_post', 'untrashed_relationship_status_model' );
function untrashed_relationship_status_model( $post_id ){

	global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'model' ) {
		return;
	}

	$model_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$trashed_relationship = [
		'trash' => 0
	];
	$wpdb->update( $wpdb->prefix.$table_name, $trashed_relationship, array( 'model_id' => $model_id ), '%d' );
}

//delete relationship from DB when model delete
add_action( 'before_delete_post', 'delete_model' );
function delete_model( $post_id ){

	global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'model' ) {
		return;
	}

	$model_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$wpdb->delete(  $wpdb->prefix.$table_name, array( 'model_id'=> $model_id ), array( '%d' ) );
}
