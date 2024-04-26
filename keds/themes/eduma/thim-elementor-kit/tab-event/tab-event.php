<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Tab_Event extends Widget_Base {

	public function get_name() {
		return 'thim-tab-event';
	}

	public function get_title() {
		return esc_html__( 'Tab Events', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-list-event';
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
				'label' => esc_html__( 'Tab Events', 'eduma' )
			]
		);
			$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Heading', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' )
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
						'{{WRAPPER}} .widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'heading_typography',
					'label'    => esc_html__( 'Typography', 'eduma' ),
					'selector' => '{{WRAPPER}} .widget-title',
				]
			);
			$this->add_control(
				'heading_color',
				[
					'label'     => esc_html__( 'Text Color', 'eduma' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .widget-title' => 'color: {{VALUE}};'
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'tabs_settings',
			[
				'label' => esc_html__( 'Tabs Settings', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tabs_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .list-tab-event .nav-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .list-tab-event .nav-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .list-tab-event .nav-tabs li a'
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
					'{{WRAPPER}} .list-tab-event .nav-tabs li a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_tabs_item_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .list-tab-event .nav-tabs li a' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}} .list-tab-event .nav-tabs li a,{{WRAPPER}} .list-tab-event .nav-tabs' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .list-tab-event .nav-tabs li.active a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_text_items_color_active',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .list-tab-event .nav-tabs li.active a' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}} .list-tab-event .nav-tabs li.active:before' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'item_settings',
			[
				'label' => esc_html__( 'Item Settings', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_date',
			array(
				'label'     => esc_html__( 'Date', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .time-from' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_title_item',
			array(
				'label'     => esc_html__( 'Title', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_item_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-list-event .event-wrapper .title',
			]
		);
		$this->add_responsive_control(
			'mg_bottom_title_item',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .title' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_title_item' );

		$this->start_controls_tab(
			'item_title_tabnormal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'title_item_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .title a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'item_title_tabnormal_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'title_item_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .title a:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'heading_meta_item',
			array(
				'label'     => esc_html__( 'Meta', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'font_size_meta_item',
			[
				'label'      => esc_html__( 'Font Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .meta' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'mg_bottom_meta_item',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .meta' => 'margin-bottom: {{SIZE}}px;',
				]
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .meta' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'heading_desc_item',
			array(
				'label'     => esc_html__( 'Description', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);
		$this->add_responsive_control(
			'font_size_desc_item',
			[
				'label'      => esc_html__( 'Font Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .description' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'mg_bottom_desc_item',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .description' => 'margin-bottom: {{SIZE}}px;',
				]
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .event-wrapper .description' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'heading_border',
			array(
				'label'     => esc_html__( 'Border', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .item-event'           => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .thim-list-event .event-wrapper:before' => 'background: {{VALUE}};'
				]
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
