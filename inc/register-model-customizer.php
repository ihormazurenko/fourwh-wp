<?php
// Adding fake page and rewrite rules
add_filter('rewrite_rules_array', 'fp_camper_customizer_rule');
function fp_camper_customizer_rule($rules) {
	$newrules = [];
	$newrules[ 'model/([^/]*)/(customizer)' ] = 'index.php?model=$matches[1]&fpage=$matches[2]';
	$rules = $newrules + $rules;

	return $rules;
}


// Tell WordPress to accept our custom query variable
add_filter('query_vars', 'fp_camper_customizer_qv');
function fp_camper_customizer_qv($vars) {
	array_push($vars, 'fpage');

	return $vars;
}


// Remove WordPress's default canonical handling function
remove_filter('wp_head', 'rel_canonical');
add_filter('wp_head', 'fsp_rel_canonical');

function fsp_rel_canonical() {
	global $current_fp, $wp_the_query;

	if (!is_singular())
		return;

	if (!$id = $wp_the_query->get_queried_object_id())
		return;

	$link = trailingslashit(get_permalink($id));

	// Make sure fake pages' permalinks are canonical
	if (!empty($current_fp))
		$link .= user_trailingslashit($current_fp);

	echo '<link rel="canonical" href="'.$link.'" />';
}


//Yoast Canonical Removal from model pages
add_filter( 'wpseo_canonical', 'wpseo_canonical_exclude' );
function wpseo_canonical_exclude( $canonical ) {
	global $post;

	if (is_singular('model')) {
		$canonical = false;
	}

	return $canonical;
}

