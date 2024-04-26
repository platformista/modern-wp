<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Courses extends Widget_Base {

	public function get_name() {
		return 'thim-courses';
	}

	public function get_title() {
		return esc_html__( 'Eduma List Courses', 'eduma' );
	}
//	public function show_in_panel() {
//		return false;
//	}


	public function get_icon() {
		return 'thim-widget-icon thim-widget-icon-courses';
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-courses';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	// Get list courses category

	protected function register_controls() {
		$this->start_controls_section(
			'content',
			[
				'label' => esc_html__( 'Courses', 'eduma' )
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

		$this->add_control(
			'before_heading',
			[
				'label'     => esc_html__( 'Before Heading', 'eduma' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'layout'                => [ 'item-tabs-slider' ],
					'item_tab_slider_style' => [ 'style_1' ]
				]
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'slider'            => esc_html__( 'Slider', 'eduma' ),
					'slider-instructor' => esc_html__( 'Slider - Instructor', 'eduma' ),
					'grid'              => esc_html__( 'Grid', 'eduma' ),
					'grid1'             => esc_html__( 'Grid New', 'eduma' ),
					'grid-instructor'   => esc_html__( 'Grid - Instructor', 'eduma' ),
					'list-sidebar'      => esc_html__( 'List Sidebar', 'eduma' ),
					'megamenu'          => esc_html__( 'Mega Menu', 'eduma' ),
					'tabs'              => esc_html__( 'Category Tabs', 'eduma' ),
					'tabs-slider'       => esc_html__( 'Category Tabs Slider', 'eduma' ),
					'item-tabs-slider'  => esc_html__( 'Category Item Tabs Slider', 'eduma' )
				],
				'default' => 'slider'
			]
		);

		$this->add_control(
			'grid_hide_author',
			[
				'label'        => esc_html__( 'Hide Author', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'layout' => [ 'grid-instructor' ]
				)
			]
		);

		$this->add_control(
			'item_tab_slider_style',
			[
				'label'     => esc_html__( 'Tabs Slider Style', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'style_1' => esc_html__( 'Style 01', 'eduma' ),
					'style_2' => esc_html__( 'Style 02', 'eduma' )
				],
				'default'   => 'style_1',
				'condition' => array(
					'layout' => [ 'item-tabs-slider' ]
				)
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order By', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'popular'  => esc_html__( 'Popular', 'eduma' ),
					'latest'   => esc_html__( 'Latest', 'eduma' ),
					'category' => esc_html__( 'Category', 'eduma' )
				],
				'default' => 'latest'
			]
		);

		$this->add_control(
			'cat_id',
			[
				'label'     => esc_html__( 'Select Category', 'eduma' ),
				'type'      => Controls_Manager::SELECT2,
				'options'   => thim_get_cat_taxonomy( 'course_category', array( 'all' => esc_html__( 'All', 'eduma' ) ) ),
				'condition' => array(
					'order' => [ 'category' ]
				)
			]
		);

		$this->add_control(
			'thumbnail_width',
			[
				'label'      => __( 'Thumbnail Width', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 400,
				],
				'condition'  => array(
					'layout' => [ 'slider', 'grid', 'grid1', 'tabs', 'tabs-slider', 'slider-instructor', 'grid-instructor' ]
				)
			]
		);

		$this->add_control(
			'thumbnail_height',
			[
				'label'      => __( 'Thumbnail Height', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 800,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 300,
				],
				'condition'  => array(
					'layout' => [ 'slider', 'grid', 'grid1', 'tabs', 'tabs-slider', 'slider-instructor', 'grid-instructor' ]
				)
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit Number Courses', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'featured',
			[
				'label'        => esc_html__( 'Display Featured Courses?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => ''
			]
		);

		$this->add_control(
			'view_all_courses',
			[
				'label'     => esc_html__( 'View All Text', 'eduma' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'layout' => [ 'grid', 'grid1', 'tabs-slider', 'grid-instructor' ]
				)
			]
		);

		$this->add_control(
			'view_all_position',
			[
				'label'       => __( 'View All Position', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'top'    => [
						'title' => __( 'Top', 'eduma' ),
						'icon'  => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'eduma' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'     => 'top',
				'toggle'      => false,
				'label_block' => false,
				'condition'   => array(
					'layout' => [ 'grid', 'grid1', 'tabs-slider', 'grid-instructor' ]
				)
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider-options',
			[
				'label'     => esc_html__( 'Slider Options', 'eduma' ),
				'condition' => array(
					'layout' => [ 'slider', 'slider-instructor', 'item-tabs-slider' ]
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
				'default'      => ''
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
				'default'      => 'yes'
			]
		);

		$this->add_control(
			'item_visible',
			[
				'label'   => esc_html__( 'Limit Number Courses', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 6,
				'step'    => 1
			]
		);

		$this->add_control(
			'auto_play',
			[
				'label'       => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
				'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'min'         => 0,
				'step'        => 100
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'grid-options',
			[
				'label'     => esc_html__( 'Grid Options', 'eduma' ),
				'condition' => array(
					'layout' => [ 'grid', 'grid1', 'grid-instructor' ]
				)
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 6,
				'step'    => 1
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tab-options',
			[
				'label'     => esc_html__( 'Tab Options', 'eduma' ),
				'condition' => array(
					'layout' => [ 'tabs', 'tabs-slider', 'item-tabs-slider' ]
				)
			]
		);

		$this->add_control(
			'limit_tab',
			[
				'label'     => esc_html__( 'Limit Items Per Tab', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'step'      => 1,
				'condition' => array(
					'layout' => [ 'tabs', 'tabs-slider' ]
				)
			]
		);

		$this->add_control(
			'cat_id_tab',
			[
				'label'       => esc_html__( 'Select Category Tabs', 'eduma' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => thim_get_cat_taxonomy( 'course_category' ),
				'multiple'    => true,
			]
		);

		$this->end_controls_section();

		$this->register_controls_setting_title();
		$this->register_controls_setting_read_more();
	}

	protected function register_controls_setting_title() {
		$this->start_controls_section(
			'title_settings',
			[
				'label' => esc_html__( 'Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'title_margin',
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
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .widget-title',
			]
		);
		$this->add_control(
			'title_color',
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
	}

	protected function register_controls_setting_read_more() {
		$this->start_controls_section(
			'link_all_posts_style_tabs',
			[
				'label'     => esc_html__( 'Read More', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layout' => [ 'grid', 'grid1', 'tabs-slider', 'grid-instructor' ]
				)
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_all_posts_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-courses .view-all-courses',
			]
		);

		$this->add_responsive_control(
			'link_all_posts_style',
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
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'link_all_posts_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_color_link_all_posts_style' );
		$this->start_controls_tab(
			'tab_color_link_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);
		$this->add_control(
			'read_more_text_color',
			[
				'label'     => __( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_read_more_text',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'link_all_posts_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_read_more_text',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}}.thim-widget-courses .view-all-courses' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_link_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);
		$this->add_control(
			'read_more_text_color_hover',
			[
				'label'     => __( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'border_read_more_text_hover',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'link_all_posts_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'bg_read_more_text_hover',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-courses .view-all-courses:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}}.thim-widget-courses .view-all-courses:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Map variables between Elementor and SiteOrigin
		$settings['thumbnail_width']  = isset( $settings['thumbnail_width'] ) ? $settings['thumbnail_width']['size'] : '';
		$settings['thumbnail_height'] = isset( $settings['thumbnail_height'] ) ? $settings['thumbnail_height']['size'] : '';
		$settings['slider-options']   = array(
			'show_pagination' => $settings['show_pagination'],
			'show_navigation' => $settings['show_navigation'],
			'item_visible'    => $settings['item_visible'],
			'auto_play'       => $settings['auto_play']
		);
		$settings['grid-options']     = array(
			'columns' => $settings['columns']
		);
		$settings['tabs-options']     = array(
			'limit_tab'  => $settings['limit_tab'],
			'cat_id_tab' => $settings['cat_id_tab']
		);

		$layout = $settings['layout'].'-v3';

		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';
		$args['condition']    = $this->render_query_post($settings);

		thim_ekit_get_widget_template( $this->get_base(), array( 'instance' => $settings, 'args' => $args ), $layout );
	}

	protected function render_query_post($settings) {
 		// query
		$limit     = $settings['limit'];
		$sort      = $settings['order'];
		$feature   = ! empty( $settings['featured'] ) ? true : false;
		$condition = array(
			'post_type'           => 'lp_course',
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => true,
		);
		if ( $sort == 'category' && $settings['cat_id'] && $settings['cat_id'] != 'all' ) {
			if ( get_term( $settings['cat_id'], 'course_category' ) ) {
				$condition['tax_query'] = array(
					array(
						'taxonomy' => 'course_category',
						'field'    => 'term_id',
						'terms'    => $settings['cat_id']
					),
				);
			}
		}
		if ( $sort == 'popular' ) {
			$post_in               = eduma_lp_get_popular_courses( $limit );
			$condition['post__in'] = $post_in;
			$condition['orderby']  = 'post__in';
		}

		if ( $feature ) {
			$condition['meta_query'] = array(
				array(
					'key'   => '_lp_featured',
					'value' => 'yes',
				)
			);
		}

		return $condition;
	}

}
