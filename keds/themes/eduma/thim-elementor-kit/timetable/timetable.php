<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Timetable extends Widget_Base {

	public function get_name() {
		return 'thim-timetable';
	}

	public function get_title() {
		return esc_html__( 'Timetable', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-timetable';
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
				'label' => esc_html__( 'Timetable', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'panel_title',
			[
				'label'       => esc_html__( 'Course Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'panel_time',
			[
				'label'       => esc_html__( 'Time Activity', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'panel_teacher',
			[
				'label'       => esc_html__( 'Teacher Name', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'panel_location',
			[
				'label'       => esc_html__( 'Location', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true
			]
		);

		$repeater->add_control(
			'panel_background',
			[
				'label'       => esc_html__( 'Background Color', 'eduma' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => false,
				'separator'   => 'before'
			]
		);

		$repeater->add_control(
			'panel_background_hover',
			[
				'label'       => esc_html__( 'Background Hover Hover', 'eduma' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => false
			]
		);

		$repeater->add_control(
			'panel_color_style',
			[
				'label'   => esc_html__( 'Color Style', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'light'    => esc_html__( 'Light', 'eduma' ),
					'dark'     => esc_html__( 'Dark', 'eduma' ),
					'category' => esc_html__( 'Gray', 'eduma' )
				],
				'default' => 'light'
			]
		);

		$this->add_control(
			'panel',
			[
				'label'       => esc_html__( 'Panel List', 'eduma' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ panel_title }}}',
				'separator'   => 'before'
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_settings',
			[
				'label' => esc_html__( 'Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding Item', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-timetable .widget-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'type_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-widget-timetable .widget-title',
			]
		);
		$this->add_control(
			'bg_title_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-widget-timetable .widget-title' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-widget-timetable .widget-title' => 'color: {{VALUE}};'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'item_settings',
			[
				'label' => esc_html__( 'Item', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding Item', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_course_title',
			array(
				'label'     => esc_html__( 'Course Title', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'course_title_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-widget-timetable .timetable-item .title',
			]
		);
		$this->add_responsive_control(
			'mg_bottom_course_title',
			[
				'label'      => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
 				'selectors'  => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item .title' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'heading_time_activity',
			array(
				'label'     => esc_html__( 'Time Activity', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'font_size_time',
			[
				'label'      => esc_html__( 'Font Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item .time' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_bottom_time',
			[
				'label'      => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
 				'selectors'  => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item .time' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'heading_teacher_name',
			array(
				'label'     => esc_html__( 'Teacher Name', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'font_size_teacher_name',
			[
				'label'     => esc_html__( 'Font Size', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item .teacher' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_bottom_teacher_name',
			[
				'label'     => esc_html__( 'Margin Bottom  (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item .teacher' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'heading_location',
			array(
				'label'     => esc_html__( 'Location', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'font_size_location',
			[
				'label'     => esc_html__( 'Font Size', 'eduma' ),
				'size_units' => [ 'px', 'em', '%' ],
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item .location' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_bottom_location',
			[
				'label'     => esc_html__( 'Margin Bottom  (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-widget-timetable .timetable-item .location' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		$settings             = $this->get_settings_for_display();
		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings,
			'args'     => $args
		) );
	}

}
