<?php
$link           = $regency = $extend_class = $data_style = '';
$link_to_single = ! empty( $instance['link_to_single'] ) ? true : false;
$limit          = ( $instance['limit'] && '' <> $instance['limit'] ) ? (int) $instance['limit'] : 10;
$item_visible   = ( $instance['item_visible'] && '' <> $instance['item_visible'] ) ? (int) $instance['item_visible'] : 1;
$autoplay       = isset( $instance['carousel-options']['autoplay'] ) ? $instance['carousel-options']['autoplay'] : 0;
$item_time      = ( $instance['pause_time'] && '' <> $instance['pause_time'] ) ? (int) $instance['pause_time'] : 5000;
$navigation     = isset( $instance['carousel-options']['show_navigation'] ) ? $instance['carousel-options']['show_navigation'] : 0;
$pagination     = isset( $instance['carousel-options']['show_pagination'] ) ? $instance['carousel-options']['show_pagination'] : 0;

$testomonial_args = array(
	'post_type'           => 'testimonials',
	'posts_per_page'      => $limit,
	'ignore_sticky_posts' => true
);

$testimonial = new WP_Query( $testomonial_args );
if ( $instance['carousel_style'] != 'style_1' ) {
	$extend_class = ' testimonial-carousel_' . $instance['carousel_style'];
}
if ( $testimonial->have_posts() ) {
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
if ( $instance['carousel_style'] == 'style_3' ) {
	$data_style = ' data-itemtablet="1"';
} else if ($instance['carousel_style'] == 'style_2') {
	$data_style = ' data-desktopsmall="2"';
}

	$html = '<div class="thim-testimonial-carousel thim-carousel-wrapper ' . $extend_class . '" data-time="' . $item_time . '" data-visible="' . $item_visible . '"
	     data-pagination="' . esc_attr( $pagination ) . '" data-navigation="' . esc_attr( $navigation ) . '" data-autoplay="' . esc_attr( $autoplay ) . '"'.$data_style.'>';
	while ( $testimonial->have_posts() ) : $testimonial->the_post();
		$link    = get_post_meta( get_the_ID(), 'website_url', true );
		$regency = get_post_meta( get_the_ID(), 'regency', true );

		if ( $link_to_single ) {
			$title = '<h3 class="title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
		} elseif ( $link <> '' ) {
			$title = '<h3 class="title"><span class="line"></span><a href="' . $link . '">' . get_the_title() . '</a></h3>';
		} else {
			$title = '<h3 class="title"><span class="line"></span>' . get_the_title() . '</h3>';
		}

		$html .= '<div class="item">';
		$html .= '<div class="content">';
		if ( $instance['carousel_style'] == 'style_2' ) {
			$html .= '<div class="block-header">';
			if ( has_post_thumbnail() ) {
				$html .= thim_get_feature_image( get_post_thumbnail_id(), 'full', apply_filters( 'thim_testimonial_thumbnail_width', 100 ), apply_filters( 'thim_testimonial_thumbnail_height', 100 ), '', '', 1 );
			}
			$html .= $title;
			$html .= '</div>';

			if ( $regency ) {
				$html .= '<h2 class="regency">' . $regency . '</h2>';
			}
			$html .= '<div class="description">' . get_the_content() . '</div>';

		}
		else if ( $instance['carousel_style'] == 'style_3' ) {
			$html .= '<div class="description">' . get_the_content() . '</div>';
			$html .= '<div class="block-header">';
			
			if ( has_post_thumbnail() ) {
				$html .= '<div class="image">';
				$html .= thim_get_feature_image( get_post_thumbnail_id(), 'full', apply_filters( 'thim_testimonial_thumbnail_width', 100 ), apply_filters( 'thim_testimonial_thumbnail_height', 100 ), '', '', 1 );
 				$html .= '</div>';
			}
			$html .='<div class="info">';
			$html .= $title;
			if ( $regency ) {
				$html .= '<h2 class="regency">' . $regency . '</h2>';
			}
			$html .= '</div>';
			$html .= '</div>';
		} else {
			$html .= '<div class="description">' . get_the_content() . '</div>';
			$html .= $title;
		}

		$html .= '</div></div>';

	endwhile;
	$html .= '</div>';
}

wp_reset_postdata();
echo ent2ncr( $html );
?>


