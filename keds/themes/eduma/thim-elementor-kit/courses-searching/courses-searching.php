<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Courses_Searching extends Widget_Base {

	public function get_name() {
		return 'thim-courses-searching';
	}

	public function get_title() {
		return esc_html__( 'Courses Searching', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-courses-searching';
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-courses-searching';
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
				'label' => __( 'Thim: Courses Searching', 'eduma' )
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'    => esc_html__( 'Default', 'eduma' ),
					'overlay' => esc_html__( 'Icon Overlay', 'eduma' )
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Search Courses', 'eduma' ),
				'condition'   => [
					'layout' => [ 'base' ]
				]
			]
		);
		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Description for search course.', 'eduma' ),
				'label_block' => true,
				'condition'   => [
					'layout' => [ 'base' ]
				]
			]
		);
		$this->add_control(
			'placeholder',
			[
				'label'       => esc_html__( 'Placeholder Input', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'What do you want to learn today?', 'eduma' )
			]
		);
		$this->end_controls_section();

		// Setting
		$this->_register_style_setting_icon();
		$this->_register_style_setting_title();
		$this->_register_style_setting_description();

		$this->_register_style_setting_search_form();
		$this->_register_style_setting_search_result();
	}

	protected function _register_style_setting_icon() {

		$this->start_controls_section(
			'settings_style_icon_tabs',
			[
				'label'     => esc_html__( 'Icon', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => [ 'overlay' ]
				]
			]
		);

		$this->add_responsive_control(
			'settings_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_width',
			[
				'label'     => esc_html__( 'Width', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'width: {{SIZE}}px; height: {{SIZE}}px; line-height: {{SIZE}}px; text-align: center',
				],
			]
		);
		$this->add_responsive_control(
			'icon_font_size',
			[
				'label'     => esc_html__( 'Font Size', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'settings_icon_border',
			[
				'label'     => esc_html_x( 'Border Type', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'   => esc_html__( 'None', 'eduma' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'eduma' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'eduma' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'eduma' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'eduma' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'eduma' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_icon_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'settings_icon_border!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_color_settings_icon_style' );

		$this->start_controls_tab(
			'tab_color_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_icon_color',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'settings_icon_border!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_icon_color',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label'     => __( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_icon_color_hover',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'settings_icon_border!' => 'none'
				],
			]
		);

		$this->add_control(
			'bg_icon_color_hover',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius_icon',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-course-search-overlay .search-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	protected function _register_style_setting_title() {
		$this->start_controls_section(
			'heading_settings',
			[
				'label'     => esc_html__( 'Title', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => [ 'base' ]
				]
			]
		);
		$this->add_responsive_control(
			'title_space_right',
			[
				'label'      => esc_html__( 'Space', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .search-course-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-courses-searching .search-course-title',
			]
		);
		$this->add_control(
			'textcolor',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .search-course-title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function _register_style_setting_description() {
		$this->start_controls_section(
			'desc_settings',
			[
				'label'     => esc_html__( 'Description', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => [ 'base' ]
				]
			]
		);

		$this->add_responsive_control(
			'desc_space_right',
			[
				'label'      => esc_html__( 'Space', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .search-course-description' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-courses-searching .search-course-description',
			]
		);
		$this->add_control(
			'desc_textcolor',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .search-course-description' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function _register_style_setting_search_form() {
		$this->start_controls_section(
			'search_form_settings',
			[
				'label' => esc_html__( 'Search Form', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_control(
			'heading_input_style',
			[
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'Input', 'eduma' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input,{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input::placeholder',
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input,{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input::placeholder' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'input_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'input_border',
				'label'    => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input',
			]
		);
		$this->add_responsive_control(
			'input_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_button_submit_style',
			[
				'type'      => Controls_Manager::HEADING,
				'label'     => esc_html__( 'Button Search', 'eduma' ),
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'width_button_submit',
			[
				'label'      => esc_html__( 'Width Button', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'height_button_submit',
			[
				'label'      => esc_html__( 'Line Height', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button, {{WRAPPER}}.thim-widget-courses-searching .courses-searching .courses-search-input' => 'line-height: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'button_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_color_settings_button_submit_style' );

		$this->start_controls_tab(
			'tab_color_button_submit_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'button_submit_color',
			[
				'label'     => __( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_button_submit_color',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_submit_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'button_submit_color_hover',
			[
				'label'     => __( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_button_submit_color_hover',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _register_style_setting_search_result() {
		$this->start_controls_section(
			'search_result_settings',
			[
				'label' => esc_html__( 'Search Result', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'result_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-courses-searching .courses-searching ul.courses-list-search li a',
			]
		);

		$this->add_control(
			'result_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching ul.courses-list-search li a' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'result_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses-searching .courses-searching ul.courses-list-search' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$layout   = ( isset( $settings['layout'] ) && ! empty( $settings['layout'] ) ) ? $settings['layout'] : 'base';
		$layout   .= '-v3';

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings
		), $layout );
	}

}
