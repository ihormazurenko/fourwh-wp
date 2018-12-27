<?php
// Adding fake page and rewrite rules
add_action('init', 'do_rewrite');
function do_rewrite(){
    add_rewrite_rule( '^(model)/([^/]*)/(build)/?$', 'index.php?model=$matches[2]&fpage=$matches[3]', 'top' );
//    add_rewrite_rule( '^(model)/([^/]*)/([^/]*)/(build)/?$', 'index.php?model=$matches[3]&fpage=$matches[4]', 'top' );

    add_rewrite_rule( 'model/(([^/]*)/([^/]*))/(build)/?$', 'index.php?model=$matches[1]&fpage=$matches[4]', 'top' );

    add_filter( 'query_vars', function( $vars ){
        $vars[] = 'fpage';
        return $vars;
    } );
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

	if (is_singular('model') || is_tax('model_sizes')) {
		$canonical = false;
	}

	return $canonical;
}

//ads class to body
add_filter('body_class','build_camper_class_names');
function build_camper_class_names( $classes ) {
    // добавим класс 'class-name' в массив классов $classes
    if( get_query_var('fpage') == 'build' )
        $classes[] = 'white-header-bg';

    return $classes;
}

