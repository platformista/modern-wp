<?php
$panel_list = $instance['panel'] ? $instance['panel'] : '';
$pagination = ( ! empty( $instance['show_pagination'] ) && $instance['show_pagination'] !== 'no' ) ? 1 : 0;
$show_navigation         = isset( $instance['show_navigation'] ) ? $instance['show_navigation'] : 1;
$autoplay   = isset( $instance['auto_play'] ) ? $instance['auto_play'] : 0;
$html       = '<div class="thim-instructors-new">';
$heading    = ! ( empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Popular Courses', 'eduma' );

if ( ! empty( $panel_list ) ) {
	$html .= '<div class="thim-carousel-wrapper" data-visible="1" data-navigation="'.$show_navigation.'" data-itemtablet="1" data-pagination="' . $pagination . '" data-autoplay="' . esc_attr( $autoplay ) . '">';
	foreach ( $panel_list as $key => $panel ) {
		if ( ! empty( $panel['panel_id'] ) ) {
			$arr_query = array(
				'post_type'           => 'lp_course',
				'author'              => $panel['panel_id'] ,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'posts_per_page'      =>  2
			);
			$courses  = new WP_Query( $arr_query );

  			$img_id = is_array( $panel['panel_img'] ) ? $panel['panel_img']['id'] : $panel['panel_img'];

			$html .= '<div class="instructor-item">';
			$html .= '<div class="instructor-image">';
			$html .= thim_get_feature_image( $img_id );
			$html .= '</div>';
			$html .= '<div class="instructor-info">';
			$html .= '<h4><a href="' . learn_press_user_profile_link( $panel["panel_id"] ) . '">' . get_the_author_meta( 'display_name', $panel['panel_id'] ) . '</a></h4>';
			$html .= '<div class="des">' . get_the_author_meta( 'description', $panel['panel_id'] ) . '</div>';
			if ( $courses ) {
				$html  .= '<div class="list-courses">';
				$html  .= '<h3>' . $heading . '</h3>';
 				foreach ( $courses->posts as $key => $course ) {

					$html .= '<div class="course-instructor">';
					$html .= thim_get_feature_image( get_post_thumbnail_id( $course->ID ), 'full', '100', '80' );
					$html .= '<h5><a href="' . get_permalink( $course->ID ) . '">' . get_the_title( $course->ID ) . '</a></h5>';
					$html .= '</div>';
				}
				$html .= '</div>';
			}
			wp_reset_query();
			$html .= '</div>';
			$html .= '</div>';
		}
	}
	$html .= '</div>';
}
$html .= '</div>';

echo ent2ncr( $html );
