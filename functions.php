<?php
// loading styles and scripts
function load_style_script(){
    wp_enqueue_style('fonts', '//fonts.googleapis.com/css?family=Roboto:300,400,500', array(), null);
    wp_enqueue_style('font-awesome-5', '//use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '5.5.0');
    wp_enqueue_style('swiper', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/css/swiper.min.css', array(), '4.4.2');
    wp_enqueue_style('styles', get_template_directory_uri() . '/assets/css/screen.css', array(), null );
    wp_enqueue_style('style', get_stylesheet_uri(), array(), null );

    wp_enqueue_script('modernizr.min', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '2.8.3', false );
    wp_enqueue_script('swiper.min', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/js/swiper.min.js', array(), '442', true );
    wp_enqueue_script('smooth-scroll.polyfills.min', '//cdnjs.cloudflare.com/ajax/libs/smooth-scroll/15.1.0/smooth-scroll.polyfills.min.js', array(), '15.1.0', true );
    wp_enqueue_script('jquery.nicescroll.min', '//cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js', array(), '3.7.6', true );
    wp_enqueue_script('magnific', get_template_directory_uri() . '/assets/js/magnific.js', array(), '1.1.0', true );
    wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/custom/scripts.js', array('jquery'), null, true );
    wp_enqueue_script('map', get_template_directory_uri() . '/assets/js/custom/map.js', array('jquery'), null, true );
}
add_action('wp_enqueue_scripts', 'load_style_script');


// loading styles and scripts for admin panel
//function load_admin_style_script(){
//    wp_enqueue_style('custom-wp-admin-style', get_template_directory_uri() . '/css/custom-wp-admin-style.css', array('acf-input') );
//    wp_enqueue_script('custom-wp-admin-script', get_template_directory_uri() . '/js/custom-wp-admin-script.js', array('jquery'), null, true );
//}
//add_action('admin_enqueue_scripts', 'load_admin_style_script');


// add ie conditional html5 shiv to header
function add_ie_html5_shiv () {
    global $is_IE;
    if ($is_IE) {
        echo '<!--[if lt IE 9]>';
        echo '<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>';
        echo '<![endif]-->';
    }
}
add_action('wp_head', 'add_ie_html5_shiv');


// logo at the entrance to the admin panel
function my_custom_login_logo(){
    echo '<style type="text/css">
    h1 a {height:102px !important; width:316px !important; background-size:contain !important; background-image:url('.get_bloginfo("template_url").'/img/logo.png) !important;}
    </style>';
}
add_action('login_head', 'my_custom_login_logo');

add_filter( 'login_headerurl', create_function('', 'return get_home_url();') );
add_filter( 'login_headertitle', create_function('', 'return false;') );

add_filter('login_errors',create_function('$a', "return null;"));

// delete unnecessary items in wp_head
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );

function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');


// automatic generation of the tag <title>
add_theme_support( 'title-tag' );
// adding html5 markup
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

// support custom logo
add_theme_support( 'custom-logo', array(
    'flex-height' => true,
    'flex-width'  => true
) );
add_theme_support( 'custom-logo' );


// support thumbnails
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}

// support menus
if ( function_exists( 'register_nav_menus' ) ) {
    register_nav_menus(array(
        'main-menu'     => 'Main Menu',
        'footer-menu'   => 'Footer Menu'
    ));
}


// for excerpts
function new_excerpt_more( $more ) {
    return '&nbsp;&hellip;';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function new_excerpt_length($length) {
  return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');


// for Options Page
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Theme Options');
}

