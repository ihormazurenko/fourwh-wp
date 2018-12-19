<?php

add_filter( 'manage_model_posts_columns', function ( $columns ) {
	$my_columns = [
		'thumb' => 'Thumb',
	];

	return array_slice( $columns, 0, 1 ) + $my_columns + $columns;
} );

add_filter( 'manage_model_posts_columns', function ( $columns ) {
	$my_columns = [
		'price'    => 'Price',
	];

	return array_slice( $columns, 0, 3 ) + $my_columns + $columns;
} );

add_action( 'manage_model_posts_custom_column', function ( $column_name ) {
    if ( $column_name === 'thumb' ) {
        $no_image_available = get_bloginfo("template_url").'/img/no_image_available.jpg';
        $photo_id     = get_post_thumbnail_id(get_the_ID());
        $photo        = image_downsize($photo_id,'thumbnail');
        $photo_url    = $photo[0] ? $photo[0] : $no_image_available ;

        ?>
        <a href="<?php echo get_edit_post_link(); ?>">
            <img src="<?php echo $photo_url; ?>" width="100" alt="<?php esc_attr(the_title()); ?>">
        </a>
        <?php
    }

    if ( $column_name === 'price' ) {
        if (get_field('model_price')) {
            $price = get_field('model_price') ? '$'.number_format(get_field('model_price'), 2,'.', ',') : '';
            echo $price;
        }
    }
} );


add_action( 'admin_print_footer_scripts-edit.php', function () {
	?>
	<style>
		.column-price {
			width: 160px;
		}
		.column-thumb {
			width: 100px;
		}
		.column-thumb img {
			height: auto;
            max-width: 100%;
		}
	</style>
	<?php
} );