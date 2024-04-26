<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Courses_Collection extends Widget_Base {

	public function get_name() {
		return 'thim-courses-collection';
	}

	public function get_title() {
		return esc_html__( 'Courses Collection!', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-courses-collection';
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
				'label' => __( 'Courses collection', 'eduma' )
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'   => esc_html__( 'Default', 'eduma' ),
					'slider' => esc_html__( 'Slider', 'eduma' )
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit collections', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns', 'eduma' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'1' => esc_html__( '1', 'eduma' ),
					'2' => esc_html__( '2', 'eduma' ),
					'3' => esc_html__( '3', 'eduma' ),
					'4' => esc_html__( '4', 'eduma' )
				],
				'default'     => '4'
			]
		);

		$this->add_control(
			'feature_items',
			[
				'label'       => esc_html__( 'Feature Items', 'eduma' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'1' => esc_html__( '1', 'eduma' ),
					'2' => esc_html__( '2', 'eduma' ),
					'3' => esc_html__( '3', 'eduma' ),
					'4' => esc_html__( '4', 'eduma' )
				],
				'default'     => '2',
				'condition'   => [
					'layout' => [ 'base' ]
				]
			]
		);
		$this->end_controls_section();

		$this->_register_style_title();

	}

	protected function _register_style_title() {
		$this->start_controls_section(
			'title_settings',
			[
				'label' => esc_html__( 'Style Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'condition'  => [
					'layout' => 'slider'
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-courses-collection .thim-collection-carousel .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'condition'  => [
					'layout' => 'base'
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-courses-collection .item .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-courses-collection .item .title',
			]
		);

		$this->add_control(
			'bg_title_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'layout' => 'base'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-courses-collection .item .title' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-courses-collection .item .title' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'bg_overlay_setting',
			[
				'label' => esc_html__( 'Setting', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'border-radius',
			[
				'label'      => esc_html__( 'Border Ratius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
 				'selectors'  => [
					'{{WRAPPER}} .thim-courses-collection .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'bg_overlay_label',
			array(
				'label'     => esc_html__( 'Overlay', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'thumb_overlay',
				'label'    => esc_html__( 'Background', 'eduma' ),
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .thim-courses-collection .thumbnail .feature-image:after',
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
