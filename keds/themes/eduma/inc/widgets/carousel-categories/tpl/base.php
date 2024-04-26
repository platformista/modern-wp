<?php
global $post;
$item_visible    = ! empty( $instance['visible'] ) ? $instance['visible'] : 1;
$pagination      = ( ! empty( $instance['pagination'] ) && $instance['pagination'] == 'yes' ) ? true : false;
$navigation      = ( ! empty( $instance['navigation'] ) && $instance['navigation'] != 'yes' ) ? false : true;
$cat_id          = ! empty( $instance['cat_id'] ) ? $instance['cat_id'] : array();
$post_limit      = ! empty( $instance['post_limit'] ) ? $instance['post_limit'] : 4;
$data_itemtablet = ( $item_visible < 2 ) ? $item_visible : 2;
$list_cat        = array();
if ( ! is_array( $cat_id ) ) {
	$list_cat[] = $cat_id;
} else {
	$list_cat = $cat_id;
}
$html = '';

if ( $instance['title'] ) {
	$html .= $args['before_title'] . $instance['title'] . $args['after_title'];
}

if ( ! empty( $list_cat ) ) {
	$html .= '<div class="thim-post-caregories-slider">';
	$html .= '<div class="thim-carousel-wrapper" data-visible="' . $item_visible . '" data-itemtablet="' . $data_itemtablet . '" data-pagination="' . $pagination . '" data-navigation="' . $navigation . '" data-navigation-text="2">';
	foreach ( $list_cat as $k => $cat_id ) {
		$is_cat = get_term( $cat_id, 'category' );
		if ( empty( $is_cat ) ) {
			return;
		}
		$query_args = array(
			'posts_per_page'      => $post_limit,
			'post_type'           => 'post',
			'ignore_sticky_posts' => true
		);

		//$posts_array = new WP_Query( $query_args );
		$posts_array = get_posts(
			array(
				'posts_per_page' => $post_limit,
				'tax_query'      => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $cat_id,
					)
				)
			)
		);

		$cat_name    = get_cat_name( $cat_id );
		$top_image   = get_term_meta( $cat_id, 'thim_archive_top_image', true );
		$description = category_description( $cat_id );

		$img = '<div class="image"><a href="' . esc_url( get_term_link( (int) $cat_id, 'category' ) ) . '">';
		if ( $top_image && '' != $top_image['id'] ) {
			$img .= thim_get_feature_image( $top_image['id'], 'full', 420, 420, $cat_name );
		} else {
			$img .= thim_get_feature_image( null, 'full', 420, 420, $cat_name );
		}
		$img .= '</a></div>';

		$html .= '<div class="item">';
		$html .= $img;
		$html .= '<div class="content-wrapper">';
		$html .= '<h3 class="title"><a href="' . esc_url( get_term_link( (int) $cat_id, 'category' ) ) . '">' . $cat_name . '</a></h3>';
		if ( ! empty( $description ) ) {
			$html .= '<div class="desc">' . $description . '</div>';
		}
		if ( ! empty( $posts_array ) ) {
			$html .= '<div class="list-course-items">';
			$html .= '<label>' . esc_html__( 'Courses', 'eduma' ) . '</label>';
			foreach ( $posts_array as $key => $value ) {
				$html .= '<a class="course-link" href="' . get_the_permalink( $value->ID ) . '" title="' . $value->post_title . '">' . thim_str_short( $value->post_title, 6 ) . '</a>';
			}
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		wp_reset_postdata();
	}
	$html .= '</div>';
	if ( ! empty( $instance['link_view_all'] ) && ! empty( $instance['text_view_all'] ) ) {
		$html .= '<a class="link-view-all" href="' . $instance['link_view_all'] . '" title="' . $instance['text_view_all'] . '">' . $instance['text_view_all'] . '</a>';
	}
	$html .= '</div>';

} else {
	$html .= '<p>' . esc_html__( 'You need edit page and config category for shortcode', 'eduma' ) . '</p>';
}


echo ent2ncr( $html );
