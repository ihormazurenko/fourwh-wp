<?php
//for Product Page
global $wpdb, $fwc_options;

$fwc_options = [];
$args = array(
	'post_type'         => 'product_option',
	'post_status'       => 'publish',
	'posts_per_page'    => -1
);

$option_query = new WP_Query( $args );

if ( $option_query->have_posts() ) {
	while ( $option_query->have_posts() ) : $option_query->the_post();
        $option_id = $option_query->post->ID;
        $option_name = get_the_title() ? get_the_title() : '';
        $option_info = get_field('option_info');

        if ($option_info && is_array($option_info) && count($option_info) > 0) {
            $option_price = $option_info['price'] ? '$' . number_format( $option_info['price'], 2, '.', ',' ) : '';

            $fwc_options[] = [
                'option_id' => $option_id,
                'name'      => $option_name,
                'price'     => $option_price,
                'status'    => ''
            ];
        }
	endwhile;
} else {
	$fwc_options = [];
}



if ($fwc_options && is_array($fwc_options) && count($fwc_options) > 0) {

	$names = array_column( $fwc_options, 'name' );
	array_multisort( $names, SORT_NATURAL | SORT_FLAG_CASE, $fwc_options );

	add_action( 'add_meta_boxes_product', 'adding_options_relationship_meta_boxes' );
	function adding_options_relationship_meta_boxes( $post ) {
		add_meta_box( 'fourwh-model-relationships', 'Model Relationships', 'render_options_relationship_box', 'product', 'normal', 'default' );
	}

	function render_options_relationship_box(){
	    global $wpdb, $fwc_options;

	    $product_id = get_the_ID();
		$table_name = 'fourwh_model_relationship';
		$fwc_db_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE product_id = %d',$product_id),OBJECT);

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
                        <label for="relationship_product_<?php echo $value['option_id'].'_'.$product_id; ?>"><?= $value['name']; ?></label>
                        <p class="description"><?= $value['price'] ? "({$value['price']})" : "–"; ?></p>
                    </div>
                    <div class="relationship-input-box">
                        <ul class="relationship-radio-list">
                            <li><label><input type="radio" name="relationship_product[<?= $value['option_id']; ?>][<?= $product_id; ?>]" <?= ($value['status'] == 'standard' ) ? 'checked' : ''; ?> value="standard">Standard</label></li>
                            <li><label><input type="radio" id="relationship_product_<?php echo $value['option_id'].'_'.$product_id; ?>" name="relationship_product[<?= $value['option_id']; ?>][<?= $product_id; ?>]" <?= ($value['status'] == 'optional' ) ? 'checked' : ''; ?> value="optional">Optional</label></li>
                            <li><label><input type="radio" name="relationship_product[<?= $value['option_id']; ?>][<?= $product_id; ?>]" <?= ($value['status'] == 'not_available') ? 'checked' : ''; ?> value="not_available">Not Available</label></li>
                        </ul>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}


wp_reset_postdata();

//save Product Option meta box data
add_action( 'save_post_product', 'save_options_relationship_meta' );
function save_options_relationship_meta( $post_id ) {

	global $wpdb;

	$product_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	if (isset($_REQUEST['relationship_product'])) {
		foreach ( $_REQUEST['relationship_product'] as $key => $value ) {
			$status = $value[$product_id] ? strtolower(trim($value[$product_id ])) : '';

			$relationship_check = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . $table_name . ' WHERE product_id = %d AND option_id = %d', [ $product_id, $key ] ), OBJECT );

			if ( ! empty( $relationship_check ) ) {

				if ( $relationship_check->status != $status ) {
					$update_relationship = [
						'status' => $status
					];
					$wpdb->update( $wpdb->prefix . $table_name, $update_relationship, array( 'id' => $relationship_check->id ) );
				}

			} else {
				$new_relationship = [
					'product_id' => $product_id,
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


//change relationship status when Product move to trash
add_action( 'trashed_post', 'change_relationship_status_product' );
function change_relationship_status_product( $post_id ){

	global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'product' ) {
		return;
	}

	$product_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$trashed_relationship = [
		'trash' => 1
	];
	$wpdb->update( $wpdb->prefix.$table_name, $trashed_relationship, array( 'product_id' => $product_id ), '%d' );
}

//change relationship status when Product untrashed
add_action( 'untrashed_post', 'untrashed_relationship_status_product' );
function untrashed_relationship_status_product( $post_id ){

	global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'product' ) {
		return;
	}

	$product_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$trashed_relationship = [
		'trash' => 0
	];
	$wpdb->update( $wpdb->prefix.$table_name, $trashed_relationship, array( 'product_id' => $product_id ), '%d' );
}

//delete relationship from DB when Product delete
add_action( 'before_delete_post', 'delete_product' );
function delete_product( $post_id ){

	global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'product' ) {
		return;
	}

	$product_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$wpdb->delete(  $wpdb->prefix.$table_name, array( 'product_id'=> $product_id ), array( '%d' ) );
}
