<?php

add_filter( 'manage_model_option_posts_columns', function ( $columns ) {
	$my_columns = [
		'thumb' => 'Thumb',
	];

	return array_slice( $columns, 0, 1 ) + $my_columns + $columns;
} );

add_filter( 'manage_model_option_posts_columns', function ( $columns ) {
	$my_columns = [
		'price'    => 'Price',
	];

	return array_slice( $columns, 0, 3 ) + $my_columns + $columns;
} );

add_action( 'manage_model_option_posts_custom_column', function ( $column_name ) {
    if ( $column_name === 'thumb' ) {
        $no_image_available = get_bloginfo("template_url").'/img/no_image_available.jpg';
        $photo = get_field('photo');
        $photo_url = $photo['sizes']['thumbnail'] ? $photo['sizes']['thumbnail'] : $no_image_available;
        ?>
        <a href="<?php echo get_edit_post_link(); ?>">
            <img src="<?php echo $photo_url; ?>" width="100" alt="<?php esc_attr(the_title()); ?>">
        </a>
        <?php
    }

    if ( $column_name === 'price' ) {
        if(have_rows('option_info')){
            while( have_rows('option_info') ): the_row();
                $price = get_sub_field('price') ? '$'.number_format(get_sub_field('price'), 2,'.', ',') : '';
                echo $price;
            endwhile;
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