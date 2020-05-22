<?php
// Adding fake page and rewrite rules

add_action('init', 'do_rewrite_location_rule');
function do_rewrite_location_rule(){
//    add_rewrite_rule( '^(model)/([^/]*)/(build)/?$', 'index.php?model=$matches[2]&fpage=$matches[3]', 'top' );
//    add_rewrite_rule( '^(model)/([^/]*)/([^/]*)/(build)/?$', 'index.php?model=$matches[3]&fpage=$matches[4]', 'top' );

//    add_rewrite_rule( 'model/(([^/]*)/([^/]*))/(build)/?$', 'index.php?model=$matches[1]&fpage=$matches[4]', 'top' );

    add_rewrite_rule( 'location/([^/]*)/(campers-for-sale)/?$', 'index.php?location=$matches[1]&flocation=$matches[2]', 'top' );
    add_rewrite_rule( 'location/([^/]*)/(showroom)/?$', 'index.php?location=$matches[1]&flocation=$matches[2]', 'top' );

    add_filter( 'query_vars', function( $vars ){
        $vars[] = 'flocation';
        return $vars;
    } );
}


//// Remove WordPress's default canonical handling function
//remove_filter('wp_head', 'rel_canonical');
//add_filter('wp_head', 'fsp_rel_canonical');
//
//function fsp_rel_canonical() {
//	global $current_fp, $wp_the_query;
//
//	if (!is_singular())
//		return;
//
//	if (!$id = $wp_the_query->get_queried_object_id())
//		return;
//
//	$link = trailingslashit(get_permalink($id));
//
//	// Make sure fake pages' permalinks are canonical
//	if (!empty($current_fp))
//		$link .= user_trailingslashit($current_fp);
//
//	echo '<link rel="canonical" href="'.$link.'" />';
//}


////Yoast Canonical Removal from model pages
//add_filter( 'wpseo_canonical', 'wpseo_location_canonical_exclude' );
//function wpseo_location_canonical_exclude( $canonical ) {
//	global $post;
//
//	if (is_singular('location')) {
//		$canonical = false;
//	}
//
//	return $canonical;
//}
//
////ads class to body
//add_filter('body_class','location_class_names');
//function location_class_names( $classes ) {
//    // добавим класс 'class-name' в массив классов $classes
//    if( get_query_var('flocation') == 'showroom' || get_query_var('flocation') == 'camper-for-sale' )
//        $classes[] = 'white-header-bg';
//
//    return $classes;
//}


