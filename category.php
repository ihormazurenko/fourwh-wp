<?php get_header(); 
    $category = get_category( get_query_var( 'cat' ) );
    $cat_id = $category->cat_ID;
?>

    <div class="content-wrap">
		<div class="content">
			<?php global $wp_query;

                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = array(
                    'post_type'     => 'post',
                    'post_status'   => 'publish',
                    'cat'           => $cat_id,
                    'orderby'       => 'date',
                    'order'         => 'DESC',
                    'paged'         => $paged,
                );
                $new_query = new WP_Query( $args );

                if ( $new_query->have_posts() ) : while ( $new_query->have_posts() ) : $new_query->the_post();
            ?>
				<?php get_template_part('loop', 'post'); ?>

			<?php endwhile; ?>

                <?php wp_pagenavi( array( 'query' => $new_query ) ); ?>

            <?php else: echo "<p class='no-results'>Sorry, articles not found...</p>"; 
                endif; wp_reset_query(); ?>
			 
		</div><!--/content-->	

		<?php get_sidebar(); ?>

	</div><!--/content-wrap-->

<?php get_footer(); ?>