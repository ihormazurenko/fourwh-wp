<?php
// loading styles and scripts
function load_style_script(){
    wp_enqueue_style('fonts', '//fonts.googleapis.com/css?family=Roboto:300,400,500', array(), null);
    wp_enqueue_style('font-awesome-5', '//use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '5.5.0');
    wp_enqueue_style('swiper', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/css/swiper.min.css', array(), '4.4.2');
    wp_enqueue_style('styles', get_template_directory_uri() . '/assets/css/screen.css', array(), '1.4.2' );
    wp_enqueue_style('style', get_stylesheet_uri(), array(), null );

    wp_enqueue_script('modernizr.min', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '2.8.3', false );
    wp_enqueue_script('swiper.min', '//cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.2/js/swiper.min.js', array(), '442', true );
    wp_enqueue_script('smooth-scroll.polyfills.min', '//cdnjs.cloudflare.com/ajax/libs/smooth-scroll/15.1.0/smooth-scroll.polyfills.min.js', array(), '15.1.0', true );
    wp_enqueue_script('jquery.nicescroll.min', '//cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js', array(), '3.7.6', true );
    wp_enqueue_script('tippy.all.min', '//unpkg.com/tippy.js@3/dist/tippy.all.min.js', array(), '3.3.0', true );
    wp_enqueue_script('magnific', get_template_directory_uri() . '/assets/js/magnific.js', array(), '1.1.0', true );
    wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/custom/scripts.js', array('jquery'), null, true );
    wp_enqueue_script('map', get_template_directory_uri() . '/assets/js/custom/map.js', array('jquery'), null, true );

    if ( is_singular('model') && get_query_var('fpage') == 'build' ) {
        wp_enqueue_script('customizer', get_template_directory_uri() . '/assets/js/custom/build-script.js', array('jquery'), null, true );
        wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/assets/js/custom/ajax.js' );
    }
}
add_action('wp_enqueue_scripts', 'load_style_script');

// add custom styles and scripts for admin panel
function load_admin_style_script(){
    wp_enqueue_style('custom-wp-admin-style', get_stylesheet_directory_uri() . '/assets/css/custom-wp-admin-style.css', array() );
}
add_action('admin_enqueue_scripts', 'load_admin_style_script');


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
    ));
}


// for excerpts
function new_excerpt_more( $more ) {
    global $post;
    return '<a class="read-more" href="'. get_permalink($post) . '" title="'.esc_attr_x('Read More...', 'fw_campers').'"> '.__('Read More...', 'fw_campers').'</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function new_excerpt_length($length) {
  return 120;
}
add_filter('excerpt_length', 'new_excerpt_length');

//for custom excerpts
function the_excerpt_max_charlength( $charlength ){
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}


// for Options Page
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Theme Options');
}


//for test
function usage() {
    if (get_current_user_id() == 1) {
        echo '<div class="statistic-wp"><style> .statistic-wp { position: fixed; z-index: 99999; max-width: 200px; bottom: 20px; left: 20px; background-color: #fff; color: #000; padding: 5px 10px; border: 1px solid red; } </style>';
            printf( ( '%d / %s' ), get_num_queries(), timer_stop( 0, 3 ) );
            if ( function_exists( 'memory_get_usage' ) ) {
                echo ' / ' . round( memory_get_usage() / 1024 / 1024, 2 ) . 'mb ';
            }
        echo '</div>';
    }
}
add_action('admin_footer_text', 'usage');
add_action('wp_footer', 'usage');

//get video thumbnail url
function getVideoThumbnail($url) {
    if (strpos($url, 'youtube') > 0) {
        //for Youtube
        if (empty($url))
            return;

        $fetch              = explode("v=", $url);
        $youtube_video_id   = $fetch[1];
        $video_thumb_url    = 'https://img.youtube.com/vi/'.$youtube_video_id.'/maxresdefault.jpg';

        return $video_thumb_url;

    } elseif (strpos($url, 'vimeo') > 0) {
        //for Vimeo
        $regs = [];
        $id = '';

        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
            $id = trim($regs[3]);
        }

        if ( empty( $id ) )
            return;

        $apiToken = '3e43a280e4d9097fd4397610db102985';
        $httpHeadersArray = [];
        $httpHeadersArray[] = 'Authorization: bearer '.$apiToken;

        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://api.vimeo.com/videos/$id/pictures");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeadersArray);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        curl_close($ch);

        $output = json_decode($output);

        $sizes_arr = $output->data[0]->sizes;

        $thumb_url = $sizes_arr[5]->link ? $sizes_arr[5]->link : $sizes_arr[6]->link;

        if ( empty( $thumb_url ) )
            return;

        return $thumb_url;
    } else {
        //other

        return;
    }
}

//register sidebar
function register_my_widgets(){
    register_sidebar( array(
        'name' => "Right Sidebar",
        'id' => 'sidebar',
        'description' => 'Shows on Articles Page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}
add_action( 'widgets_init', 'register_my_widgets' );


// for dates
function funcDate($start, $end, $format = 'full') {

        if (!$start || !$end)
            return false;

        $dash = ' – ';

        date_default_timezone_set(get_option('timezone_string'));
        $start = strtotime($start);
        $end = strtotime($end);
        $currentTime = strtotime(date('Y-m-d H:i:s'));
        $timezone_str = ' ' . date('T');

        $wrong_text = is_user_logged_in() ? '<span class="warning">' . __('Something wrong, please check event dates "end date less than the start date of the event" !!!', 'fc_details') . '</span>' : '';
        $over_text = __('Event is over – ', 'fc_details');

    if ( $format == 'full') {
        $hours1 = date("g:i a", $start);
        $hours2 = date("g:i a", $end);

        $day1 = date("j", $start);
        $day2 = date("j", $end);

        $month1 = date("F", $start) . ' ';
        $month2 = date("F", $end) . ' ';

        $year1 = ', ' . date("Y", $start);
        $year2 = ', ' . date("Y", $end);

        $separator = __('to', 'fc_details') . ' ';

        if ( $day1 === $day2 ) {
            if ( $hours1 === $hours2 ) {
                $convertDate = '<li><span> <i class="far fa-calendar-alt"></i>' . $month1 . $day1 . $year1 . '</span></li>';
                $convertDate .= '<li><span> <i class="far fa-clock"></i>' . $hours1 . $timezone_str . '</span></li>';
            } else {
                $convertDate = '<li><span> <i class="far fa-calendar-alt"></i>' . $month1 . $day1 . $year1 . '</span></li>';
                $convertDate .= '<li><span> <i class="far fa-clock"></i>' .  $hours1 . $dash . $hours2 . $timezone_str . '</span></li>';
            }
        } else {
            $convertDate = '<li><span> <i class="far fa-calendar-alt"></i>' . $month1 . $day1 . $year1 . ' @ '.  $hours1 . $timezone_str . '</span></li>';
            $convertDate .= '<li><span> <i class="far fa-calendar-alt"></i>' . $separator . $month2 . $day2 . $year2 . ' @ '.  $hours2 . $timezone_str . '</span></li>';
        }

        
        if ($start !== $end && $start < $end) {
            if ($currentTime >= $end) {
                //finished event
                $convertDate = '<li><span> <i class="far fa-calendar-alt"></i>' . $over_text . date("F j, Y @ g:i a T", $end) . '</span></li>';
            }
        } elseif ($start !== $end && $start > $end) {
            //if start date > end date
            $convertDate = '<li>' . $wrong_text . '</li>' . $convertDate;

        } else {
            if ($currentTime >= $end) {
                //finished event
                $convertDate = '<li><span> <i class="far fa-calendar-alt"></i>' . $over_text . date("F j, Y @ g:i a T", $end) . '</span></li>';
            }
        }


    } elseif ( $format === 'short' ) {
        $day1 = date("d", $start);
        $day2 = date("d", $end);

        $month1 = '.' . date("m", $start);
        $month2 = '.' . date("m", $end);

        $dash = '–';

        if ($month1 === $month2) {
            $month1 = '';
            if ( $day1 === $day2 ) {
                $day1 = '';
                $dash = '';
            }
        }

        $convertDate = $day1 . $month1 . $dash . $day2 . $month2;
    } else {
        $convertDate = '';
    }

    return $convertDate;
}


//test admin page
//add_action('admin_menu', function(){
//	add_menu_page( 'All Test', 'All Test', 'manage_options', 'Test', function () {
//		require_once (get_stylesheet_directory() . '/func/admin-product-relationship.php');},
//		'dashicons-universal-access-alt', 10 );
//} );

get_template_part('func/admin', 'model-options-meta-box');
get_template_part('func/admin', 'model-meta-box');
get_template_part('func/admin', 'model-columns');
get_template_part('func/admin', 'options-columns');

get_template_part('func/register', 'model-build');

//add DomPdf
get_template_part('func/generate', 'pdf');

// add AJAX
get_template_part('func/ajax');