<?php
// body classes
$classes = '';
if (!get_field('show_hero_banner')) {
    $classes = 'white-header-bg';
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body <?php body_class($classes); ?>>
<div class="wrapper">
    <a class="btn-jump-to-content smooth-scroll" href="#main-content"><?php _e('Skip Navigation', 'fw_campers'); ?></a>

    <?php
        if ( has_custom_logo() ) {
            $custom_logo = wp_get_attachment_image_src( get_theme_mod('custom_logo'), 'full' );
            $logo_url = $custom_logo[0];
        } else {
            $logo_url = get_bloginfo('template_url') . '/img/logo.png';
        }
    ?>

    <header id="header-main" class="header">
        <div class="container">
            <div class="logo">
                <a href="<?php echo home_url(); ?>" title="<?= esc_attr(strip_tags(get_bloginfo('name'))); ?>">
                    <img src="<?php echo $logo_url; ?>" alt="<?= esc_attr(get_bloginfo('name')); ?>">
                </a>
            </div>
            <div class="mobile-menu-toggle">
                <span></span>
            </div>

            <?php wp_nav_menu(array(
                'theme_location'  => 'main-menu',
                'menu'            => 'Main Navigation',
                'container'       => 'nav',
                'container_class' => 'main-nav desktop',
                'container_id'    => false,
                'items_wrap'      => '<ul>%3$s</ul>',
                'depth'           => 2
            )); ?>

            <div class="mobile-menu-wrap">
                <div class="mobile-menu-box">
                    <?php wp_nav_menu(array(
                        'theme_location'  => 'main-menu',
                        'menu'            => 'Main Navigation',
                        'container'       => false,
                        'menu_class'      => 'mobile-menu',
                        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                        'depth'           => 2
                    )); ?>
                </div>
                <div class="mobile-menu-overlay"></div>
            </div>
        </div>
    </header>

    <header id="header-scrolling" class="header">
        <div class="container">
            <div class="logo">
                <a href="<?php echo home_url(); ?>" title="<?= esc_attr(strip_tags(get_bloginfo('name'))); ?>">
                    <img src="<?php echo $logo_url; ?>" alt="<?= esc_attr(get_bloginfo('name')); ?>">
                </a>
            </div>
            <div class="mobile-menu-toggle">
                <span></span>
            </div>
            <?php wp_nav_menu(array(
                'theme_location'  => 'main-menu',
                'menu'            => 'Main Navigation',
                'container'       => 'nav',
                'container_class' => 'main-nav desktop',
                'container_id'    => false,
                'items_wrap'      => '<ul>%3$s</ul>',
                'depth'           => 2
            )); ?>
        </div>
    </header>

    <main id="main-content">