<?php

$html             = '';
$limit_instructor = 4;
$kit_class        = isset( $instance['thim_kits_class'] ) ? ' ' . $instance['thim_kits_class'] : '';

if ( $instance['visible_item'] && $instance['visible_item'] != '' ) {
	$limit_instructor = (int) $instance['visible_item'];
}
$co_instructors = thim_get_all_courses_instructors( $limit_instructor );

$columns = $instance['columns'];


if ( ! empty( $co_instructors ) ) {
	$html = '<div class="thim-list-instructors instructor-grid instructor-colums-' . $columns . ' ' . $kit_class . '">';

	foreach ( $co_instructors as $key => $instructor ) {
		$lp_info     = get_the_author_meta( '_lp_extra_info', $instructor["user_id"] );
		$link        = learn_press_user_profile_link( $instructor["user_id"] );
		$position    = get_the_author_meta( 'job', $instructor["user_id"] );
		$html_social = $class_has_social = '';
		if ( isset( $lp_info['facebook'] ) && $lp_info['facebook'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['facebook'] ) . '" class="facebook"><i class="fab fa-facebook-f"></i></a></li>';
		}
		if ( isset( $lp_info['twitter'] ) && $lp_info['twitter'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['twitter'] ) . '" class="twitter"><i class="fab fa-x-twitter"></i></a></li>';
		}

		if ( isset( $lp_info['instagram'] ) && $lp_info['instagram'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['instagram'] ) . '" class="instagram"><i aria-hidden="true" class="tk tk-instagram"></i></a></li>';
		}
		if ( isset( $lp_info['linkedin'] ) && $lp_info['linkedin'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['linkedin'] ) . '" class="linkedin"><i class="fab fa-linkedin-in"></i></a></li>';
		}
		if ( isset( $lp_info['youtube'] ) && $lp_info['youtube'] ) {
			$html_social .= '<li><a href="' . esc_url( $lp_info['youtube'] ) . '" class="youtube"><i class="fab fa-youtube"></i></a></li>';
		}
		if ( $html_social ) {
			$class_has_social = ' has-social';
		}

		$html .= '<div class="instructor-item' . $class_has_social . '"><div class="wrap-item">';
		$html .= '<div class="avatar_item">' . get_avatar( $instructor["user_id"], 450 ) . '';

		if ( $html_social ) {
			$html .= '<div class="info_ins"><ul class="thim-author-social">' . $html_social . '</ul></div>';
		}

		$html .= '</div>';
		$html .= '<div class="instructor-info">';
		$html .= '<h4 class="name" ><a href="' . $link . '">' . get_the_author_meta( 'display_name', $instructor["user_id"] ) . '</a></h4>';

		if ( isset( $position ) ) {
			$html .= '<p class="job">' . $position . '</p>';
		}

		$html .= '</div>';

		$html .= '</div>';
		$html .= '</div>';
	}

	$html .= '</div>';
}

echo ent2ncr( $html );
