<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_One_Course_Instructors extends Widget_Base {

	public function get_name() {
		return 'thim-one-course-instructors';
	}

	public function get_title() {
		return esc_html__( 'One Course Instructors', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-one-course-instructors';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content',
			[
				'label' => esc_html__( 'Instructor', 'eduma' )
			]
		);

		$this->add_control(
			'courses_id',
			[
				'label'   => esc_html__( 'Course ID', 'eduma' ),
				'type'    => Controls_Manager::TEXT,
				'default' => ! empty( get_theme_mod( 'thim_learnpress_one_course_id' ) ) ? get_theme_mod( 'thim_learnpress_one_course_id' ) : ''
			]
		);
		$this->add_control(
			'visible_item',
			[
				'label'   => esc_html__( 'Visible instructors', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'   => esc_html__( 'Show Pagination', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => true
			]
		);

		$this->add_control(
			'auto_play',
			[
				'label'   => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings
		) );
	}
}
