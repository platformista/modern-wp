<?php
 // add cusom field for course
remove_action( 'learnpress/course-settings/after-general', 'eduma_add_custom_field_course' );

if ( ! function_exists( 'kid_new_art_child_eduma_add_custom_field_course' ) ) {

	function kid_new_art_child_eduma_add_custom_field_course() {

		lp_meta_box_text_input_field(
			array(
				'label'       => esc_html__( 'Duration Info', 'eduma' ),
				'id'          => 'thim_course_duration',
				'description' => esc_html__( 'Overwrite display Duration in singe course', 'eduma' ),
				'default'     => ''
			)
		);

		lp_meta_box_text_input_field(
			array(
				'label'       => esc_html__( 'Time', 'eduma' ),
				'id'          => 'thim_course_time',
				'description' => esc_html__( 'Show Time start and time end in course', 'eduma' ),
				'default'     => '',
			)
		);
		lp_meta_box_text_input_field(
			array(
				'label'       => esc_html__( 'Day of Week', 'eduma' ),
				'id'          => 'thim_course_day_of_week',
				'description' => esc_html__( 'Show Day of Week Course', 'eduma' ),
				'default'     => '',
			)
		);

		lp_meta_box_text_input_field(
			array(
				'id'         => 'thim_course_available_seats',
				'label'      => esc_html__( 'Available Seats', 'eduma-child-kid-art' ),
				'desc'       => esc_html__( 'Enter available seats', 'eduma-child-kid-art' ),
				'default'    => '10',
				'type_input' => 'number',
				'style'      => 'width: 100px',
			)
		);



		lp_meta_box_text_input_field(
			array(
				'id'      => 'thim_course_price',
				'label'   => esc_html__( 'Price', 'eduma-child-kid-art' ),
				'desc'    => esc_html__( 'Enter course price', 'eduma-child-kid-art' ),
				'default' => '$50'
			)
		);

		lp_meta_box_text_input_field(
			array(
				'id'      => 'thim_course_unit_price',
				'label'   => esc_html__( 'Unit', 'eduma-child-kid-art' ),
				'desc'    => esc_html__( 'Enter unit, for example, p/h, person/hour', 'eduma-child-kid-art' ),
				'default' => esc_html__( 'p/h', 'eduma-child-kid-art' )
			)
		);
		lp_meta_box_textarea_field(
			array(
				'id'          => 'thim_course_media_intro',
				'label'       => esc_html__( 'Media Intro', 'eduma' ),
				'description' => esc_html__( 'Enter media intro', 'eduma' ),
				'default'     => '',
			)
		);
	}
}

add_action( 'learnpress/course-settings/after-general', 'kid_new_art_child_eduma_add_custom_field_course' );

add_action(
	'learnpress_save_lp_course_metabox', function ( $post_id ) {
	$video           = ! empty( $_POST['thim_course_media_intro'] ) ? $_POST['thim_course_media_intro'] : '';
	$time            = ! empty( $_POST['thim_course_time'] ) ? $_POST['thim_course_time'] : '';
	$duration_info   = ! empty( $_POST['thim_course_duration'] ) ? $_POST['thim_course_duration'] : '';
	$day_of_week     = ! empty( $_POST['thim_course_day_of_week'] ) ? $_POST['thim_course_day_of_week'] : '';
	$available_seats = ! empty( $_POST['thim_course_available_seats'] ) ? $_POST['thim_course_available_seats'] : '';
 	$course_price    = ! empty( $_POST['thim_course_price'] ) ? $_POST['thim_course_price'] : '';
	$unit_price      = ! empty( $_POST['thim_course_unit_price'] ) ? $_POST['thim_course_unit_price'] : '';

	update_post_meta( $post_id, 'thim_course_media_intro', $video );
	update_post_meta( $post_id, 'thim_course_time', $time );
	update_post_meta( $post_id, 'thim_course_duration', $duration_info );
	update_post_meta( $post_id, 'thim_course_day_of_week', $day_of_week );
	update_post_meta( $post_id, 'thim_course_available_seats', $available_seats );
 	update_post_meta( $post_id, 'thim_course_price', $course_price );
	update_post_meta( $post_id, 'thim_course_unit_price', $unit_price );
}
);
