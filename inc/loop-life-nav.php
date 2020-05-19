<?php
$nav_title = get_the_title();
$nav_url = get_permalink();
$item_img_size = 'medium';

$nav_hero_box = get_field('hero_banner');

if (get_field('show_hero_banner') && $nav_hero_box && is_array($nav_hero_box) && count($nav_hero_box) > 0) {
    foreach ($nav_hero_box as $single) {
        $post_nav_img_id = ( $single['image'] && is_array( $single['image'] ) && count( $single['image'] ) > 0 ) ? $single['image']['id'] : '';
        $post_nav_img_class = ($single['image']['width'] > $single['image']['height']) ? 'wider' : 'higher';
    }
} else {
    if ( has_post_thumbnail() ) {
        $post_nav_img_id = get_post_thumbnail_id();
        $post_nav_img_data = wp_get_attachment_image_src( $post_nav_img_id, $item_img_size, false );

        if ($post_nav_img_data && is_array($post_nav_img_data) && count($post_nav_img_data) > 0) {
            $post_nav_img_class = ($post_nav_img_data[1] > $post_nav_img_data[2]) ? 'wider' : 'higher';
        }
    }
}

if ($nav_url && $nav_title) :
    ?>
        <li>
            <div class="my-life-box">
                <a href="<?php echo esc_url($nav_url); ?>" title="<?php echo esc_attr(wp_strip_all_tags($nav_title)); ?>"><?php echo $nav_title; ?></a>
                    <?php
                        if ( $post_nav_img_id ) {
                            echo '<div class="my-life-img-thumbnail centered-img">'.wp_get_attachment_image( $post_nav_img_id, $item_img_size, false, array('class' => $post_nav_img_class) ).'</div>';
                        }
                    ?>
            </div>
        </li>
    <?php
endif;