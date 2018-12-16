<?php
//for Product Option Page
global $wpdb, $fwc_products;

$fwc_products = [];
$args = array(
	'post_type'         => 'product',
	'post_status'       => 'publish',
	'posts_per_page'    => -1
);

$product_query = new WP_Query( $args );

if ( $product_query->have_posts() ) {
	while ( $product_query->have_posts() ) : $product_query->the_post();
		if (get_field('enable_customizer')) {
			$product_id = $product_query->post->ID;
			$product_name = get_the_title() ? get_the_title() : '';
			$product_customizer = get_field('product_customizer');

			if ($product_customizer && is_array($product_customizer) && count($product_customizer) > 0) {
				$product_price = get_field('product_price') ? get_field('product_price') : '';
				$product_customizer_price = $product_customizer['price'] ? '$'.number_format($product_customizer['price'], 2,'.', ',') : $product_price;

				$fwc_products[] = [
					'product_id'    => $product_id,
					'name'          => $product_name,
					'price'         => $product_customizer_price,
                    'status'        => ''
				];
			}
		}
	endwhile;
} else {
	$fwc_products = [];
}



if ($fwc_products && is_array($fwc_products) && count($fwc_products) > 0) {

	$names = array_column( $fwc_products, 'name' );
	array_multisort( $names, SORT_NATURAL | SORT_FLAG_CASE, $fwc_products );

	add_action( 'add_meta_boxes_product_option', 'adding_products_relationship_meta_boxes' );
	function adding_products_relationship_meta_boxes( $post ) {
		add_meta_box( 'fourwh-model-relationships', 'Model Relationships', 'render_products_relationship_box', 'product_option', 'normal', 'default' );
	}

	function render_products_relationship_box(){
	    global $wpdb, $fwc_products;

	    $option_id = get_the_ID();
		$table_name = 'fourwh_model_relationship';
		$fwc_db_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE option_id = %d',$option_id),OBJECT);

		if ($fwc_db_relationship && is_array($fwc_db_relationship) && count($fwc_db_relationship) > 0) {
			foreach ($fwc_db_relationship as $relationship_obj) {
				foreach ($fwc_products as $key => $value) {
					if ($relationship_obj->product_id == $value['product_id'] && $relationship_obj->trash != 1) {
						$fwc_products[$key]['status'] = $relationship_obj->status;
					}
				}
			}
		}

		foreach ( $fwc_products as $value ) {
			?>
            <div class="inside relationship-box">
                <div class="relationship-inner">
                    <div class="relationship-label-box">
                        <label for="relationship_product_<?php echo $value['product_id'].'_'.$option_id; ?>"><?= $value['name']; ?></label>
                        <p class="description"><?= $value['price'] ? "({$value['price']})" : "–"; ?></p>
                    </div>
                    <div class="relationship-input-box">
                        <ul class="relationship-radio-list">
                            <li><label><input type="radio" name="relationship_product[<?= $value['product_id']; ?>][<?= $option_id; ?>]" <?= ($value['status'] == 'standard' ) ? 'checked' : ''; ?> value="standard">Standard</label></li>
                            <li><label><input type="radio" id="relationship_product_<?php echo $value['product_id'].'_'.$option_id; ?>" name="relationship_product[<?= $value['product_id']; ?>][<?= $option_id; ?>]" <?= ($value['status'] == 'optional' ) ? 'checked' : ''; ?> value="optional">Optional</label></li>
                            <li><label><input type="radio" name="relationship_product[<?= $value['product_id']; ?>][<?= $option_id; ?>]" <?= ($value['status'] == 'not_available' ) ? 'checked' : ''; ?> value="not_available">Not Available</label></li>
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
add_action( 'save_post_product_option', 'save_products_relationship_meta' );
function save_products_relationship_meta( $post_id ) {

    global $wpdb;

	$option_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	if (isset($_REQUEST['relationship_product'])) {
		foreach ( $_REQUEST['relationship_product'] as $key => $value ) {
			$status = $value[$option_id] ? strtolower(trim($value[$option_id ])) : '';

			$relationship_check = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . $table_name . ' WHERE product_id = %d AND option_id = %d', [ $key, $option_id ] ), OBJECT );

			if ( ! empty( $relationship_check ) ) {

				if ( $relationship_check->status != $status ) {
					$update_relationship = [
						'status' => $status
					];
					$wpdb->update( $wpdb->prefix . $table_name, $update_relationship, array( 'id' => $relationship_check->id ) );
				}

			} else {
				$new_relationship = [
					'product_id' => $key,
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

	if( ! $post || $post->post_type !== 'product_option' ) {
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

	if( ! $post || $post->post_type !== 'product_option' ) {
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
add_action( 'before_delete_post', 'delete_product_options' );
function delete_product_options( $post_id ){

  global $wpdb;

	$post = get_post( $post_id );

	if( ! $post || $post->post_type !== 'product_option' ) {
		return;
	}

	$option_id = $post_id;
	$table_name = 'fourwh_model_relationship';

	$wpdb->delete(  $wpdb->prefix.$table_name, array( 'option_id'=> $option_id ), array( '%d' ) );
}
