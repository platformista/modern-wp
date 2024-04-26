<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Twitter extends Widget_Base {

	public function get_name() {
		return 'thim-twitter';
	}

	public function get_title() {
		return esc_html__( 'Twitter', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-twitter';
	}
	protected function get_html_wrapper_class() {
		return 'thim-widget-twitter';
	}
	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}


	protected function register_controls() {
		$this->start_controls_section(
			'twitter-item',
			[
				'label' => esc_html__( 'Twitter', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'   => esc_html__( 'Default', 'eduma' ),
					'slider' => esc_html__( 'Slider', 'eduma' ),
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'username',
			[
				'label'       => esc_html__( 'Username', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => 'press_thim'
			]
		);

		$this->add_control(
			'display',
			[
				'label'       => esc_html__( 'Tweets Display', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'default'     => '1'
			]
		);
		$this->add_control(
			'alignment',
			[
				'label'   => esc_html__( 'Alignment', 'eduma' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'eduma' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-text-align-right',
					]
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .twitter-inner,{{WRAPPER}} .thim-twitter-slider' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'heading_settings',
			[
				'label' => esc_html__( 'Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-twitter .widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-twitter .widget-title',
			]
		);
		$this->add_control(
			'textcolor',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-twitter .widget-title' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'icon_title_color',
			[
				'label'     => esc_html__( 'icon Title Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-twitter .widget-title i' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings,
			'args'     => $args
		), $settings['layout'] );

	}

}
