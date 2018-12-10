<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="wrapper">
    <a class="btn-jump-to-content smooth-scroll" href="#main-content"><?php _e('Skip Navigation', 'fw_campers'); ?></a>

    <?php /*
        <header class="header">
            <div class="navbar">
                <a href="<?php echo home_url(); ?>" class="logo">
                    <?php
                        if ( get_field('logo', 'option') ) {
                            $logo_url = get_field('logo', 'option');
                        } elseif ( has_custom_logo() ) {
                            $custom_logo = wp_get_attachment_image_src( get_theme_mod('custom_logo'), 'full' );
                            $logo_url = $custom_logo[0];
                        } else {
                            $logo_url = get_bloginfo('template_url') . '/img/logo.png';
                        }
                    ?>
                    <img src="<?php echo $logo_url; ?>" alt="<?php bloginfo('name'); ?>">
                </a>

                <div class="mobile-menu-toggle">
                    <span></span>
                </div>

                <?php wp_nav_menu(array(
                    'theme_location'  => 'main-nav',
                    'menu'            => 'Main Navigation',
                    'container'       => 'nav',
                    'container_class' => 'main-nav desktop',
                    'container_id'    => false,
                    'items_wrap'      => '<ul>%3$s</ul>',
                    'depth'           => 1
                )); ?>

                <div class="mobile-menu-wrap">
                    <div class="mobile-menu-box">
                        <?php wp_nav_menu(array(
                            'theme_location'  => 'main-nav',
                            'menu'            => 'Main Navigation',
                            'container'       => false,
                            'menu_class'      => 'mobile-menu',
                            'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                            'depth'           => 1
                        )); ?>
                    </div>
                    <div class="mobile-menu-overlay"></div>
                </div>
            </div>

            </section>
        </header>
 */ ?>

    <header id="header-main" class="header">
        <div class="container">
            <div class="logo">
                <a href="dev-sitemap.html">
                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/logo.png" alt=" Four Wheel Campers">
                </a>
            </div>
            <div class="mobile-menu-toggle">
                <span></span>
            </div>
            <nav class="main-nav desktop">
                <ul>
                    <li><a href="dev-sitemap.html"><span class="icon-skiing"></span> My Life</a></li>
                    <li><a href="campers.html">Campers</a></li>
                    <li><a href="#">Financing</a></li>
                    <li><a href="#">Events</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="tradeshows.html">Trade Show &amp; Event Calendar*</a></li>
                            <li class="menu-item"><a href="#">Contests</a></li>
                        </ul>
                    </li>
                    <li><a href="support.html">Support</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="#">Service</a></li>
                            <li class="menu-item"><a href="faq.html">FAQs Fast Facts*</a></li>
                            <li class="menu-item"><a href="truck-preparation.html">Truck Preparation Guide*</a></li>
                            <li class="menu-item"><a href="how-to-videos.html">Troubleshooting Videos*</a></li>
                            <li class="menu-item"><a href="how-to-videos.html">Walkthrough Videos*</a></li>
                            <li class="menu-item"><a href="how-to-videos.html">Load-Unload Videos*</a></li>
                            <li class="menu-item"><a href="#">Articles/Reviews</a></li>
                            <li class="menu-item"><a href="owners-manual.html">Owners Manuals*</a></li>
                            <li class="menu-item"><a href="#">Warranties</a></li>
                        </ul></li>
                    <li><a href="store.html">Store</a><ul class="sub-menu">
                            <li class="menu-item"><a href="#">Parts & Accessories</a></li>
                            <li class="menu-item"><a href="#">SWAG</a></li>
                        </ul></li>
                    <li><a href="#">Rent</a></li>
                    <li class="btn-dealer"><a href="find-a-dealer.html">Find Dealer</a></li>
                </ul>
            </nav>
            <div class="mobile-menu-wrap">
                <div class="mobile-menu-box">
                    <ul class="mobile-menu">
                        <li><a href="dev-sitemap.html"><span class="icon-skiing"></span> My Life</a></li>
                        <li><a href="campers.html">Campers</a></li>
                        <li><a href="financing.html">Financing</a>
                            <ul class="sub-menu">
                                <li class="menu-item"><a href="#">Sistahs Go Red</a></li>
                                <li class="menu-item"><a href="#">Sistahs Go Red</a></li>
                                <li class="menu-item"><a href="#">Sistahs Go Red</a></li>
                            </ul>
                        </li>
                        <li><a href="tradeshows.html">Events</a></li>
                        <li><a href="support.html">Support</a></li>
                        <li><a href="store.html">Store</a></li>
                        <li class="btn-dealer"><a href="find-a-dealer.html">Find  Dealer</a></li>
                    </ul>
                </div>
                <div class="mobile-menu-overlay"></div>
            </div>
        </div>
    </header>
    <header id="header-scrolling" class="header">
        <div class="container">
            <div class="logo">
                <a href="dev-sitemap.html">
                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/logo.png" alt=" Four Wheel Campers">
                </a>
            </div>
            <div class="mobile-menu-toggle">
                <span></span>
            </div>
            <nav class="main-nav desktop">
                <ul>
                    <li><a href="index.html"><span class="icon-skiing"></span> My Life</a></li>
                    <li><a href="campers.html">Campers</a></li>
                    <li><a href="financing.html">Financing</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="#">Sistahs Go Red</a></li>
                            <li class="menu-item"><a href="#">Sistahs Go Red</a></li>
                            <li class="menu-item"><a href="#">Sistahs Go Red</a></li>
                        </ul>
                    </li>
                    <li><a href="tradeshows.html">Events</a></li>
                    <li><a href="support.html">Support</a><ul class="sub-menu">
                            <li class="menu-item"><a href="#">Schedule A Service</a></li>
                            <li class="menu-item"><a href="#">Services Performed</a></li>
                            <li class="menu-item"><a href="truck-preparation.html">Truck Preparation Guide</a></li>
                            <li class="menu-item"><a href="how-to-videos.html">Troubleshooting Videos</a></li>
                            <li class="menu-item"><a href="how-to-videos.html">How-To Videos</a></li>
                            <li class="menu-item"><a href="#">Load-Unload Videos</a></li>
                            <li class="menu-item"><a href="faq.html">FAQs  Fast Facts</a></li>
                            <li class="menu-item"><a href="owners-manual.html">Owners Manuals</a></li>
                            <li class="menu-item"><a href="#">Warranties</a></li>
                        </ul></li>
                    <li><a href="store.html">Store</a></li>
                    <li><a href="#">Rent</a></li>
                    <li class="btn-dealer"><a href="find-a-dealer.html">Find Dealer</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content">