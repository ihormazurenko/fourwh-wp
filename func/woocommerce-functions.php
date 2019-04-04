<?php

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

//change home URL to shop URL
add_filter( 'woocommerce_breadcrumb_home_url', 'woo_custom_breadrumb_home_url' );

function woo_custom_breadrumb_home_url() {
    return get_permalink(2850);
}


//remove tabs from the bottom of the page
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );        // Remove the description tab
    unset( $tabs['reviews'] );            // Remove the reviews tab
    unset( $tabs['additional_information'] );      // Remove the additional information tab

    return $tabs;

}

// move description to the right section
function woocommerce_template_product_description() {
    wc_get_template( 'single-product/tabs/description.php' );
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_product_description', 1000 );