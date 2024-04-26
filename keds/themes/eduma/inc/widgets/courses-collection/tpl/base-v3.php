<?php
global $post;

$limit         = $instance['limit'] ? $instance['limit'] : 4;
$columns       = $instance['columns'] ? $instance['columns'] : 3;
$feature_items = $instance['feature_items'] ? $instance['feature_items'] : 2;

$condition = array(
	'post_type'           => 'lp_collection',
	'posts_per_page'      => $limit,
	'ignore_sticky_posts' => true,
);

$features_html = $items_html = '';

$the_query = new WP_Query( $condition );

if ( $the_query->have_posts() ) :
	$index = 1;
	while ( $the_query->have_posts() ) : $the_query->the_post();

		if ( $feature_items >= $index ) :
			ob_start();
			?>
			<div class="collection-feature collection-item <?php echo 'collection-grid-' . $columns; ?>">
				<div class="item">
					<div class="thumbnail">
						<?php
						echo '<a href="' . esc_url( get_the_permalink() ) . '" class="feature-image">';
						echo thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', apply_filters( 'thim_collection_feature_thumbnail_width', 450 ), apply_filters( 'thim_collection_feature_thumbnail_height', 450 ), get_the_title() );
						echo '</a>';
						?>
						<a class="title"
						   href="<?php echo esc_url( get_the_permalink() ); ?>"> <?php echo get_the_title(); ?></a>
					</div>
				</div>
			</div>
			<?php
			$features_html .= ob_get_contents();
			ob_end_clean();
		else:
			ob_start();
			?>
			<div class="collection-item <?php echo 'collection-grid-' . $columns; ?>">
				<div class="item">
					<div class="thumbnail">
						<?php
						echo '<a href="' . esc_url( get_the_permalink() ) . '" >';
						echo thim_get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', apply_filters( 'thim_collection_item_thumbnail_width', 450 ), apply_filters( 'thim_collection_item_thumbnail_height', 207 ), get_the_title() );
						echo '</a>';
						?>
						<a class="title"
						   href="<?php echo esc_url( get_the_permalink() ); ?>"> <?php echo get_the_title(); ?></a>
					</div>
				</div>
			</div>
			<?php
			$items_html .= ob_get_contents();
			ob_end_clean();
		endif;
		?>

		<?php
		$index ++;
	endwhile;
	?>
<?php

endif;

wp_reset_postdata();

?>
<div class="thim-courses-collection row">
	<?php echo ent2ncr( $features_html ); ?>
	<?php if ( $items_html != '' ): ?>
		<div class="">
			<?php echo ent2ncr( $items_html ); ?>
		</div>
	<?php endif; ?>
</div>
