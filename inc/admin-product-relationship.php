<?php
/*
global $wpdb;

$url = __DIR__.'/test_170.txt';
$content = file_get_contents($url);
$data = json_decode($content, true);

echo '<pre>';
	var_dump( $data['relationship_product'] );
echo '</pre>';

$new_relationship = [];
$option_id = 4846;
$table_name = 'fourwh_model_relationship';

if (isset($data['relationship_product'])) {
	foreach ( $data['relationship_product'] as $key => $value ) {
		$status = strtolower(trim($value[$option_id]));

		$relationship_check = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE product_id = %d AND option_id = %d', [$key, $option_id]),OBJECT );

		if (!empty($relationship_check)) {
			if ($relationship_check->status != $status) {
				echo '<h2>Update</h2>';

				$update_relationship = [
					'status' => $status
				];

				$wpdb->update($wpdb->prefix.$table_name, $update_relationship ,array('id' => $relationship_check->id));
			} else {
				echo '<h2>Current data</h2>';
			}

		} else {
			//create new
			echo '<h2>Create</h2>';
			$new_relationship = [
				'product_id' => $key,
				'option_id'  => $option_id,
				'status'     => strtolower(trim($value[$option_id]))
			];
			$wpdb->insert($wpdb->prefix.$table_name, $new_relationship, ['%d', '%d', '%s']);

		}
	};

	$subscribers = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name));

	echo '<pre>';
	var_dump( $subscribers );
	echo '</pre>';
}

global $wpdb;
$table_name = 'fourwh_model_relationship';
$option_id = 4846;
$subscribers = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name), OBJECT);
$fwc_db_relationship = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.$table_name.' WHERE option_id = %d',$option_id),OBJECT);

//foreach ($fwc_db_relationship as $value) {
//	echo '<pre>';
//	var_dump( $value );
//	echo '</pre>';
//}
if ($fwc_db_relationship && is_array($fwc_db_relationship) && count($fwc_db_relationship) > 0) {
	foreach ($fwc_db_relationship as $relationship_obj) {
//		foreach ($fwc_products as $key => $value) {
//			$current_id = $value['id'];
//
//			if ($relationship_obj->product_id == $current_id) {
//				$fwc_products[$current_id]['status'] = $relationship_obj->status;
//			}
//		}
		echo '<pre>';
		var_dump( $relationship_obj->product_id );
		echo '</pre>';
	}

}
*/