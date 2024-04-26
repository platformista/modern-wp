<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Course_Categories extends Widget_Base {

	public function get_name() {
		return 'thim-course-categories';
	}

	public function get_title() {
		return esc_html__( 'Course Categories', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-course-categories';
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-course-categories thim-ekits-course-category';
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
				'label' => __( 'Course Categories', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'slider'     => esc_html__( 'Slider', 'eduma' ),
					'base'       => esc_html__( 'List Categories', 'eduma' ),
					'tab-slider' => esc_html__( 'Tab Slider', 'eduma' ),
					'grid'       => esc_html__( 'Grid', 'eduma' ),
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'use_img_icon',
			[
				'label'     => esc_html__( 'Use Icon or Image', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none' => esc_html__( 'None', 'eduma' ),
					'icon' => esc_html__( 'Icon', 'eduma' ),
					'img'  => esc_html__( 'Image', 'eduma' ),
				],
				'default'   => 'none',
				'condition' => array(
					'layout' => [ 'grid', 'base' ]
				)
			]
		);

		$this->add_control(
			'image_size',
			[
				'label'       => esc_html__( 'Image size', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter image size. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use default size.', 'eduma' ),
				'condition'   => array(
					'layout' => [ 'slider', 'grid', 'base' ],
				)
			]
		);

		$this->add_control(
			'limit',
			[
				'label'     => esc_html__( 'Limit categories', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 15,
				'min'       => 1,
				'step'      => 1,
				'condition' => array(
					'layout' => [ 'base', 'slider', 'tab-slider' ]
				)
			]
		);
		$this->add_control(
			'sub_categories',
			[
				'label'        => esc_html__( 'Show sub categories', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'click_show_sub',
			[
				'label'     => __( 'Click Show Sub', 'eduma' ),
				'type'      => Controls_Manager::SWITCHER,
				'options'   => [
					true  => __( 'Yes', 'eduma' ),
					false => __( 'No', 'eduma' ),
				],
				'default'   => false,
				'condition' => array(
					'sub_categories' => [ 'yes' ],
					'layout'         => [ 'base' ],
				)
			]
		);
		$this->add_control(
			'count_course',
			[
				'label'        => esc_html__( 'Show Count Course', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'layout' => [ 'grid' ]
				)
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'        => esc_html__( 'Show Pagination?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'layout' => [ 'slider', 'tab-slider' ]
				)
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'        => esc_html__( 'Show Navigation?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'layout' => [ 'slider', 'tab-slider' ]
				)
			]
		);

		$this->add_control(
			'item_visible',
			[
				'label'     => esc_html__( 'Items Visible', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 8,
						'step' => 1
					]
				],
				'default'   => [
					'unit' => 'px',
					'size' => 7,
				],
				'condition' => array(
					'layout' => [ 'slider', 'tab-slider' ]
				)
			]
		);

		$this->add_control(
			'auto_play',
			[
				'label'       => esc_html__( 'Auto play speed (in ms)', 'eduma' ),
				'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'min'         => 0,
				'step'        => 100,
				'condition'   => array(
					'layout' => [ 'slider', 'tab-slider' ]
				)
			]
		);

		$this->add_control(
			'list-options',
			[
				'label'     => esc_html__( 'List Categories Layout Options', 'eduma' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'layout' => [ 'base' ]
				)
			]
		);

		$this->add_control(
			'show_counts',
			[
				'label'     => esc_html__( 'Show Course Count?', 'eduma' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'layout' => [ 'base' ]
				)
			]
		);
		$this->add_control(
			'format_count',
			[
				'label'       => esc_html__( 'Format Course Count', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '(%s)',
				'label_block' => true,
				'condition'   => array(
					'layout'      => [ 'base' ],
					'show_counts' => [ 'yes' ]
				)
			]
		);

		$this->add_control(
			'hierarchical',
			[
				'label'     => esc_html__( 'Show hierarchy?', 'eduma' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'layout' => [ 'base' ]
				)
			]
		);

		$this->add_control(
			'grid-options',
			[
				'label'     => esc_html__( 'Grid Layout Options', 'eduma' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'layout' => [ 'grid' ]
				)
			]
		);

		$this->add_control(
			'grid_limit',
			[
				'label'     => esc_html__( 'Limit categories', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'min'       => 1,
				'step'      => 1,
				'condition' => array(
					'layout' => [ 'grid' ]
				)
			]
		);

		$this->add_responsive_control(
			'grid_column',
			[
				'label'     => esc_html__( 'Number Column', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'1' => esc_html__( '1', 'eduma' ),
					'2' => esc_html__( '2', 'eduma' ),
					'3' => esc_html__( '3', 'eduma' ),
					'4' => esc_html__( '4', 'eduma' ),
					'5' => esc_html__( '5', 'eduma' ),
				],
				'default'   => '3',
				'selectors' => array(
					'{{WRAPPER}}' => '--course-category-columns: repeat({{VALUE}}, 1fr)',
				),
				'condition' => array(
					'layout' => [ 'grid' ]
				)
			]
		);

		$this->end_controls_section();

		$this->_register_style_layout();
		$this->_register_style_item();
	}

	protected function _register_style_layout() {
		$this->start_controls_section(
			'section_design_layout',
			array(
				'label'     => esc_html__( 'Layout', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layout' => 'grid',
				),
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'     => esc_html__( 'Columns Gap', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 30,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'row_gap',
			array(
				'label'     => esc_html__( 'Rows Gap', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 35,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--row-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function _register_style_item() {
		$this->start_controls_section(
			'title_widget_settings',
			[
				'label' => esc_html__( 'Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_widget_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-ekits-course-category .widget-title',
			]
		);
		$this->add_responsive_control(
			'title_widget_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 0,
					'bottom' => 0,
					'left'   => 20,
					'right'  => 0,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}}.thim-ekits-course-category .widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_widget_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-ekits-course-category .widget-title' => 'color: {{VALUE}};',

				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'item_settings',
			[
				'label' => esc_html__( 'Item', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				// 'condition' => array(
				// 	'layout' => 'grid',
				// ),
			]
		);

		$this->add_responsive_control(
			'item_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'eduma' ),
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
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .thim-widget-course-categories-grid ul li a' => 'text-align: {{VALUE}};',
				],
				'condition' => array(
					'layout' => 'grid',
				),
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 20,
					'bottom' => 20,
					'left'   => 20,
					'right'  => 20,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}}.thim-ekits-course-category ul li a'     => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: inline-block;',
					'{{WRAPPER}} .thim-carousel-course-categories .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition'  => array(
					'layout' => [ 'grid', 'base', 'slider' ],
					'click_show_sub!' => 'yes'
				),
			]
		);

		$this->add_responsive_control(
			'max_height',
			array(
				'label'     => esc_html__( 'Max Height', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
				'selectors' => array(
					'{{WRAPPER}} .click-show-sub' => 'max-height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			)
		);

		$this->add_responsive_control(
			'item_padding_list',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .click-show-sub>li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_control(
			'item_background_click_normal',
			[
				'label'     => esc_html__( 'Background List', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .click-show-sub>li' => 'background-color: {{VALUE}};'

				],
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_control(
			'item_background_click_active',
			[
				'label'     => esc_html__( 'Background Sub Active', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .click-show-sub, {{WRAPPER}} .click-show-sub>li.active' => 'background-color: {{VALUE}};'

				],
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-item-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'layout' => [ 'grid', 'slider' ],
				),
			)
		);

		// start tab for item
		$this->start_controls_tabs(
			'style_item_tabs'
		);

		// start normal tab
		$this->start_controls_tab(
			'item_style_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);
		$this->add_control(
			'item_background',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-course-categories-grid ul li a' => 'background-color: {{VALUE}};'

				],
				'condition' => array(
					'layout' => 'grid',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-ekits-course-category ul li a,{{WRAPPER}}.thim-ekits-course-category .item .title a',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-ekits-course-category ul li a,{{WRAPPER}} .thim-carousel-course-categories .item .title a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .thim-course-slider .item .title a'                       => 'color: {{VALUE}};'

				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_border',
				'label'     => esc_html__( 'Border', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-widget-course-categories-grid ul li a',
				'condition' => array(
					'layout' => 'grid',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'item_box_shadow',
				'label'     => esc_html__( 'Box Shadow', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-widget-course-categories-grid ul li a',
				'condition' => array(
					'layout' => 'grid',
				),
			]
		);

		$this->end_controls_tab();
		// end normal tab

		// start hover tab
		$this->start_controls_tab(
			'item_style_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);
		$this->add_control(
			'item_background_hover',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-course-categories-grid ul li a:hover' => 'background-color: {{VALUE}};'

				],
				'condition' => array(
					'layout' => 'grid',
				),
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.thim-ekits-course-category ul li a:hover,{{WRAPPER}} .thim-carousel-course-categories .item:hover .title a'                                                                 => 'color: {{VALUE}};',
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .thim-course-slider .item.active .title a,{{WRAPPER}} .thim-carousel-course-categories-tabs .thim-course-slider .item:hover .title a' => 'color: {{VALUE}};'

				],
			]
		);
		$this->add_control(
			'arrow_active',
			[
				'label'     => esc_html__( 'Arrow Background', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .thim-course-slider .item.active:after' => 'background-color: {{VALUE}};'

				],
				'condition' => array(
					'layout' => 'tab-slider',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_border_hover',
				'label'     => esc_html__( 'Border', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-widget-course-categories-grid ul li a:hover',
				'condition' => array(
					'layout' => 'grid',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'item_box_shadow_hover',
				'label'     => esc_html__( 'Box Shadow', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-widget-course-categories-grid ul li a:hover',
				'condition' => array(
					'layout' => 'grid',
				),
			]
		);

		$this->end_controls_tab();
		// end hover tab

		$this->end_controls_tabs();

		$this->add_control(
			'course_count_color',
			[
				'label'     => esc_html__( 'Count Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .click-show-sub >li .count-course' => 'color: {{VALUE}};',
				],
				'condition' => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_responsive_control(
			'course_count_margin',
			[
				'label'      => esc_html__( 'Count Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .click-show-sub >li .count-course' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_control(
			'subcat_style',
			array(
				'label'     => esc_html__( 'Sub Categories', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			)
		);

		$this->add_responsive_control(
			'subcat_padding_list',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .click-show-sub>li>ul .cat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_control(
			'subcat_list_color_hover',
			[
				'label'     => esc_html__( 'Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .click-show-sub>li>ul .cat-item:hover a' => 'color: {{VALUE}};',
				],
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_control(
			'subcat_list_bg_hover',
			[
				'label'     => esc_html__( 'Background Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .click-show-sub>li>ul .cat-item:hover' => 'background-color: {{VALUE}};',
				],
				'condition'  => array(
					'layout' => [ 'base' ],
					'click_show_sub' => 'yes'
				),
			]
		);

		$this->add_control(
			'heading_title_style',
			array(
				'label'     => esc_html__( 'Title', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'layout' => [ 'grid' ]
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_type_img_typography',
				'label'     => esc_html__( 'Typography', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-widget-course-categories-grid.layout-image-cats ul li a .category-title',
				'condition' => array(
					'layout' => [ 'grid' ]
				),
			]
		);
		$this->add_control(
			'title_type_img',
			[
				'label'     => esc_html__( 'Title Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-course-categories-grid.layout-image-cats ul li a .category-title' => 'color: {{VALUE}};',
				],
				'condition' => array(
					'layout' => [ 'grid' ]
				),
			]
		);
		$this->add_control(
			'title_type_img_hover',
			[
				'label'     => esc_html__( 'Title Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-course-categories-grid.layout-image-cats ul li a .category-title:hover' => 'color: {{VALUE}};',
				],
				'condition' => array(
					'layout' => [ 'grid' ]
				),
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 0,
					'bottom' => 0,
					'left'   => 20,
					'right'  => 0,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-course-categories-grid ul li a .category-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => array(
					'layout' => 'grid',
				),
			]
		);
		$this->add_control(
			'count_course_style',
			array(
				'label'     => esc_html__( 'Count Course', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'count_course' => 'yes',
					'use_img_icon' => 'img',
				),
			)
		);

		$this->add_responsive_control(
			'count_course_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-course-categories-grid.layout-image-cats ul li a .count-course' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => array(
					'count_course' => 'yes',
					'use_img_icon' => 'img',
				),
			]
		);
		$this->add_control(
			'heading_button_view_all',
			array(
				'label'     => esc_html__( 'View All', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'layout' => 'tab-slider',
				),
			)
		);
		$this->add_responsive_control(
			'view_all_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: inline-block;'
				],
				'condition'  => array(
					'layout' => 'tab-slider',
				),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'view_all_typography',
				'label'     => esc_html__( 'Typography', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses',
				'condition' => array(
					'layout' => 'tab-slider',
				),
			]
		);
		$this->add_control(
			'view_all_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses' => 'color: {{VALUE}};'
				],
				'condition' => array(
					'layout' => 'tab-slider',
				),
			]
		);
		$this->add_control(
			'view_all_color_hover',
			[
				'label'     => esc_html__( 'Text Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses:hover' => 'color: {{VALUE}};'
				],
				'condition' => array(
					'layout' => 'tab-slider',
				),
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'view_all_border',
				'label'     => esc_html__( 'Border', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses',
				'condition' => array(
					'layout' => 'tab-slider',
				),
			]
		);
		$this->add_control(
			'view_all_color_border_hover',
			[
				'label'     => esc_html__( 'Border Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'layout' => 'tab-slider',
				),
				'selectors' => [
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses:hover' => 'border-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'view_all_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => array(
					'layout' => 'tab-slider',
				),
				'selectors' => [
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses:hover' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'view_all_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-carousel-course-categories-tabs .content_items .item_content .view_all_courses' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'layout' => 'tab-slider',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Map variables between Elementor and SiteOrigin
		$instance = array(
			'title'          => $settings['title'],
			'image_size'     => $settings['image_size'],
			'use_img_icon'   => $settings['use_img_icon'],
			'click_show_sub' => $settings['click_show_sub'],
			'layout'         => $settings['layout'],
			'limit'          => $settings['limit'],
			'slider-options' => array(
				'limit'              => $settings['limit'],
				'show_navigation'    => $settings['show_navigation'],
				'auto_play'          => $settings['auto_play'],
				'show_pagination'    => $settings['show_pagination'],
				'responsive-options' => array(
					'item_visible'               => isset( $settings['item_visible'] ) ? $settings['item_visible']['size'] : '',
					'item_small_desktop_visible' => 6,
					'item_tablet_visible'        => 4,
					'item_mobile_visible'        => 2
				)
			),
			'list-options'   => array(
				'show_counts'  => $settings['show_counts'],
				'hierarchical' => $settings['hierarchical']
			),
			'grid-options'   => array(
				'grid_limit'  => $settings['grid_limit'],
				'grid_column' => $settings['grid_column']
			),
			'sub_categories' => $settings['sub_categories'],
			'count_course'   => $settings['count_course'],
			'format_count'   => $settings['format_count'],
		);

		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';

		$layout = $settings['layout'];
		$layout .= '-v3';

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $instance,
			'args'     => $args
		), $layout );
	}

}
