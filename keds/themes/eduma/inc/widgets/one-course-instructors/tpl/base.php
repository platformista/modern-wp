<?php

$total = wp_count_posts( 'lp_course' );
$total = $total->publish;
if ( ! $total ) {
	echo '<p class="message message-error">' . esc_html__( 'There are no publish courses available yet.', 'eduma' ) . '</p>';

	return;
}

$theme_options_data = get_theme_mods();
$autoplay           = isset( $instance['auto_play'] ) ? $instance['auto_play'] : 0;

$course_id_old = ( isset( $theme_options_data['thim_learnpress_one_course_id'] ) && ! empty( $theme_options_data['thim_learnpress_one_course_id'] ) ) ? $theme_options_data['thim_learnpress_one_course_id'] : 0;

$course_id = ( isset( $instance['courses_id'] ) && $instance['courses_id'] ) ? $instance['courses_id'] : $course_id_old;
if ( $course_id ) {
	// validate type course
	if ( get_post_type( $course_id ) != 'lp_course' ) {
		echo '<p class="message message-error">' . esc_html__( 'Invalid the one course ID.', 'eduma' ) . '</p>';

		return;
	}

	// validate status
	if ( get_post_status( $course_id ) != 'publish' ) {
		echo '<p class="message message-error">' . sprintf( wp_kses( __( 'The one course has not been publish yet. <a href="%s">Edit</a>.', 'eduma' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( get_edit_post_link( $course_id ) ) ) . '</p>';

		return;
	}
} else {
	// Or get latest course
	$latest_course = get_posts( 'post_type=lp_course&numberposts=1&fields=ids' );
	$course_id     = $latest_course[0];
}

/**
 * Display instructors of the one course
 */

$course         = get_post( $course_id );
$instructors    = array( $course->post_author );
$co_instructors = array();
if ( class_exists( 'LP_Co_Instructor_Preload' ) ) {
	$co_instructors = get_post_meta( $course_id, '_lp_co_teacher' );
	$co_instructors = array_diff( $co_instructors, $instructors );
}
array_unshift( $co_instructors, $course->post_author );


$visible_item = 3;
if ( $instance['visible_item'] && $instance['visible_item'] != '' ) {
	$visible_item = (int) $instance['visible_item'];
}

if ( count( $co_instructors ) < $visible_item ) {
	$visible_item = count( $co_instructors );
}

$pagination = ( ! empty( $instance['show_pagination'] ) && $instance['show_pagination'] !== 'no' ) ? 1 : 0;

// Using $co_instructors
if ( ! empty( $co_instructors ) ) {
	$html = '<div class="thim-carousel-wrapper thim-carousel-instructors" data-visible="' . $visible_item . '" data-pagination="' . $pagination . '" data-autoplay="' . esc_attr( $autoplay ) . '">';
	foreach ( $co_instructors as $key => $instructor ) {
		$lp_info = get_the_author_meta( 'lp_info', $instructor );
		$link    = learn_press_user_profile_link( $instructor );
		$html    .= '<div class="instructor-item">';
		$html    .= '<div class="avatar">' . get_avatar( $instructor, 65 ) . '</div>';
		$html    .= '<div class="instructor-info">';
		$html    .= '<h4 class="name" >' . get_the_author_meta( 'display_name', $instructor ) . '</h4>';
		if ( isset( $lp_info['major'] ) ) {
			$html .= '<p class="job">' . $lp_info['major'] . '</p>';
		}
		$html .= '</div>';
		$html .= '<div class="description">' . get_the_author_meta( 'description', $instructor ) . '</div>';
		$html .= '<a class="readmore" href="' . $link . '">' . esc_html( 'Read More', 'eduma' ) . '</a>';
		$html .= '</div>';
	}
	$html .= '</div>';
}

echo ent2ncr( $html );

?>