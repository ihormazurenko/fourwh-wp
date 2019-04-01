<?php

//add woocommerce support
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

// disable WooCommerce’s default styling
//if (class_exists('Woocommerce')){
//    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
//}


//register sidebars
function register_shop_sidebar(){
    register_sidebar( array(
        'name' => "Shop Sidebar",
        'id' => 'shop-sidebar',
        'description' => 'Shows on Shop page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}
add_action( 'widgets_init', 'register_shop_sidebar' );

function register_product_sidebar(){
    register_sidebar( array(
        'name' => "Product Sidebar",
        'id' => 'product-sidebar',
        'description' => 'Shows on Single Product page',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ) );
}
add_action( 'widgets_init', 'register_product_sidebar' );


//custom tag before Woo content
add_action('woocommerce_before_main_content', 'fwc_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'fwc_wrapper_end', 10);

function fwc_wrapper_start() {
    $single_product_class = is_singular('product') ? 'single-product' : '';

    echo '<section class="section section-shop content-wrapper '.$single_product_class.'"><div class="container">';
}

function fwc_wrapper_end() {
    echo '</div></section>';
}

//add_action( 'woocommerce_sidebar', 'fwc_get_sidebar', 10 );
//
//function fwc_get_sidebar() {
//    if (is_singular('product')) {
//        get_sidebar( 'product' );
//    } else {
//        get_sidebar( 'shop' );
//    }
//}
