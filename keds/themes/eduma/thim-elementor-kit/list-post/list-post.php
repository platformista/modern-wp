<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_List_Post extends Widget_Base {

	public function get_name() {
		return 'thim-list-post';
	}

	public function get_title() {
		return esc_html__( 'List Post', 'eduma' );
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-list-post';
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-list-post';
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
				'label' => esc_html__( 'List Post', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'eduma' ),
				'default'     => esc_html__( 'From Blog', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'sub_title',
			[
				'label'       => esc_html__( 'Sub Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'style' => [ 'style_2' ]
				]
			]
		);

		$this->add_control(
			'cat_id',
			[
				'label'   => esc_html__( 'Select Category', 'eduma' ),
				'default' => 'all',
				'type'    => Controls_Manager::SELECT,
				'options' => thim_get_cat_taxonomy( 'category', array( 'all' => esc_html__( 'All', 'eduma' ) ) ),
			]
		);

		$this->add_control(
			'number_posts',
			[
				'label'   => esc_html__( 'Number Post', 'eduma' ),
				'default' => '4',
				'type'    => Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'show_description',
			[
				'label'     => esc_html__( 'Show Description', 'eduma' ),
				'default'   => true,
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'style!' => [ 'style_2' ]
				]
			]
		);
		$this->add_control(
			'length_desc',
			[
				'label'     => esc_html__( 'Length Description', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [
					'show_description' => [ 'yes' ]
				]
			]
		);
		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'popular' => esc_html__( 'Popular', 'eduma' ),
					'recent'  => esc_html__( 'Date', 'eduma' ),
					'title'   => esc_html__( 'Title', 'eduma' ),
					'random'  => esc_html__( 'Random', 'eduma' ),
				],
				'default' => 'recent'
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order by', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'ASC', 'eduma' ),
					'desc' => esc_html__( 'DESC', 'eduma' )
				],
				'default' => 'asc'
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'base',
				'options' => [
					'base' => esc_html__( 'Default', 'eduma' ),
					'grid' => esc_html__( 'Grid', 'eduma' ),
				],
			]
		);
		$this->add_control(
			'style',
			[
				'label'     => esc_html__( 'Style', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'homepage',
				'options'   => [
					'homepage' => esc_html__( 'Style 01 -Home Page', 'eduma' ),
					'style_2'  => esc_html__( 'Style 02', 'eduma' ),
					'sidebar'  => esc_html__( 'Style 03 - Sidebar', 'eduma' ),
					'home-new' => esc_html__( 'Style 04 -Home Grad', 'eduma' ),
				],
				'condition' => [
					'layout' => [ 'base' ]
				]
			]
		);
		$this->add_control(
			'display_feature',
			[
				'label'     => esc_html__( 'Show feature posts', 'eduma' ),
				'default'   => false,
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'layout' => [ 'grid' ]
				]
			]
		);
		$this->add_control(
			'show_feature_image',
			[
				'label'        => esc_html__( 'Show Featured Image', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'eduma' ),
				'label_off'    => esc_html__( 'Hide', 'eduma' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'separator' => 'none',
				'condition' => [
					'show_feature_image' => [ 'yes' ]
				]
			]
		);

		$this->add_control(
			'item_vertical',
			[
				'label'       => esc_html__( 'Items vertical', 'eduma' ),
				'description' => esc_html__( 'Items display with vertical. Enter 0 if doesn\'t show vertical', 'eduma' ),
				'default'     => '0',
				'type'        => Controls_Manager::NUMBER,
				'condition'   => [
					'layout' => [ 'grid' ]
				]
			]
		);

		$this->end_controls_section();

		$this->register_controls_setting_title();
		$this->register_controls_setting_read_more();
		$this->register_controls_style_content();

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
			'read_more_group',
			[
				'label' => __( 'Link All Posts', 'eduma' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'text_link',
			[
				'label'       => esc_html__( 'Text All Posts', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'link_all_posts_style_tabs',
			[
				'label' => esc_html__( 'Read More', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_all_posts_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}}.thim-widget-list-post .link_read_more a',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_read_more_text',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'bg_read_more_text_hover',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}}.thim-widget-list-post .link_read_more a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function register_controls_style_content() {
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_title_style',
			array(
				'label' => esc_html__( 'Title', 'eduma' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'content_title_color',
			array(
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .title a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_title_typography',
				'selector' => '{{WRAPPER}}.thim-widget-list-post .sc-list-post .title a',
			)
		);

		$this->add_control(
			'title_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_meta_style',
			array(
				'label'     => esc_html__( 'Meta', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .info > div,{{WRAPPER}} .thim-grid-posts .article-wrapper .date' => 'color: {{VALUE}};',
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .info .date:before'                                              => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'bg_meta_color',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'style' => [ 'homepage' ]
				],
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .info' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}}.thim-widget-list-post .sc-list-post .info > div,{{WRAPPER}} .thim-grid-posts .article-wrapper .date',
			)
		);

		$this->add_control(
			'meta_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .info,{{WRAPPER}} .thim-grid-posts .article-wrapper .date' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_excerpt_style',
			array(
				'label'     => esc_html__( 'Excerpt', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}}.thim-widget-list-post .sc-list-post .description',
			)
		);

		$this->add_control(
			'excerpt_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_readmore_style',
			array(
				'label'     => esc_html__( 'Read More', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
 					'style!' => [ 'style_2','sidebar','home-new' ]
				]
			)
		);

		$this->add_control(
			'readmore_color',
			array(
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .read-more' => 'color: {{VALUE}};',
				),
				'condition' => [
					'style!' => [ 'style_2','sidebar','home-new' ]
				]
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'readmore_typography',
				'selector'  => '{{WRAPPER}}.thim-widget-list-post .sc-list-post .read-more',
				'condition' => [
					'style!' => [ 'style_2','sidebar','home-new' ]
				]
			)
		);

		$this->add_control(
			'readmore_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.thim-widget-list-post .sc-list-post .read-more' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition' => [
					'style!' => [ 'style_2','sidebar','home-new' ]
				]
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings             = $this->get_settings_for_display();
		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';
		if ( isset( $settings['image_size'] ) && $settings['image_size'] == 'custom' ) {
			$w                      = isset( $settings['image_custom_dimension']['width'] ) ? $settings['image_custom_dimension']['width'] : '300';
			$h                      = isset( $settings['image_custom_dimension']['height'] ) ? $settings['image_custom_dimension']['height'] : '300';
			$image_size_custom      = array( $w, $h );
			$settings['image_size'] = $image_size_custom;
		}
		thim_ekit_get_widget_template( $this->get_base(), array( 'instance' => $settings, 'args' => $args ), $settings['layout'] );
	}

}
