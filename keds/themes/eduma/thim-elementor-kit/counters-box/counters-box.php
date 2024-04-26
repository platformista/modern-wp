<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Counters_Box extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'thim-counters-box';
	}

	public function get_title() {
		return esc_html__( 'Counters Box', 'eduma' );
	}
	protected function get_html_wrapper_class() {
		return 'thim-counters-box';
	}
	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-counters-box';
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
				'label' => esc_html__( 'Counters Box', 'eduma' )
			]
		);

		$this->add_control(
			'counters_label',
			[
				'label'       => esc_html__( 'Counters Label', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'counters_value',
			[
				'label'   => esc_html__( 'Counters Value', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 20,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'text_number',
			[
				'label'       => esc_html__( 'Text Number', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true,
				'condition'   => [
					'style!' => 'number-left'
				]
			]
		);

		$this->add_control(
			'view_more_text',
			[
				'label'       => esc_html__( 'View More Text', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'view_more_link',
			[
				'label'         => esc_html__( 'View More Link', 'eduma' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'eduma' ),
				'show_external' => false,
				'default'       => [
					'url' => ''
				]
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Counter Style', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					"home-page"    => esc_html__( "Default", 'eduma' ),
					//					"about-us"      => esc_html__( "Style About Us", 'eduma' ),
					"number-left"  => esc_html__( "Number Left", 'eduma' ),
					//					"text-gradient" => esc_html__( "Text Gradient", 'eduma' ),
					"demo-elegant" => esc_html__( "Icon Is Background", 'eduma' )
				],
				'default' => 'home-page'
			]
		);

		$this->end_controls_section();

		$this->register_style_sc();
		$this->register_style_icons();
		//		$this->register_border_sc();

	}

	protected function register_style_sc() {
		$this->start_controls_section(
			'style-tab',
			[
				'label' => esc_html__( 'Style', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'width_colum_number',
			[
				'label'      => esc_html__( 'Width Left Column', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .counter-box.number-left .wrap-percentage' => 'width: {{SIZE}}{{UNIT}};',
				],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 50,
					],
				],
 				'condition'  => [
					'style' => 'number-left'
				]
			]
		);
		$this->add_responsive_control(
			'padding_left_colum_number',
			[
				'label'      => esc_html__( 'Padding Left Column', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
 				'condition'  => [
					'style' => 'number-left'
				],
				'selectors'  => [
					'{{WRAPPER}} .counter-box.number-left .wrap-percentage' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'padding_right_colum_number',
			[
				'label'      => esc_html__( 'Padding right Column', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
 				'condition'  => [
					'style' => 'number-left'
				],
				'selectors'  => [
					'{{WRAPPER}} .counter-box.number-left .counter-content-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_number_color',
			[
				'label'     => esc_html__( 'Border Number Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box.number-left .counter-content-container' => 'border-left-color: {{VALUE}};',
				],
				'condition' => [
					'style' => 'number-left'
				]
			]
		);

		$this->add_control(
			'heading_counters_label',
			array(
				'label'     => esc_html__( 'Counters Label', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counters_label_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .counter-box .counter-box-content',
			]
		);
		$this->add_responsive_control(
			'mg_counter_label',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .counter-box .counter-box-content' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'counter_label_color_type',
			[
				'label'       => esc_html__( 'Color Type', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'classic'  => [
						'title' => _x( 'Classic', 'Background Control', 'eduma' ),
						'icon'  => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => _x( 'Gradient', 'Background Control', 'eduma' ),
						'icon'  => 'eicon-barcode',
					],
				],
				'default'     => 'classic',
				'toggle'      => false,
				'label_block' => false
			]
		);

		$this->add_control(
			'counter_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .counter-box-content' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'counter_label_color_b',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .counter-box-content' => 'background: -webkit-linear-gradient({{counter_label_color.VALUE}}, {{VALUE}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition' => [
					'counter_label_color_type' => [ 'gradient' ],
				],
			]
		);
		$this->add_control(
			'heading_counters_value',
			array(
				'label'     => esc_html__( 'Counters Value', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counters_value_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .counter-box .display-percentage',
			]
		);

		$this->add_responsive_control(
			'mg_counter_value',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .counter-box .display-percentage' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'color_value_type',
			[
				'label'       => esc_html__( 'Color Type', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'classic'  => [
						'title' => _x( 'Classic', 'Background Control', 'eduma' ),
						'icon'  => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => _x( 'Gradient', 'Background Control', 'eduma' ),
						'icon'  => 'eicon-barcode',
					],
				],
				'default'     => 'classic',
				'toggle'      => false,
				'label_block' => false
			]
		);

		$this->add_control(
			'counter_value_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .display-percentage' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'counter_value_color_b',
			[
				'label'     => esc_html__( 'Text Second Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .display-percentage' => 'background: -webkit-linear-gradient({{counter_value_color.VALUE}}, {{VALUE}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition' => [
					'color_value_type' => [ 'gradient' ],
				],
				'of_type'   => 'gradient',
			]
		);


		$this->add_control(
			'heading_text_number',
			array(
				'label'     => esc_html__( 'Text Number', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'style!' => 'number-left'
				]
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'text_number_typography',
				'label'     => esc_html__( 'Typography', 'eduma' ),
				'selector'  => '{{WRAPPER}} .counter-box .text_number',
				'condition' => [
					'style!' => 'number-left'
				]
			]
		);

		$this->add_responsive_control(
			'mg_text_number',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .counter-box .text_number' => 'margin-bottom: {{SIZE}}px;',
				],
				'condition' => [
					'style!' => 'number-left'
				]
			]
		);
		$this->add_control(
			'text_color_type',
			[
				'label'       => esc_html__( 'Color Type', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'classic'  => [
						'title' => _x( 'Classic', 'Background Control', 'eduma' ),
						'icon'  => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => _x( 'Gradient', 'Background Control', 'eduma' ),
						'icon'  => 'eicon-barcode',
					],
				],
				'default'     => 'classic',
				'toggle'      => false,
				'label_block' => false,
				'condition'   => [
					'style!' => 'number-left'
				]
			]
		);
		$this->add_control(
			'text_number_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .text_number' => 'color: {{VALUE}};',
				],
				'condition' => [
					'style!' => 'number-left'
				]
			]
		);
		$this->add_control(
			'text_number_color_b',
			[
				'label'     => esc_html__( 'Text Second Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .text_number' => 'background: -webkit-linear-gradient({{text_number_color.VALUE}}, {{VALUE}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition' => [
					'style!'          => 'number-left',
					'text_color_type' => 'gradient',
				],
				'of_type'   => 'gradient',
			]
		);

		$this->add_control(
			'heading_view_more',
			array(
				'label'     => esc_html__( 'View More', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'view_more_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .counter-box .view-more'
			]
		);

		$this->add_responsive_control(
			'mg_view_more',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .counter-box .view-more' => 'margin-bottom: {{SIZE}}px; display: inherit;',
				]
			]
		);
		$this->add_control(
			'view_more_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .counter-box .view-more' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'view_more_color_hover',
			[
				'label'     => esc_html__( 'Text Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .counter-box .view-more:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();


	}

	protected function register_border_sc() {
		$this->start_controls_section(
			'border_style_tabs',
			[
				'label' => esc_html__( 'Border', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .counter-box' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .counter-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'xs_tabs_button_border_style' );
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html_x( 'Color', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .counter-box' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'border_radius',
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
					'{{WRAPPER}} .counter-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_sc_border_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);
		$this->add_control(
			'hover_border_color',
			[
				'label'     => esc_html_x( 'Color', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .counter-box:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'border_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .counter-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_icons() {
		$this->start_controls_section(
			'icon_group',
			[
				'label'     => __( 'Icon', 'eduma' ),
				'condition' => [
					'style!' => 'number-left'
				]
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'   => __( 'Icon', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					"font-awesome"  => esc_html__( "Font Awesome Icon", 'eduma' ),
					"font-7-stroke" => esc_html__( "Font 7 stroke Icon", 'eduma' ),
					"font-flaticon" => esc_html__( "Font Flat Icon", 'eduma' ),
					"custom"        => esc_html__( "Custom Image", 'eduma' )
				],
				'default' => 'font-awesome'
			]
		);
		$this->add_control(
			'icons',
			[
				'label'            => esc_html__( 'Select Icon:', 'eduma' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block'       => false,
				'skin'             => 'inline',
				'condition'   => [
					'icon_type' => [ 'font-awesome' ]
				]
			]
		);


		$this->add_control(
			'icon_flat',
			[
				'label'       => esc_html__( 'Select Icon:', 'eduma' ),
				'type'        => Controls_Manager::ICON,
				'placeholder' => esc_html__( 'Choose...', 'eduma' ),
				'options'     => apply_filters( 'thim-builder-el-flat_icon-icon', array() ),
				'exclude'     => array_keys( Control_Icon::get_icons() ),
				'condition'   => [
					'icon_type' => [ 'font-flaticon' ]
				]
			]
		);

		$this->add_control(
			'icon_stroke',
			[
				'label'       => esc_html__( 'Select Icon:', 'eduma' ),
				'type'        => Controls_Manager::ICON,
				'placeholder' => esc_html__( 'Choose...', 'eduma' ),
				'options'     => apply_filters( 'thim-builder-el-stroke_icon-icon', array() ),
				'exclude'     => array_keys( Control_Icon::get_icons() ),
				'condition'   => [
					'icon_type' => [ 'font-7-stroke' ]
				]
			]
		);

		$this->add_control(
			'icon_img',
			[
				'label'     => esc_html__( 'Choose Image', 'eduma' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => '',
				],
				'condition' => [
					'icon_type' => [ 'custom' ]
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'color: {{VALUE}};',
				],
				'condition' => [
					'icon_type!' => [ 'custom' ]
				]
			]
		);

		$this->add_responsive_control(
			'font_size_icon',
			[
				'label'      => esc_html__( 'Font Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'separator'  => 'before',
				'condition'  => [
					'icon_type!' => [ 'custom' ]
				]
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'     => esc_html__( 'Icon Position', 'eduma' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-h-align-left',
					],
					'inherit' => [
						'title' => esc_html__( 'Top', 'eduma' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'inherit',
				'selectors' => [
					'{{WRAPPER}} .counter-box .content-box-percentage'                            => 'float: {{VAULE}}; text-align: {{VAULE}};',
					'{{WRAPPER}} .counter-box .icon-counter-box'                                  => 'float: {{VAULE}};',
					'(mobile){{WRAPPER}} .counter-box .icon-counter-box,
					(mobile){{WRAPPER}} .counter-box .content-box-percentage' => 'float: none; text-align: center',
				],
				'condition' => [
					'style' => 'home-page'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_setting',
			[
				'label'     => esc_html__( 'Icon', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => 'home-page'
				]
			]
		);

		$this->add_responsive_control(
			'width_icon',
			[
				'label'      => esc_html__( 'Width Icon (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .counter-box .icon-counter-box'                                  => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .counter-box:not(.counter-icon-inherit) .content-box-percentage' => 'width: calc(100% - {{icon_margin.RIGHT}}{{UNIT}} - {{icon_margin.LEFT}}{{UNIT}} - {{SIZE}}px);',
					'(mobile){{WRAPPER}} .counter-box .content-box-percentage'                    => 'width: 100%',
				],
			]
		);

		$this->add_responsive_control(
			'height_icon',
			[
				'label'      => esc_html__( 'Height Icon (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'height: {{SIZE}}px; line-height: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'icon_border_style',
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
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'icon_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_color_icon_border_style' );

		$this->start_controls_tab(
			'tab_color_color_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'icon_border_color',
			[
				'label'     => esc_html__( 'Border Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'     => esc_html__( 'Background Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .counter-box .icon-counter-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_color_icon_border_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .icon-counter-box:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'icon_type!' => [ 'custom' ]
				]
			]
		);

		$this->add_control(
			'icon_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .icon-counter-box:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .counter-box .icon-counter-box:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_icon_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .counter-box .icon-counter-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		wp_enqueue_script( 'waypoints' );
		wp_enqueue_script( 'thim-CountTo' );
		$text_number = isset( $settings['text_number'] ) && $settings['text_number'] ? '<div class="text_number">' . $settings['text_number'] . '</div>' : '';
		$class       = isset( $settings['style'] ) ? ' ' . $settings['style'] : '';
		$class       .= isset( $settings['style'] ) && $settings['style'] == 'home-page' ? ' counter-icon-' . $settings['icon_align'] : '';
		/* end show icon or custom icon */
		echo '<div class="counter-box' . $class . '">';
		/* show icon or custom icon */
		if ( $settings['icon_type'] == 'font-awesome' ) {
			// Icon
				// new icon
			$icon = '';
			$migrated = isset( $settings['__fa4_migrated']['icons'] );
				// Check if its a new widget without previously selected icon using the old Icon control
			$is_new = empty( $settings['icon'] );
			if ( $is_new || $migrated ) {
					// new icon
					ob_start();
					Icons_Manager::render_icon( $settings['icons'], [ 'aria-hidden' => 'true' ] );
					$icon = ob_get_contents();
					ob_end_clean();
				} else {
					if ( isset( $settings['icon'] ) ) {
						if ( strpos( $settings['icon'], 'fa' ) !== false ) {
							$icon = '<i class="' . $settings['icon'] . '"></i> ';
						} else {
							$icon = '<i class="fa fa-' . $settings['icon'] . '"></i> ';
						}
					}
				}
			if($icon){
				echo '<div class="icon-counter-box">'.$icon .'</div>';
			}

		} else if ( $settings['icon_type'] == 'font-7-stroke' && $settings['icon_stroke'] ) {
			wp_enqueue_style('font-pe-icon-7');
			echo '<div class="icon-counter-box"><i class="' . $settings['icon_stroke'] . '"></i></div>';
		} else if ( $settings['icon_type'] == 'font-flaticon' && $settings['icon_flat'] ) {
			wp_enqueue_style('flaticon');
			echo '<div class="icon-counter-box"><i class="' . $settings['icon_flat'] . '"></i></div>';
		} else {
			if ( isset( $settings['icon_img'] ) && $settings['icon_img']['id'] ) {
				echo '<div class="icon-counter-box"><span class="icon icon-images">' . wp_get_attachment_image( $settings['icon_img']['id'], 'full' ) . '</span></div>';
			}
		}
		$counters_label = isset( $settings['counters_label'] ) && $settings['counters_label'] ? '<div class="counter-box-content">' . $settings['counters_label'] . '</div>' : '';
		if ( isset ( $settings['view_more_text'] ) && $settings['view_more_text'] ) {
			if ( isset( $settings['view_more_link'] ) && ! empty( $settings['view_more_link']['url'] ) ) {
				$this->add_link_attributes( 'button_view_more', $settings['view_more_link'] );
			}
			$counters_label .= '<a class="view-more" ' . $this->get_render_attribute_string( 'button_view_more' ) . '>' . $settings['view_more_text'] . ' <i class="fa fa-chevron-right"></i></a>';
		}

		if ( isset( $settings['counters_value'] ) && $settings['counters_value'] ) {
			echo '<div class="content-box-percentage"><div class="wrap-percentage">
					<div class="display-percentage" data-percentage="' . esc_attr( $settings['counters_value'] ) . '">' . esc_attr( $settings['counters_value'] ) . '</div>' . $text_number . '</div>';
			echo '<div class="counter-content-container">' . $counters_label . '</div></div>';
		}

		echo '</div>';


	}

}
