<?php

namespace Elementor;

use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Controls\Repeater as Global_Style_Repeater;
use Elementor\Utils;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_List_Event extends Widget_Base {

	public function get_name() {
		return 'thim-list-event';
	}

	public function get_title() {
		return esc_html__( 'List Events', 'eduma' );
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
				'label' => esc_html__( 'List Events', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Heading', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'condition'   => [
					'skin' => 'classic'
				]
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'       => esc_html__( 'Sub Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'skin'   => 'classic',
					'layout' => 'layout-6'
				]
			]
		);

		$this->add_control(
			'skin',
			[
				'label'   => esc_html__( 'Skin', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'classic'   => esc_html__( 'Classic', 'eduma' ),
					'new_model' => esc_html__( 'New Model', 'eduma' )
				],
				'default' => 'classic'
			]
		);

		$this->add_control(
			'layout',
			[
				'label'     => esc_html__( 'Layout', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'base'     => esc_html__( 'Default', 'eduma' ),
					'slider'   => esc_html__( 'Slider', 'eduma' ),
					'layout-2' => esc_html__( 'Layout 2', 'eduma' ),
					'layout-3' => esc_html__( 'Layout 3', 'eduma' ),
					'layout-4' => esc_html__( 'Layout 4', 'eduma' ),
					'layout-5' => esc_html__( 'Layout 5', 'eduma' ),
					'layout-6' => esc_html__( 'Layout 6', 'eduma' ),
				],
				'default'   => 'base',
				'condition' => [
					'skin' => 'classic'
				]
			]
		);

		$this->add_control(
			'layout_model',
			[
				'label'     => esc_html__( 'Layout', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'base'   => esc_html__( 'Default', 'eduma' ),
					'slider' => esc_html__( 'Slider', 'eduma' )
				],
				'default'   => 'base',
				'condition' => [
					'skin' => 'new_model'
				]
			]
		);

		$this->add_control(
			'cat_id',
			[
				'label'    => esc_html__( 'Select Category', 'eduma' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => thim_get_cat_taxonomy( 'tp_event_category', array( 'all' => esc_html__( 'All', 'eduma' ) ) ),
				'default'  => 'all'
			]
		);

		$this->add_control(
			'status',
			[
				'label'       => esc_html__( 'Select Status', 'eduma' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => false,
				'options'     => array(
					'upcoming'  => esc_html__( 'Upcoming', 'eduma' ),
					'happening' => esc_html__( 'Happening', 'eduma' ),
					'expired'   => esc_html__( 'Expired', 'eduma' ),
				)
			]
		);

		$this->add_control(
			'number_posts_slider',
			[
				'label'     => esc_html__( 'Number posts slider', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'step'      => 1,
				'condition' => [
					'layout' => [ 'layout-5', 'layout-6' ]
				]
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'     => esc_html__( 'Background Image Bottom', 'eduma' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'layout' => 'layout-5'
				]
			]
		);

		$this->add_control(
			'number_posts',
			[
				'label'   => esc_html__( 'Number Posts', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'          => esc_html__( 'Columns', 'eduma' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'selectors'      => array(
					'{{WRAPPER}}' => '--thim-ekits-event-columns: repeat({{VALUE}}, 1fr)',
				),
				'condition'      => [
					'skin'         => 'new_model',
					'layout_model' => 'base'
				],
			)
		);

		$this->add_control(
			'text_link',
			[
				'label'     => esc_html__( 'Text Link All', 'eduma' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'View All', 'eduma' ),
				'condition' => [
					'skin'   => 'classic',
					'layout' => [ 'base', 'layout-2', 'layout-3', 'layout-4' ]
				]
			]
		);

		$this->end_controls_section();

		$this->_register_content_layout();

		$this->_register_setting_slider();

		$this->_register_style_content_layout();

		$this->_register_style_title();

		$this->_register_item_settings();

		$this->_register_style_event_status();

		$this->_register_item_view_all_settings();

		$this->_register_setting_slider_dot_style();

		$this->_register_setting_slider_nav_style();

	}

	protected function _register_content_layout() {
		$this->start_controls_section(
			'section_content',
			array(
				'label'     => esc_html__( 'Content', 'eduma' ),
				'condition' => [
					'skin' => 'new_model'
				]
			)
		);

		$this->add_control(
			'show_image',
			array(
				'label'   => esc_html__( 'Show Image', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->add_control(
			'show_label_status',
			array(
				'label'   => esc_html__( 'Show Label Status', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);
		$this->add_control(
			'thumbnail_enable',
			array(
				'label'        => esc_html__( 'Image', 'eduma' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'none',
				'options'      => [
					'none'  => [
						'title' => esc_html__( 'none', 'eduma' ),
						'icon'  => 'eicon-ban',
					],
					'left'  => [
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'render_type'  => 'ui',
				'prefix_class' => 'thim-ekits-event__thumbnail-position-',
				'condition' => array(
					'show_image' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image_size',
				'default'   => 'medium',
				'condition' => array(
					'show_image' => 'yes',
				),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'key',
			array(
				'label'   => esc_html__( 'Type', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => array(
					'date_end'  => esc_html__( 'Date End', 'eduma' ),
					'title'     => esc_html__( 'Title', 'eduma' ),
					'meta_data' => esc_html__( 'Meta Data', 'eduma' ),
					'content'   => esc_html__( 'Content', 'eduma' ),
					'read_more' => esc_html__( 'Read more', 'eduma' )
				),
			)
		);

		$repeater->add_control(
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
				'default'   => 'h3',
				'condition' => array(
					'key' => 'title',
				),
			)
		);

		$repeater->add_control(
			'meta_data',
			array(
				'label'       => esc_html__( 'Meta Data', 'eduma' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'default'     => array( 'time_start_end', 'location' ),
				'multiple'    => true,
				'options'     => array(
					'time_start_end' => esc_html__( 'Time Start/End', 'eduma' ),
					'location'       => esc_html__( 'Location', 'eduma' ),
				),
				'condition'   => array(
					'key' => 'meta_data',
				),
			)
		);

		$repeater->add_control(
			'excerpt_lenght',
			array(
				'label'     => esc_html__( 'Excerpt Lenght', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'condition' => array(
					'key' => 'content',
				),
			)
		);

		$repeater->add_control(
			'excerpt_more',
			array(
				'label'     => esc_html__( 'Excerpt More', 'eduma' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '...',
				'condition' => array(
					'key' => 'content',
				),
			)
		);

		$repeater->add_control(
			'read_more_text',
			array(
				'label'     => esc_html__( 'Read More Text', 'eduma' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'eduma' ),
				'condition' => array(
					'key' => 'read_more',
				),
			)
		);

		$this->add_control(
			'repeater',
			array(
				'label'       => esc_html__( 'Post Data', 'elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'key' => 'date_end',
					),
					array(
						'key' => 'title',
					),
					array(
						'key' => 'meta_data',
					),
					array(
						'key' => 'content',
					),
					array(
						'key' => 'read_more',
					),
				),
				'separator'   => 'before',
				'title_field' => '<span style="text-transform: capitalize;">{{{ key.replace("_", " ") }}}</span>',
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
				'condition' => [
					'layout_model' => 'base'
				],
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-column-gap: {{SIZE}}{{UNIT}}',
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
				'condition' => [
					'layout_model' => 'base'
				],
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-row-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function _register_style_content_layout() {
		$this->start_controls_section(
			'section_style_content',
			array(
				'label'     => esc_html__( 'Content Style', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin' => 'new_model'
				]
			)
		);

		$this->add_responsive_control(
			'content_event_padding',
			array(
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-ekits-event-content-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'content_event_margin',
			array(
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-event__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'post_border',
				'selector' => '{{WRAPPER}} .thim-ekits-event__item',
			)
		);

		$this->start_controls_tabs( 'event_style_tabs' );

		$this->start_controls_tab(
			'event_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'eduma' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'event_shadow',
				'selector' => '{{WRAPPER}} .thim-ekits-event__item',
			)
		);

		$this->add_control(
			'event_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-event__item' => 'background-color: {{VALUE}}',
				),
			)
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'event_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'eduma' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'event_shadow_hover',
				'selector' => '{{WRAPPER}} .thim-ekits-event__item:hover',
			)
		);

		$this->add_control(
			'event_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-event__item:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'event_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-event__item'                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .thim-ekits-event__item .event-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function _register_setting_slider() {
		// setting slider section

		$this->start_controls_section(
			'skin_slider_settings',
			[
				'label'     => esc_html__( 'Settings Slider', 'eduma' ),
				'condition' => array(
					'skin'         => 'new_model',
					'layout_model' => 'slider',
				),
			]
		);

		$this->add_responsive_control(
			'slidesPerView',
			[
				'label'              => esc_html__( 'Item Show', 'eduma' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 20,
				'step'               => 1,
				'default'            => 3,
				'devices' => [ 'widescreen','desktop', 'tablet', 'mobile' ],
				'mobile_default' => '2',
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'slidesPerGroup',
			[
				'label'              => esc_html__( 'Item Scroll', 'eduma' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 20,
				'step'               => 1,
				'default'            => 3,
				'devices' => [ 'widescreen','desktop', 'tablet', 'mobile' ],
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'spaceBetween',
			[
				'label'              => esc_html__( 'Item Space', 'eduma' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 100,
				'step'               => 1,
				'default'            => 30,
				'devices' => [ 'widescreen','desktop', 'tablet', 'mobile' ],
				'mobile_default' => '15',
				'frontend_available' => true
			]
		);
		$this->add_control(
			'slider_speed',
			[
				'label'              => esc_html__( 'Speed', 'eduma' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 10000,
				'step'               => 1,
				'default'            => 1000,
				'frontend_available' => true
			]
		);

		$this->add_control(
			'slider_autoplay',
			[
				'label'              => esc_html__( 'Autoplay', 'eduma' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'eduma' ),
				'label_off'          => esc_html__( 'No', 'eduma' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label'              => esc_html__( 'Pause on Interaction', 'eduma' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'eduma' ),
				'label_off'          => esc_html__( 'No', 'eduma' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'condition'          => [
					'slider_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'              => esc_html__( 'Pause on Hover', 'elementor' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Yes', 'eduma' ),
				'label_off'          => esc_html__( 'No', 'eduma' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
				'condition'          => [
					'slider_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'slider_show_arrow',
			[
				'label'              => esc_html__( 'Show Arrow', 'eduma' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'eduma' ),
				'label_off'          => esc_html__( 'No', 'eduma' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'slider_show_pagination',
			[
				'label'              => esc_html__( 'Pagination Options', 'eduma' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'options'            => array(
					'none'        => esc_html__( 'Hide', 'eduma' ),
					'bullets'     => esc_html__( 'Bullets', 'eduma' ),
					'number'      => esc_html__( 'Number', 'eduma' ),
					'progressbar' => esc_html__( 'Progress', 'eduma' ),
					'scrollbar'   => esc_html__( 'Scrollbar', 'eduma' ),
					'fraction'    => esc_html__( 'Fraction', 'eduma' ),
				),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'slider_loop',
			[
				'label'              => esc_html__( 'Enable Loop?', 'eduma' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'eduma' ),
				'label_off'          => esc_html__( 'No', 'eduma' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

	}

	protected function _register_setting_slider_dot_style() {
		// dot style
		$this->start_controls_section(
			'slider_dot_tab',
			[
				'label'     => esc_html__( 'Pagination', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slider_show_pagination!' => 'none'
				]
			]
		);

		$this->add_control(
			'slider_pagination_offset_position_v',
			array(
				'label'       => esc_html__( 'Vertical Position', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => '100',
				'options'     => array(
					'0'   => array(
						'title' => esc_html__( 'Top', 'eduma' ),
						'icon'  => 'eicon-v-align-top',
					),
					'100' => array(
						'title' => esc_html__( 'Bottom', 'eduma' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
				'selectors'   => [
					'{{WRAPPER}} .thim-slider-pagination' => 'top:{{VALUE}}%;',
				],
			)
		);
		$this->add_responsive_control(
			'slider_pagination_vertical_offset',
			array(
				'label'       => esc_html__( 'Vertical align', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 500,
				'max'         => 500,
				'step'        => 1,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-pagination' => '-webkit-transform: translateY({{VALUE}}px); -ms-transform: translateY({{SIZE}}px); transform: translateY({{SIZE}}px);',
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 12,
				],
				'condition'  => [
					'slider_show_pagination' => [ 'bullets', 'number' ]
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-slider-pagination' => '--thim-pagination-space: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'pagination_number_typography',
				'condition' => [
					'slider_show_pagination' => 'number'
				],
				'selector'  => '{{WRAPPER}} .thim-number .swiper-pagination-bullet',
			)
		);

		$this->add_responsive_control(
			'pagination_number_padding',
			array(
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'condition'  => [
					'slider_show_pagination' => 'number'
				],
				'selectors'  => array(
					'{{WRAPPER}} .thim-number .swiper-pagination-bullet' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);

		$this->add_responsive_control(
			'slider_dot_border_radius',
			[
				'label'      => esc_html__( 'Border radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'condition'  => [
					'slider_show_pagination' => [ 'bullets', 'number' ]
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_dot_active_border',
			array(
				'label'     => esc_html_x( 'Border Type', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'none'   => esc_html__( 'None', 'eduma' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'eduma' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'eduma' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'eduma' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'eduma' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'eduma' ),
				),
				'condition' => [
					'slider_show_pagination' => [ 'bullets', 'number' ]
				],
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-style: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_active_border_dimensions',
			array(
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => array(
					'slider_dot_active_border!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'dot_setting_tab',
			[
				'condition' => [
					'slider_show_pagination' => [ 'bullets', 'number', 'progressbar', 'scrollbar' ]
				]
			]
		);

		$this->start_controls_tab(
			'dot_slider_style',
			array(
				'label' => esc_html__( 'Default', 'eduma' ),
			)
		);

		$this->add_responsive_control(
			'slider_dot_width',
			[
				'label'      => esc_html__( 'Width', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'slider_show_pagination' => 'bullets'
				]
			]
		);

		$this->add_responsive_control(
			'slider_dot_height',
			[
				'label'      => esc_html__( 'Height', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'condition'  => [
					'slider_show_pagination' => [ 'bullets', 'progressbar', 'scrollbar' ]
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet'       => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .thim-progressbar,{{WRAPPER}} .thim-scrollbar' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slider_dot_background',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet'          => 'background-color: {{VALUE}}; opacity: 1;',
					'{{WRAPPER}} .swiper-pagination-progressbar,{{WRAPPER}} .thim-scrollbar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_pagination_number',
			array(
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'slider_show_pagination' => 'number'
				],
				'selectors' => array(
					'{{WRAPPER}} .thim-number .swiper-pagination-bullet' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'slider_pagination_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'slider_dot_active_border!' => 'none',
				],
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'slider_pagination_border_box_shadow_normal',
				'label'     => esc_html__( 'Box Shadow', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet',
				'condition' => [
					'slider_show_pagination' => [ 'bullets', 'number' ]
				],
			]
		);
		//		$this->add_group_control(
		//			Group_Control_Border::get_type(),
		//			[
		//				'name'      => 'slider_dot_border',
		//				'label'     => esc_html__( 'Border', 'eduma' ),
		//				'condition'  => [
		//					'slider_show_pagination' => [ 'bullets', 'number' ]
		//				],
		//				'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet',
		//			]
		//		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'dot_slider_active_style',
			array(
				'label' => esc_html__( 'Active', 'eduma' ),
			)
		);

		$this->add_responsive_control(
			'slider_dot_active_width',
			[
				'label'      => esc_html__( 'Width', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'condition'  => [
					'slider_show_pagination' => 'bullets'
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_dot_active_height',
			[
				'label'      => esc_html__( 'Height', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'condition'  => [
					'slider_show_pagination' => 'bullets'
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slider_dot_active_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,{{WRAPPER}} .thim-scrollbar .swiper-scrollbar-drag'                                 => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_pagination_number_active',
			array(
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'slider_show_pagination' => 'number'
				],
				'selectors' => array(
					'{{WRAPPER}} .thim-number .swiper-pagination-bullet:hover,{{WRAPPER}} .thim-number .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'slider_dot_active_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'slider_dot_active_border!' => 'none',
				],
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'slider_pagination_border_box_shadow_active',
				'label'     => esc_html__( 'Box Shadow', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover',
				'condition' => [
					'slider_show_pagination' => [ 'bullets', 'number' ]
				],
			]
		);
		//		$this->add_group_control(
		//			Group_Control_Border::get_type(),
		//			[
		//				'name'      => 'slider_dot_active_border',
		//				'label'     => esc_html__( 'Border', 'eduma' ),
		//				'condition' => [
		//					'slider_show_pagination' => [ 'bullets', 'number' ]
		//				],
		//				'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover',
		//			]
		//		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function _register_setting_slider_nav_style() {
		$this->start_controls_section(
			'slider_nav_style_tab',
			[
				'label'     => esc_html__( 'Nav', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'slider_show_arrow' => 'yes'
				]
			]
		);


		$this->start_controls_tabs(
			'slider_nav_group_tabs'
		);

		$this->start_controls_tab(
			'slider_nav_prev_tab',
			[
				'label' => esc_html__( 'Prev', 'eduma' ),
			]
		);
		$this->add_control(
			'slider_arrows_left',
			[
				'label'       => esc_html__( 'Prev Arrow Icon', 'eduma' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-left',
					'library' => 'Font Awesome 5 Free',
				]
			]
		);

		$this->add_control(
			'prev_offset_orientation_h',
			array(
				'label'       => esc_html__( 'Horizontal Orientation', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'left',
				'options'     => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'render_type' => 'ui',
			)
		);
		$this->add_responsive_control(
			'prev_indicator_offset_h',
			array(
				'label'       => esc_html__( 'Offset', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-nav-prev' => '{{prev_offset_orientation_h.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'slider_nav_next_tab',
			[
				'label' => esc_html__( 'Next', 'eduma' ),
			]
		);
		$this->add_control(
			'slider_arrows_right',
			[
				'label'       => esc_html__( 'Next Arrow Icon', 'eduma' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'Font Awesome 5 Free',
				],
			]
		);

		$this->add_control(
			'next_offset_orientation_h',
			array(
				'label'       => esc_html__( 'Horizontal Orientation', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'right',
				'options'     => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'next_indicator_offset_h',
			array(
				'label'       => esc_html__( 'Offset', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-nav-next' => '{{next_offset_orientation_h.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'slider_nav_offset_position_v',
			array(
				'label'       => esc_html__( 'Vertical Position', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => '50',
				'options'     => array(
					'0'   => array(
						'title' => esc_html__( 'Top', 'eduma' ),
						'icon'  => 'eicon-v-align-top',
					),
					'50'  => array(
						'title' => esc_html__( 'Middle', 'eduma' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'100' => array(
						'title' => esc_html__( 'Bottom', 'eduma' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
				'selectors'   => [
					'{{WRAPPER}} .thim-slider-nav' => 'top:{{VALUE}}%;',
				],
			)
		);
		$this->add_responsive_control(
			'slider_nav_vertical_offset',
			array(
				'label'       => esc_html__( 'Vertical align', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 500,
				'max'         => 500,
				'step'        => 1,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-nav' => '-webkit-transform: translateY({{VALUE}}px); -ms-transform: translateY({{SIZE}}px); transform: translateY({{SIZE}}px);',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav_font_size',
			[
				'label'      => esc_html__( 'Font Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 36,
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-slider-nav' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_nav_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-slider-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'slider_nav_width',
			[
				'label'      => esc_html__( 'Width', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-slider-nav' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'slider_nav_height',
			[
				'label'      => esc_html__( 'Height', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-slider-nav' => 'height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->start_controls_tabs(
			'slider_nav_hover_normal_tabs'
		);

		$this->start_controls_tab(
			'slider_nav_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_responsive_control(
			'slider_nav_color_normal',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .thim-slider-nav' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_responsive_control(
			'slider_nav_bg_color_normal',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .thim-slider-nav' => 'background-color: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slider_nav_box_shadow_normal',
				'label'    => esc_html__( 'Box Shadow', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_nav_border_normal',
				'label'    => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_nav_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_responsive_control(
			'slider_nav_color_hover',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-slider-nav:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'slider_nav_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-slider-nav:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slider_nav_box_shadow_hover',
				'label'    => esc_html__( 'Box Shadow', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'slider_nav_border_hover',
				'label'    => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _register_style_title() {
		$this->start_controls_section(
			'heading_settings',
			[
				'label'     => esc_html__( 'Title', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin' => 'classic'
				]
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


	}

	protected function _register_style_event_status() {
		$this->start_controls_section(
			'event_status_settings',
			[
				'label'     => esc_html__( 'Event Status Label', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin'              => 'new_model',
					'show_label_status' => 'yes'
				]
			]
		);
		$this->add_control(
			'event_offset_orientation_h',
			array(
				'label'       => esc_html__( 'Horizontal Orientation', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'right',
				'options'     => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'render_type' => 'ui',
			)
		);
		$this->add_responsive_control(
			'event_indicator_offset_h',
			array(
				'label'       => esc_html__( 'Offset', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-event__item .label-event-status' => '{{event_offset_orientation_h.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->add_control(
			'event_offset_orientation_v',
			array(
				'label'       => esc_html__( 'Vertical Orientation', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'top',
				'options'     => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'eduma' ),
						'icon'  => 'eicon-v-align-top',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'eduma' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
			)
		);
		$this->add_responsive_control(
			'event_indicator_offset_v',
			array(
				'label'       => esc_html__( 'Offset', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-event__item .label-event-status' => '{{event_offset_orientation_v.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->add_responsive_control(
			'event_status_label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'event_label_triangle',
			array(
				'label'       => esc_html__( 'Triangle Size', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'default'     => 14,
				'selectors'   => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-triangle:{{VALUE}}px',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'event_status_label_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-ekits-event__thumbnail .label-event-status',
			]
		);

		$this->start_controls_tabs( 'event_status_style_tabs' );

		$this->start_controls_tab(
			'happening_style_label',
			array(
				'label' => esc_html__( 'Happening', 'eduma' ),
			)
		);
		$this->add_control(
			'happening_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'happening_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-bg-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'upcoming_style_label',
			array(
				'label' => esc_html__( 'Upcoming', 'eduma' ),
			)
		);

		$this->add_control(
			'upcoming_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-upcoming-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'upcoming_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-upcoming-bg-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'expired_style_label',
			array(
				'label' => esc_html__( 'Expired', 'eduma' ),
			)
		);

		$this->add_control(
			'expired_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-expired-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'expired_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-event-status-expired-bg-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


	}

	protected function _register_item_settings() {
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
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'day_end_typography',
				'label'     => esc_html__( 'Day Typography', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-ekits-event__date-month .date',
				'condition' => [
					'skin' => 'new_model'
				]
			]
		);
		$this->add_control(
			'date_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .time-from, 
					{{WRAPPER}} .thim-list-event .thim-event-layout-6 .item-slider .image .date,
					{{WRAPPER}} .list-event-slider .item-event .event-wrapper .box-time .time-from,
					{{WRAPPER}} .thim-ekits-event__date-month .date'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .thim-list-event.layout-2 .time-from' => 'border-color: {{VALUE}};'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'month_end_typography',
				'label'     => esc_html__( 'Month Typography', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-ekits-event__date-month .month',
				'condition' => [
					'skin' => 'new_model'
				]
			]
		);
		$this->add_control(
			'month_color',
			[
				'label'     => esc_html__( 'Month Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-ekits-event__date-month .month'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .thim-ekits-event__date-month .month:before' => 'background: {{VALUE}};'
				],
				'condition' => [
					'skin' => 'new_model'
				]
			]
		);

		$this->add_responsive_control(
			'spacing_meta_date-month',
			[
				'label'     => esc_html__( 'Spacing (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-ekits-event__date-month' => 'margin-bottom: {{SIZE}}px;',
				],
				'condition' => [
					'skin' => 'new_model'
				]
			]
		);
		$this->add_control(
			'border_date_color',
			[
				'label'     => esc_html__( 'Border Date Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event.layout-3 .time-from .date:after,
					{{WRAPPER}} .list-event-slider .item-event .event-wrapper .box-time:after'                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .thim-list-event.layout-3 .time-from .date,
					{{WRAPPER}} .thim-simple-wrapper .pagination .item.active,
					{{WRAPPER}} .thim-simple-wrapper .pagination .item:hover,
					{{WRAPPER}} .list-event-slider .item-event .event-wrapper .box-time:before' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'skin'   => 'classic',
					'layout' => [ 'layout-3', 'slider' ]
				]
			]
		);

		$this->add_control(
			'date_slider_color',
			[
				'label'     => esc_html__( 'Text Color Slider', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event.layout-5 .thim-column-slider .item-event .event-info .time-from' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin'   => 'classic',
					'layout' => 'layout-5'
				]
			]
		);

		$this->add_control(
			'bg_date_color',
			[
				'label'     => esc_html__( 'Background Date Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event.layout-2.layout-4 .time-from' => 'background-color: {{VALUE}};'
				],
				'condition' => [
					'skin'   => 'classic',
					'layout' => 'layout-4'
				]
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
				'selector' => '{{WRAPPER}} .event-wrapper .title,{{WRAPPER}} .thim-ekits-event__title',
			]
		);
		$this->add_responsive_control(
			'mg_bottom_title_item',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .event-wrapper .title,{{WRAPPER}} .thim-ekits-event__title' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_item' );

		$this->start_controls_tab(
			'item_tabnormal',
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
					'{{WRAPPER}} .event-wrapper .title a,{{WRAPPER}} .thim-ekits-event__title a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_item_hover',
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
					'{{WRAPPER}} .event-wrapper .title a:hover,{{WRAPPER}} .thim-ekits-event__title a:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'heading_meta_item',
			array(
				'label'      => esc_html__( 'Meta Data', 'eduma' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'slider',
								],
							],
						],
					],
				],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'       => 'meta_data_item_typography',
				'label'      => esc_html__( 'Typography', 'eduma' ),
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'slider',
								],
							],
						],
					],
				],
				'selector'   => '{{WRAPPER}}.thim-ekits-event-style .event-wrapper .meta,{{WRAPPER}} .thim-ekits-event__meta',
			]
		);

		$this->add_responsive_control(
			'mg_bottom_meta_item',
			[
				'label'      => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-meta-data-margin-bottom: {{SIZE}}px;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'slider',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'      => esc_html__( 'Text Color', 'eduma' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '',
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-meta-data-color: {{VALUE}};'
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'slider',
								],
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'spacing_meta_item',
			[
				'label'     => esc_html__( 'Spacing (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}}' => '--thim-meta-data-spacing: {{SIZE}}px;',
				],
				'condition' => [
					'skin' => 'new_model'
				]
			]
		);

		$this->add_control(
			'icon_meta_item_size',
			[
				'label'      => esc_html__( 'Icon Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}.thim-ekits-event-style .event-wrapper .meta i,{{WRAPPER}} .thim-ekits-event__meta i' => 'font-size: {{SIZE}}px;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'base', 'layout-4', 'layout-2', 'layout-6' ],
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'meta_icon_color',
			[
				'label'      => esc_html__( 'Icon Color', 'eduma' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '',
				'selectors'  => [
					'{{WRAPPER}}.thim-ekits-event-style .event-wrapper .meta i,{{WRAPPER}} .thim-ekits-event__meta i' => 'color: {{VALUE}};'
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'base', 'layout-4', 'layout-2', 'layout-6' ],
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'heading_desc_item',
			array(
				'label'      => esc_html__( 'Description', 'eduma' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'layout-3',
								],
							],
						],
					],
				],
			)
		);

		$this->add_responsive_control(
			'font_size_desc_item',
			[
				'label'      => esc_html__( 'Font Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-meta-data-desc-font-size: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'layout-3',
								],
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'mg_bottom_desc_item',
			[
				'label'      => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-meta-data-desc-margin-bottom: {{SIZE}}px;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'layout-3',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'      => esc_html__( 'Text Color', 'eduma' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '',
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-meta-data-desc-color: {{VALUE}};'
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => '!==',
									'value'    => 'layout-3',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'border_item_color',
			[
				'label'      => esc_html__( 'Border Item Color', 'eduma' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '',
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-meta-data-item-border-color: {{VALUE}};'
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'classic',
						],
						[
							'name'     => 'layout',
							'operator' => '!==',
							'value'    => [ 'layout-6', 'layout-3', 'slider' ],
						],
					],
				],
			]
		);

		$this->add_control(
			'heading_view_details_item',
			array(
				'label'      => esc_html__( 'View Details', 'eduma' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'layout-6', 'layout-3', 'slider' ],
								],
							],
						],
					],
				],
			)
		);

		$this->add_responsive_control(
			'font_size_view_details_item',
			[
				'label'      => esc_html__( 'Font Size', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-link-detail-font-size: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'layout-6', 'layout-3', 'slider' ],
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'text_tranform_view_details_item',
			[
				'label'       => esc_html__( 'Transform', 'eduma' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => false,
				'options'     => array(
					''           => esc_html__( 'Default', 'eduma' ),
					'uppercase'  => esc_html__( 'Uppercase', 'eduma' ),
					'lowercase'  => esc_html__( 'Lowercase', 'eduma' ),
					'capitalize' => esc_html__( 'Capitalize', 'eduma' ),
					'none'       => esc_html__( 'Normal', 'eduma' ),
				),
				'selectors'   => [
					'{{WRAPPER}}' => '--thim-link-detail-text-transform: {{VALUE}};',
				],
				'conditions'  => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'layout-6', 'layout-3', 'slider' ],
								],
							],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'mg_bottom_view_details_item',
			[
				'label'      => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-link-detail-margin-bottom: {{SIZE}}px;',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'layout-6', 'layout-3', 'slider' ],
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'view_details_color',
			[
				'label'      => esc_html__( 'Text Color', 'eduma' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '',
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-link-detail-color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'layout-6', 'layout-3', 'slider' ],
								],
							],
						],
					],
				],
			]
		);
		$this->add_control(
			'view_details_color_hover',
			[
				'label'      => esc_html__( 'Text Color Hover', 'eduma' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '',
				'selectors'  => [
					'{{WRAPPER}}' => '--thim-link-detail-color-hover: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'new_model',
						],
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'skin',
									'operator' => '==',
									'value'    => 'classic',
								],
								[
									'name'     => 'layout',
									'operator' => 'in',
									'value'    => [ 'layout-3', 'slider' ],
								],
							],
						],
					],
				],
			]
		);
		$this->end_controls_section();
	}

	protected function _register_item_view_all_settings() {

		$this->start_controls_section(
			'link_all_options',
			[
				'label'      => esc_html__( 'View All', 'eduma' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'skin',
							'operator' => '==',
							'value'    => 'classic',
						],
						[
							'name'     => 'layout',
							'operator' => 'in',
							'value'    => [ 'base', 'layout-2', 'layout-3', 'layout-4' ],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'link_all_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-list-event .view-all' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .thim-list-event .view-all' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_all_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-list-event .view-all'
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
					'{{WRAPPER}} .thim-list-event .view-all' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .thim-list-event .view-all' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_read' );

		$this->start_controls_tab(
			'link_all_tabnormal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'text_link_all_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .view-all' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_link_all_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .view-all' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'border_link_all_color',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .view-all' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'border_style!' => 'none'
				],
			]
		);
		$this->add_responsive_control(
			'border_link_all_radius',
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
					'{{WRAPPER}} .thim-list-event .view-all' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tabs_link_all_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'text_link_all_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .view-all:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_link_all_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .view-all:hover' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'border_link_all_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-list-event .view-all:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'border_style!' => 'none'
				],
			]
		);
		$this->add_responsive_control(
			'border_link_all_radius_hover',
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
					'{{WRAPPER}} .thim-list-event .view-all:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute(
			'_wrapper', 'class', 'thim-ekits-event-style'
		);
		// Map variables between Elementor and SiteOrigin
		if ( is_array( $settings['cat_id'] ) ) {
			$settings['cat_id'] = implode( ',', $settings['cat_id'] );
		}

		if ( strpos( $settings['cat_id'], 'all' ) ) {
			$settings['cat_id'] = 'all';
		}

		if ( isset( $settings['background_image'] ) ) {
			$settings['background_image'] = $settings['background_image']['id'];
		}

		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';
		if ( $settings['skin'] == 'new_model' ) {
			$this->render_event( $settings );
		} else {
			thim_ekit_get_widget_template( $this->get_base(), array(
				'instance' => $settings,
				'args'     => $args
			), $settings['layout'] );
		}
	}

	public function render_event( $settings ) {
		$list_status = $settings['status'] ? $settings['status'] : array( 'happening', 'upcoming' );
		$query_args  = array(
			'post_type'           => 'tp_event',
			'posts_per_page'      => $settings['number_posts'] ? $settings['number_posts'] : 3,
			'meta_query'          => array(
				array(
					'key'     => 'tp_event_status',
					'value'   => $list_status,
					'compare' => 'IN',
				),
			),
			'ignore_sticky_posts' => true
		);
		if ( $settings['cat_id'] && $settings['cat_id'] != 'all' ) {
			$list_cat_arr            = explode( ',', $settings['cat_id'] );
			$query_args['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'tp_event_category',
					'field'    => 'term_id',
					'terms'    => $list_cat_arr,
				),
			);
		}

		$events = new \WP_Query( $query_args );
		if ( $events->have_posts() ) {
			$class       = "thim-ekits-event";
			$class_inner = 'thim-ekits-event__inner';
			$class_item  = 'thim-ekits-event__item';
			if ( isset( $settings['layout_model'] ) && $settings['layout_model'] == 'slider' ) {
				$class       .= ' thim-ekits-sliders swiper-container';
				$class_inner = 'swiper-wrapper';
				$class_item  .= ' swiper-slide';
				if ( $settings['slider_show_pagination'] != 'none' ) : ?>
					<div
						class="thim-slider-pagination <?php echo 'thim-' . $settings['slider_show_pagination']; ?>"></div>
				<?php endif; ?>
				<?php if ( $settings['slider_show_arrow'] ) : ?>
					<div class="thim-slider-nav thim-slider-nav-prev">
						<?php
						Icons_Manager::render_icon( $settings['slider_arrows_left'], [ 'aria-hidden' => 'true' ] );
						?>
					</div>
					<div class="thim-slider-nav thim-slider-nav-next">
						<?php
						Icons_Manager::render_icon( $settings['slider_arrows_right'], [ 'aria-hidden' => 'true' ] );
						?>
					</div>
				<?php endif;
			}
			echo '<div class="' . esc_attr( $class ) . '"><div class="' . esc_attr( $class_inner ) . '">';
			while ( $events->have_posts() ) {
				$events->the_post();
//				$this->current_permalink = get_permalink();
//				$this->event_status      = get_post_meta( get_the_ID(), 'tp_event_status', true );
				?>
				<div <?php post_class( $class_item ); ?>>
					<?php $this->render_thumbnail( $settings ); ?>
					<div class="thim-ekits-event__content">
						<?php
						if ( $settings['repeater'] ) {
							foreach ( $settings['repeater'] as $item ) {
								switch ( $item['key'] ) {
									case 'title':
										$this->render_title( $item );
										break;
									case 'date_end':
										$this->render_date_end();
										break;
									case 'content':
										$this->render_excerpt( $item );
										break;
									case 'meta_data':
										$this->render_meta_data( $item );
										break;
									case 'read_more':
										$this->render_read_more( $item['read_more_text'] );
										break;
								}
							}
						}
						?>
					</div>
				</div>
				<?php
			}
			echo '</div></div>';
			wp_reset_postdata();
		}
	}

	protected function render_thumbnail( $settings ) {

		if ( ! $settings['show_image'] ) {
			return;
		}

		$settings['image_size'] = array(
			'id' => get_post_thumbnail_id()
		);

		$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_size' );
		if ( empty( $thumbnail_html ) ) {
			return;
		}
		$event_status = get_post_meta( get_the_ID(), 'tp_event_status', true );
		?>
		<div class="thim-ekits-event__thumbnail event-<?php echo $event_status; ?>">
			<a class="event-thumbnail" href="<?php echo get_permalink(get_the_ID()); ?>">
				<?php echo $thumbnail_html; ?>
			</a>
			<?php
			if ( $settings['show_label_status'] ) {
				$text_status  = '';
				switch ($event_status) {
					case 'upcoming':
 						$text_status  = esc_html__( 'Upcoming', 'eduma' );
						break;
					case 'expired':
						$text_status  = esc_html__( 'Expired', 'eduma' );
						break;
					case 'happening':
						$text_status  = esc_html__( 'Happening', 'eduma' );
					break;
				}
				echo '<div class="label-event-status">' . $text_status. '</div>';
			} ?>
		</div>

		<?php
	}

	protected function render_title( $item ) {

		$tag = Utils::validate_html_tag( $item['title_tag'] );
		?>
		<<?php echo $tag; ?> class="thim-ekits-event__title">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
		</<?php echo $tag; ?>>
		<?php
	}

	protected function render_date_end() {
		$date  = wpems_get_time( 'd' );
		$month = wpems_get_time( 'F' );
		echo '<div class="thim-ekits-event__date-month"><span class="date">' . $date . '</span><span class="month">' . $month . '</span></div>';
	}

	protected function render_excerpt( $item ) {
		?>
		<div class="thim-ekits-event__excerpt">
			<?php echo wp_trim_words( get_the_excerpt(), absint( $item['excerpt_lenght'] ), $item['excerpt_more'] ); ?>
		</div>

		<?php
	}

	protected function render_meta_data( $item ) {
		$meta_data   = $item['meta_data'];
		$time_format = get_option( 'time_format' );
		$time_start  = wpems_event_start( $time_format );
		$time_end    = wpems_event_end( $time_format );
		$location    = wpems_event_location();
		?>
		<div class="thim-ekits-event__meta">
			<?php
			if ( in_array( 'time_start_end', $meta_data ) ) {
				echo '<div class="time-start_end"><i class="tk tk-clock"></i>' . $time_start . ' - ' . $time_end . '</div>';
			}
			if ( in_array( 'location', $meta_data ) ) {
				echo '<div class="localtion"><i class="tk tk-map-marker"></i>' . $location . '</div>';
			}
			?>
		</div>
		<?php
	}

	protected function render_read_more( $text_read_more ) {
		?>
		<a class="thim-ekits-event__read-more" href="<?php the_permalink(); ?>">
			<?php echo esc_html( $text_read_more );
			?>
		</a>
		<?php
	}
}
