<?php
// body classes
$classes = '';
$classes .= 'no-js';

if (is_post_type_archive('event') || is_tax('event_category')) {
    $id = 339;
} elseif (is_post_type_archive('video') || is_tax('video_category')) {
    $id = 1020;
} elseif (is_post_type_archive('model') || is_tax('model_sizes')) {
    $id = 1236;
} elseif (is_page()) {
    $id = get_the_ID();
} else {
    $id = '';
}

if (is_tax('model_categories')) {
    $model_category_id = get_queried_object()->term_id;
    $model_category_info = get_field('model_category_info', 'model_categories_'.$model_category_id);

    if ($model_category_info && is_array($model_category_info) && count($model_category_info) > 0) {
//        if ( ! $model_category_info['hero_image'] ) {
//            $classes .= ' white-header-bg';
//        }
        $classes .= ' white-header-bg';
    }
}

if (!get_field('show_hero_banner', $id)) {
    $classes .= ' white-header-bg';
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
<script type="text/javascript">
    document.body.className = document.body.className.replace("no-js","js");
</script>
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