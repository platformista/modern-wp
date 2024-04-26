<?php
$html             = '';
$limit_instructor = 4;
$autoplay         = isset( $instance['auto_play'] ) ? $instance['auto_play'] : 0;
$show_navigation  = isset( $instance['show_navigation'] ) ? $instance['show_navigation'] : 1;
$kit_class        = isset( $instance['thim_kits_class'] ) ? ' ' . $instance['thim_kits_class'] : '';
if ( $instance['limit_instructor'] && $instance['limit_instructor'] != '' ) {
	$limit_instructor = (int) $instance['limit_instructor'];
}
$co_instructors = thim_get_all_courses_instructors( $limit_instructor );
$visible_item   = 3;
if ( $instance['visible_item'] && $instance['visible_item'] != '' ) {
	$visible_item = (int) $instance['visible_item'];
}

if ( count( $co_instructors ) < $visible_item ) {
	$visible_item = count( $co_instructors );
}

$pagination = ( ! empty( $instance['show_pagination'] ) && $instance['show_pagination'] !== 'no' ) ? 1 : 0;

if ( ! empty( $co_instructors ) ) {
	$html = '<div class="thim-carousel-wrapper thim-carousel-list-instructors' . $kit_class . '" data-visible="' . $visible_item . '" data-navigation="' . $show_navigation . '" data-pagination="' . $pagination . '" data-autoplay="' . esc_attr( $autoplay ) . '">';
	foreach ( $co_instructors as $key => $instructor ) {
		$lp_info     = get_the_author_meta( '_lp_extra_info', $instructor["user_id"] );
		$link        = learn_press_user_profile_link( $instructor["user_id"] );
		$html_social = $class_has_social = '';
		if ( isset( $lp_info['facebook'] ) && $lp_info['facebook'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['facebook'] ) . '" class="facebook"><i class="fa fa-facebook"></i></a></li>';
		}
		if ( isset( $lp_info['twitter'] ) && $lp_info['twitter'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['twitter'] ) . '" class="twitter"><i class="fa fa-x-twitter"></i></a></li>';
		}

		if ( isset( $lp_info['instagram'] ) && $lp_info['instagram'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['instagram'] ) . '" class="instagram"><i class="fa fa-instagram"></i></a></li>';
		}
		if ( isset( $lp_info['linkedin'] ) && $lp_info['linkedin'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['linkedin'] ) . '" class="linkedin"><i class="fa fa-linkedin"></i></a></li>';
		}
		if ( isset( $lp_info['youtube'] ) && $lp_info['youtube'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['youtube'] ) . '" class="youtube"><i class="fa fa-youtube"></i></a></li>';
		}
		if ( $html_social ) {
			$class_has_social = ' has-social';
		}

		$html .= '<div class="instructor-item' . $class_has_social . '"><div class="wrap-item">';
		$html .= '<div class="avatar_item">' . get_avatar( $instructor["user_id"], 450 ) . '</div>';
		$html .= '<div class="instructor-info">';
		$html .= '<h4 class="name" ><a href="' . $link . '">' . get_the_author_meta( 'display_name', $instructor["user_id"] ) . '</a></h4>';
		if ( isset( $lp_info['major'] ) ) {
			$html .= '<p class="job">' . $lp_info['major'] . '</p>';
		}
		$html .= '<div class="description">' . thim_author_bio_excerpt( $instructor["user_id"] ) . '</div>';


		if ( $html_social ) {
			$html .= '<div class="info_ins"><div class="row"><ul class="thim-author-social">' . $html_social . '</ul></div></div>';
		}

		$html .= '</div>';


		$html .= '</div></div>';
	}
	$html .= '</div>';
}

echo ent2ncr( $html );
