<?php

$limit          = (int) $instance['slider-options']['limit'];
$pagination     = $instance['slider-options']['show_pagination'] ? 1 : 0;
$navigation     = $instance['slider-options']['show_navigation'] ? 1 : 0;
$sub_categories = $instance['sub_categories'] ? '' : 0;
$item_visible   = isset($instance['slider-options']['responsive-options']) ? (int) $instance['slider-options']['responsive-options']['item_visible'] : 7;
$taxonomy       = 'course_category';
$autoplay       = isset( $instance['slider-options']['auto_play'] ) ? $instance['slider-options']['auto_play'] : 0;

$args_cat = array(
	'taxonomy' => $taxonomy,
	'parent'   => $sub_categories
);
$args_cat = apply_filters( 'thim_query_slider_categories', $args_cat );

$cat_course = get_categories( $args_cat );

$demo_image_source_category = get_template_directory_uri() . '/images/demo_images/demo_image_category.jpg';

$html = '';
if ( $cat_course ) {
	$index = 1;
	$html  = '<div class="thim-carousel-course-categories-tabs">';
	$html  .= '<div class="thim-course-slider" data-visible="' . $item_visible . '" data-desktop="' . $item_visible . '" data-tablet="4" data-mobile="2" data-pagination="' . $pagination . '" data-navigation="' . $navigation . '" data-autoplay="' . esc_attr( $autoplay ) . '">';
	$i     = 0;
	foreach ( $cat_course as $key => $value ) {
		$i ++;
		$icon = array();
		if ( get_term_meta( $value->term_id, 'thim_learnpress_cate_icon', true ) ) {
			$icon = get_term_meta( $value->term_id, 'thim_learnpress_cate_icon', true );
		}
		$top_image = get_term_meta( $value->term_id, 'thim_learnpress_top_image', true );
		//$content_cat = apply_filters( 'the_content', get_the_content( $value->term_id ) );

		$img = '<a href="' . esc_url( get_term_link( (int) $value->term_id, $taxonomy ) ) . '">';
		if ( ! empty( $top_image ) && '' != $top_image['id'] ) {
			$img .= thim_get_feature_image( $top_image['id'], 'full', apply_filters( 'thim_course_category_thumbnail_width', 150 ), apply_filters( 'thim_course_category_thumbnail_height', 100 ), $value->name );
		} else {
			$img .= thim_get_feature_image( null, 'full', apply_filters( 'thim_course_category_thumbnail_width', 150 ), apply_filters( 'thim_course_category_thumbnail_height', 100 ), $value->name );
		}
		$img    .= '</a>';
		$active = ( $i == 1 ) ? 'active' : '';

		$html .= '<div class="item ' . $active . '">';
		
		if ( ! empty( $icon ) ) {
			$html .= '<div class="icon">';
			$alt = '';
			$alt = get_post_meta( $icon['id'], '_wp_attachment_image_alt', true ) ? get_post_meta( $icon['id'], '_wp_attachment_image_alt', true ) : $value->name;
			if ( is_array( $icon ) ) {
				$html .= '<img alt="' . $alt . '" src="' . $icon['url'] . '">';
			} else {
				$html .= '<i class="' . $icon . '"></i>';
			}
			$html .= '</div>';
		}
		
		$html .= '<h3 class="title"><a href="#' . urldecode( $value->slug ) . '">' . $value->name . '</a></h3>';
		$html .= '</div>';
		if ( $index == $limit ) {
			break;
		}
		$index ++;
	}
	$html .= '</div>';
	$html .= '<div class="content_items">';
	$i    = 0;
	foreach ( $cat_course as $key => $value ) {
		$i ++;
		$active   = ( $i == 1 ) ? 'active' : '';
		$thumb    = get_term_meta( $value->term_id, 'thim_learnpress_cate_thumnail', true );
		$content  = get_term_meta( $value->term_id, 'thim_learnpress_cate_content', true );
		$content  = htmlspecialchars_decode( $content );
		$content  = wpautop( $content );
		$link_cat = '<a class="view_all_courses" href="' . esc_url( get_term_link( (int) $value->term_id, $taxonomy ) ) . '">' . esc_html__( 'View all courses', 'eduma' ) . ' <i class="tk tk-arrow-right"></i></a>';
		$html     .= '<div class="item_content ' . $active . '" id="' . urldecode( $value->slug ) . '">';
		if ( isset( $thumb["url"] ) ) {
			$html .= '<img class="fleft" src="' . $thumb["url"] . '">';
		}
		$html .= '<div class="content">' . $content . '</div>';
		$html .= $link_cat;
		$html .= '</div>';
	}
	$html .= '</div>';
	$html .= '</div>';
}

if ( $instance['title'] ) {
	echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
}
echo ent2ncr( $html );