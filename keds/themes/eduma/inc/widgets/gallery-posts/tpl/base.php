<?php
$limit      = !empty( $instance['limit'] ) ? $instance['limit'] : 8;
$filter     = isset( $instance['filter'] ) ? $instance['filter'] : true;
$columns    = !empty( $instance['columns'] ) ? $instance['columns'] : 3;

$query_args = array(
	'post_type'      => 'post',
	'tax_query'      => array(
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-gallery' ),
		)
	),
	'posts_per_page' => $limit
);

if ( !empty( $instance['cat'] ) ) {
	if ( '' != get_cat_name( $instance['cat'] ) ) {
		$query_args['cat'] = $instance['cat'];
	}
}

switch ( $columns ) {
	case 2:
		$class_col = "col-sm-6";
		break;
	case 3:
		$class_col = "col-sm-4";
		break;
	case 4:
		$class_col = "col-sm-3";
		break;
	case 5:
		$class_col = "thim-col-5";
		break;
	case 6:
		$class_col = "col-sm-2";
		break;
	default:
		$class_col = "col-sm-4";
}

$class_col .= ' item_post';

$posts_display = new WP_Query( $query_args );


if ( $posts_display->have_posts() ) :
	wp_enqueue_script( 'magnific-popup');
	wp_enqueue_script('isotope');
	$categories = array();
	$html      = '';

	while ( $posts_display->have_posts() ) : $posts_display->the_post();

		$img   = thim_get_feature_image( get_post_thumbnail_id(), 'full', apply_filters( 'thim_gallery_post_thumbnail_width', 440 ), apply_filters( 'thim_gallery_post_thumbnail_height', 440 ), get_the_title() );
		$class = '';
		$cats  = get_the_category();
		if ( !empty( $cats ) ) {
			foreach ( $cats as $key => $value ) {
				$class .= ' filter-' . $value->term_id;
				$categories[$value->term_id] = $value->name;
			}
		}
		$html .= '<div class="item_gallery ' . $class_col . $class . '">';
		$html .= apply_filters( 'thim_before_gallery_popup', '', get_the_ID() );
		$html .= '<a class="thim-gallery-popup" href="#" data-id="' . get_the_ID() . '">' . $img . '</a>';
		$html .= apply_filters( 'thim_after_gallery_popup', '', get_the_ID() );
		$html .= '</div>';

	endwhile;

	?>

	<?php if ( $filter ):
 	?>
	<div class="wrapper-filter-controls">
		<ul class="filter-controls">
			<li>
				<a class="filter active" data-filter="*" href="javascript:;"><?php esc_html_e( 'All', 'eduma' ); ?></a>
			</li>
			<?php

			if ( !empty( $categories ) ) {
				foreach ( $categories as $key => $value ) {
					echo '<li><a class="filter" href="javascript:;" data-filter=".filter-' . $key . '">' . $value . '</a></li>';
				}
			}
			?>
		</ul>
	</div>
<?php endif; ?>

	<div class="wrapper-gallery-filter row" itemscope itemtype="http://schema.org/ItemList">
		<?php
		echo ent2ncr( $html );
		?>
	</div>
	<div class="thim-gallery-show"></div>

	<?php
endif;
wp_reset_postdata();
