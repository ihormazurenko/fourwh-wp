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
	if ( $column_name === 'thumb' && has_post_thumbnail() ) {
        ?>
            <a href="<?php echo get_edit_post_link(); ?>">
                <?php the_post_thumbnail( 'thumbnail' ); ?>
            </a>
        <?php
	}

	if ( $column_name === 'price' ) {
		if(get_field('price')){
            $price = get_field('price') ? '$'.number_format(get_field('price'), 2,'.', ',') : '';
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