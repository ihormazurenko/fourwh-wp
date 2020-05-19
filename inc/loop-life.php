<?php
$title = get_the_title();
$url = get_permalink();
$post_img_id = '';


if ( has_post_thumbnail() ) {
    $post_img_id = get_post_thumbnail_id();
} else {
    if (get_field('show_hero_banner')) {
        $hero_box = get_field('hero_banner');

        if ($hero_box && is_array($hero_box) && count($hero_box) > 0) {
            foreach ($hero_box as $single) {
                $post_img_id = ( $single['image'] && is_array( $single['image'] ) && count( $single['image'] ) > 0 ) ? $single['image']['id'] : '';
            }
        }
    }
}


if ($title && $url) {
    ?>
    <div class="grid-item" data-category="">
        <a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $title ); ?>">
            <span class="centered-img">
                <?php
                if ( $post_img_id ) {
                    echo wp_get_attachment_image( $post_img_id, 'large', false );
                }

                if ( $title ) {
                    ?>
                    <h2 class="life-title"><?php echo $title; ?></h2>
                    <?php
                }
                ?>
            </span>
        </a>
    </div>
    <?php
}