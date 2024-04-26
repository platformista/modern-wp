<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Tab extends Widget_Base {

	public function get_name() {
		return 'thim-tab';
	}

	public function get_title() {
		return esc_html__( 'Tab', 'eduma' );
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-tab template-tab';
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-tab-event';
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
				'label' => esc_html__( 'Tabs', 'eduma' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base' => esc_html__( 'Default', 'eduma' ),
					'step' => esc_html__( 'Step', 'eduma' )
				],
				'default' => 'base'
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Tab Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$repeater->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);
		$repeater->add_control(
			'bg_title',
			[
				'label'       => esc_html__( 'Background Title', 'eduma' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select the color background for title. (for Layout Step)', 'eduma' ),
			]
		);
		$repeater->add_control(
			'text_button',
			[
				'label'       => esc_html__( 'Text Button', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true
			]
		);
		$repeater->add_control(
			'link',
			[
				'label'         => esc_html__( 'Link', 'eduma' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'eduma' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'tab',
			[
				'label'       => esc_html__( 'Tab List', 'eduma' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'separator'   => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tab_settings',
			[
				'label'     => esc_html__( 'Tabs Settings', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'default'
				],
			]
		);


		$this->add_responsive_control(
			'text_tab_padding',
			[
				'label'      => esc_html__( 'Padding item', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-tab .nav-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-tab .nav-tabs li a'
			]
		);
		$this->start_controls_tabs( 'tabs_tab_item' );
		$this->start_controls_tab(
			'tabs_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);
		$this->add_control(
			'tabs_item_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .nav-tabs li a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_tabs_item_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .nav-tabs li a' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'border_tabs_item_color',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .nav-tabs li a,{{WRAPPER}}.thim-widget-tab .nav-tabs,{{WRAPPER}}.thim-widget-tab .tab-content' => 'border-color: {{VALUE}};'
				]
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_item_active',
			[
				'label' => esc_html__( 'Active', 'eduma' ),
			]
		);
		$this->add_control(
			'text_items_color_active',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .nav-tabs li.active a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_text_items_color_active',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .nav-tabs li.active a' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'border_text_items_color_active',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .nav-tabs li.active:before' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'tab_step_settings',
			[
				'label'     => esc_html__( 'Tabs Settings', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'step'
				],
			]
		);
		$this->add_responsive_control(
			'font_size_number_step',
			[
				'label'      => esc_html__( 'Font Size Number', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-tab .thim-widget-step ul li a strong' => 'font-size: {{SIZE}}{{UNIT}};',
				],

			]
		);
		$this->add_responsive_control(
			'font_size_text_step',
			[
				'label'      => esc_html__( 'Font Size Text', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-tab .thim-widget-step ul li a' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'with_step',
			[
				'label'     => esc_html__( 'Width (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 20,
						'max' => 500,
					]
				],
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .thim-widget-step ul li a' => 'width: {{SIZE}}px;',
					'{{WRAPPER}}.thim-widget-tab .thim-widget-step ul li:after' => 'width: calc( 100% - 22px - {{SIZE}}px);',
				]
			]
		);
		$this->add_responsive_control(
			'text_tab_step_padding',
			[
				'label'      => esc_html__( 'Padding item', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-tab .thim-widget-step ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'border_step_color',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .thim-widget-step ul li:after' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'content_tab_settings',
			[
				'label' => esc_html__( 'Content Tabs Settings', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'text_content_tab_padding',
			[
				'label'      => esc_html__( 'Padding item', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-tab .tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_tab_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-tab .tab-content,{{WRAPPER}} .thim-widget-step .tab-content-step .tab-pane'
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'read_options',
			[
				'label' => esc_html__( 'Read More', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'read_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'read_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-tab .tab-pane .readmore'
			]
		);
		$this->add_responsive_control(
			'border_style',
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
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_read' );

		$this->start_controls_tab(
			'read_tabnormal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'text_read_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_read_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'border_read_color',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'border_style!' => 'none'
				],
			]
		);
		$this->add_responsive_control(
			'border_read_radius',
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
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_read_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'text_read_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_read_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore:hover' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'border_read_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'border_style!' => 'none'
				],
			]
		);
		$this->add_responsive_control(
			'border_read_radius_hover',
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
					'{{WRAPPER}}.thim-widget-tab .tab-pane .readmore:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings
		), $settings['layout'] );
	}
}
