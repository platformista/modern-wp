<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Link extends Widget_Base {

	public function get_name() {
		return 'thim-link';
	}

	public function get_title() {
		return esc_html__( 'Link', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-link';
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-link';
	}
	public function show_in_panel() {
		return false;
	}
	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'link_item',
			[
				'label' => esc_html__( 'Link Item', 'eduma' )
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => esc_html__( 'Title on here', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);
		$this->add_control(
			'title_tag',
			array(
				'label'     => __( 'Title HTML Tag', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default'   => 'h4'
			)
		);
		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link of title', 'eduma' ),
				'description' => esc_html__( 'Leave empty to disable this field.', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '#'
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Add your a short description here', 'eduma' ),
				'label_block' => true
			]
		);
		$this->end_controls_section();
		$this->_register_style_title();
		$this->_register_style_desc();

	}
	protected function _register_style_title() {
		$this->start_controls_section(
			'section_style_link',
			[
				'label' => esc_html__( 'Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'link_typography',
				'selector'  => '{{WRAPPER}} .title',
			)
		);
		$this->add_control(
			'text-color',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'text-color-hover',
			[
				'label'     => esc_html__( 'Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'bg_bottom',
			[
				'label'     => esc_html__( 'Spacing', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}
	protected function _register_style_desc() {
		$this->start_controls_section(
			'section_style_desc',
			[
				'label' => esc_html__( 'Content', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'        => [
					'content!' => ''
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'desc_typography',
				'selector'  => '{{WRAPPER}} .desc',
			)
		);
		$this->add_control(
			'desc-color',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .desc' => 'color: {{VALUE}}',
				],
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
