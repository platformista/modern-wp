<?php
/**
 * Section Course Features
 *
 * @package Eduma
 */

thim_customizer()->add_section(
	array(
		'id'       => 'course_features',
		'panel'    => 'course',
		'title'    => esc_html__( 'Settings', 'eduma' ),
		'priority' => 5,
	)
);
// Enable or Disable Login Popup when take this course
thim_customizer()->add_field(
	array(
		'id'       => 'thim_learnpress_single_popup',
		'type'     => 'switch',
		'label'    => esc_html__( 'Enable Login Popup', 'eduma' ),
		'tooltip'  => esc_html__( 'Enable login popup when take this course with user not logged in.', 'eduma' ),
		'section'  => 'course_features',
		'default'  => true,
		'priority' => 10,
		'choices'  => array(
			true  => esc_html__( 'Show', 'eduma' ),
			false => esc_html__( 'Hide', 'eduma' ),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'thim_single_course_offline',
		'type'     => 'switch',
		'label'    => esc_html__( 'Enable Course Offline', 'eduma' ),
		'section'  => 'course_features',
		'default'  => false,
		'priority' => 13,
		'choices'  => array(
			true  => esc_html__( 'Enable', 'eduma' ),
			false => esc_html__( 'Disable', 'eduma' ),
		),
	)
);


// Feature: Setup contact form 7 shortcode
thim_customizer()->add_field(
	array(
		'type'            => 'text',
		'id'              => 'thim_learnpress_shortcode_contact',
		'label'           => esc_html__( 'ID of contact Form 7 Shortcode', 'eduma' ),
		'tooltip'         => esc_html__( 'Only use for Demo Kindergarten.', 'eduma' ),
		'section'         => 'course_features',
		'priority'        => 30,
		'active_callback' => array(
			array(
				'setting'  => 'thim_single_course_offline',
				'operator' => '===',
				'value'    => true,
			),
		),
	)
);

// Setup timetable link for single course
thim_customizer()->add_field(
	array(
		'type'            => 'text',
		'id'              => 'thim_learnpress_timetable_link',
		'label'           => esc_html__( 'Timetable Link', 'eduma' ),
		'tooltip'         => esc_html__( 'Only use for Demo Kindergarten.', 'eduma' ),
		'section'         => 'course_features',
		'priority'        => 40,
		'active_callback' => array(
			array(
				'setting'  => 'thim_single_course_offline',
				'operator' => '===',
				'value'    => true,
			),
		),
	)
);

thim_customizer()->add_field(
	array(
		'id'       => 'thim_course_price_color',
		'type'     => 'color',
		'label'    => esc_html__( 'Course Price Color', 'eduma' ),
		'section'  => 'course_features',
		'priority' => 40,
		'default'  => '#f24c0a',
	)
);
//// Enable or Disable Login Popup when take this course
if ( class_exists( '\Thim_EL_Kit\Functions' ) ) {
	$loop_course_item = array( '' => esc_html__( 'Default', 'thim-elementor-kit' ) ) + \Thim_EL_Kit\Functions::instance()->get_pages_loop_item( 'lp_course' );
} else {
	$loop_course_item = array( '' => esc_html__( 'Default', 'thim-elementor-kit' ) );
}

thim_customizer()->add_field(
	array(
		'id'          => 'loop_course_item',
		'type'        => 'select',
		'label'       => esc_html__( 'Loop Course Item', 'eduma' ),
		'section'     => 'course_features',
		'description' => sprintf( __( 'You can build loop course item in %s.', 'eduma' ), '<a href="' . admin_url( 'edit.php?post_type=thim_elementor_kit&thim_elementor_type=loop_item' ) . '" target="_blank">' . __( 'Thim Elementor Kit', 'eduma' ) . '</a>' ),
		'priority'    => 50,
		'choices'     => $loop_course_item,
		'default'     => '',
	)
);
