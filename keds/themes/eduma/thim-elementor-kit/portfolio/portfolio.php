<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Portfolio extends Widget_Base {

	public function get_name() {
		return 'thim-portfolio';
	}

	public function get_title() {
		return esc_html__( 'Portfolio', 'eduma' );
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-portfolio';
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-portfolio';
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
				'label' => esc_html__( 'Portfolio', 'eduma' )
			]
		);

		$this->add_control(
			'portfolio_category',
			[
				'label'   => esc_html__( 'Select Category', 'eduma' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => thim_get_cat_taxonomy( 'portfolio_category', array( 'all' => esc_html__( 'All', 'eduma' ) ) ),
				'default' => 'all'
			]
		);

		$this->add_control(
			'filter_hiden',
			[
				'label'     => esc_html__( 'Filter', 'eduma' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'eduma' ),
				'label_off' => esc_html__( 'Hide', 'eduma' )
			]
		);
		$this->add_responsive_control(
			'filter_position',
			[
				'label'     => esc_html__( 'Filter Position', 'eduma' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
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
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .portfolio-tabs-wapper.filters' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'filter_hiden' => 'yes'
				]
			]
		);
		$this->add_control(
			'column',
			[
				'label'   => esc_html__( 'Column', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'one'   => esc_html__( '1', 'eduma' ),
					'two'   => esc_html__( '2', 'eduma' ),
					'three' => esc_html__( '3', 'eduma' ),
					'four'  => esc_html__( '4', 'eduma' ),
					'five'  => esc_html__( '5', 'eduma' )
				],
				'default' => 'three'
			]
		);
		$this->add_control(
			'num_per_view',
			[
				'label'       => esc_html__( 'Enter a number view', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false
			]
		);

		$this->add_control(
			'gutter',
			[
				'label'   => esc_html__( 'Gutter', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'item_size',
			[
				'label'   => esc_html__( 'Item Size', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'multigrid' => esc_html__( 'Multigrid', 'eduma' ),
					'masonry'   => esc_html__( 'Masonry', 'eduma' ),
					'same'      => esc_html__( 'Same size', 'eduma' )
				],
				'default' => 'masonry'
			]
		);

		$this->add_control(
			'paging',
			[
				'label'   => esc_html__( 'Paging', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'all'             => esc_html__( 'Show All', 'eduma' ),
					'limit'           => esc_html__( 'Limit Items', 'eduma' ),
					'paging'          => esc_html__( 'Paging', 'eduma' ),
					'infinite_scroll' => esc_html__( 'Infinite Scroll', 'eduma' )
				],
				'default' => 'all'
			]
		);

		$this->add_control(
			'style-item',
			[
				'label'   => esc_html__( 'Item Style', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'style01' => esc_html__( 'Caption Hover Effects 01', 'eduma' ),
					'style02' => esc_html__( 'Caption Hover Effects 02', 'eduma' ),
					'style03' => esc_html__( 'Caption Hover Effects 03', 'eduma' ),
					'style04' => esc_html__( 'Caption Hover Effects 04', 'eduma' ),
					'style05' => esc_html__( 'Caption Hover Effects 05', 'eduma' ),
					'style06' => esc_html__( 'Caption Hover Effects 06', 'eduma' ),
					'style07' => esc_html__( 'Caption Hover Effects 07', 'eduma' ),
					'style08' => esc_html__( 'Caption Hover Effects 08', 'eduma' ),
					'style09' => esc_html__( 'Caption Hover Effects 09', 'eduma' ),
				],
				'default' => 'style01'
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'     => esc_html__( 'Show Read More?', 'eduma' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'paging' => [ 'all', 'limit' ]
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filter_options',
			[
				'label'     => esc_html__( 'Filter', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'filter_hiden' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'filter_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wapper_portfolio .filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'filter_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .wapper_portfolio .filters .portfolio-tabs a.filter'
			]
		);
		$this->start_controls_tabs( 'tabs_filter' );

		$this->start_controls_tab(
			'filter_tabnormal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio .filters .portfolio-tabs a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_filter_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .wapper_portfolio .filters .portfolio-tabs a.active, {{WRAPPER}} .wapper_portfolio .filters .portfolio-tabs a:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'border_hover_color',
			[
				'label'     => esc_html__( 'Border Button Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio .filters .portfolio-tabs a.active, {{WRAPPER}} .wapper_portfolio .filters .portfolio-tabs a:hover' => 'border-color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'read_options',
			[
				'label'     => esc_html__( 'Read More', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_readmore' => 'yes'
				]
			]
		);


		$this->add_responsive_control(
			'read_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wapper_portfolio .read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'read_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .wapper_portfolio .read-more .thim-button'
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_read_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_read_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button:hover' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .wapper_portfolio .read-more .thim-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'style_new9_options',
			[
				'label'     => esc_html__( 'Content', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style-item' => 'style09'
				]
			]
		);

		$this->add_control(
			'bg_hover_overlay_color',
			[
				'label'     => esc_html__( 'Background Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .img-portfolio::before' => 'background-color: {{VALUE}};'
				]
			]
		);

		
		$this->add_control(
			'bg_centent_color',
			[
				'label'     => esc_html__( 'Content Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover' => 'background-color: {{VALUE}} !important;'
				],
			]
		);

		$this->add_responsive_control(
			'content_padding_style',
			[
				'label'      => esc_html__( 'Padding Content', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}  .wapper_portfolio.style09 .portfolio-hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'   => 'after',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography Title', 'eduma' ),
				'selector' => '{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover .thumb-bg h3 a',
			]
		);

		$this->add_control(
			'title_color_style',
			[
				'label'     => esc_html__( 'Title Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover .thumb-bg h3 a' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'title_color_style_hover',
			[
				'label'     => esc_html__( 'Title Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover .thumb-bg h3 a:hover' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'title_margin_style',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}  .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'   => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_cat_typography',
				'label'    => esc_html__( 'Typography Category', 'eduma' ),
				'selector' => '{{WRAPPER}}  .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .cat_portfolio',
			]
		);

		$this->add_control(
			'cat_color_style',
			[
				'label'     => esc_html__( 'Category Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .cat_portfolio a' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'cat_color_style_hover',
			[
				'label'     => esc_html__( 'Category Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .cat_portfolio a:hover' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'cat_margin_style',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}  .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .cat_portfolio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'   => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_description_typography',
				'label'    => esc_html__( 'Typography Description', 'eduma' ),
				'selector' => '{{WRAPPER}}  .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .description',
			]
		);

		$this->add_control(
			'description_color_style',
			[
				'label'     => esc_html__( 'Description Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .description' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'line_description',
			[
				'label'   => esc_html__( 'Line', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 10,
				'step'    => 1,
				'selectors' => [
					'{{WRAPPER}} .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .description' => '-webkit-line-clamp: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'description_margin_style',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}  .wapper_portfolio.style09 .portfolio-hover .thumb-bg .mask-content .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		// fix options hiden filter
		if ( $settings['filter_hiden'] == 'yes' ) {
			$settings['filter_hiden'] = false;
		} else {
			$settings['filter_hiden'] = true;
		}
		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings
		) );
	}
}
