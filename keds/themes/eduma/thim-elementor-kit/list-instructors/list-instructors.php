<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_List_Instructors extends Widget_Base {

	public function get_name() {
		return 'thim-list-instructors';
	}

	public function get_title() {
		return esc_html__( 'List Instructors', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-one-course-instructors';
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
				'label' => esc_html__( 'List Instructors', 'eduma' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base' => esc_html__( 'Default', 'eduma' ),
					'new'  => esc_html__( 'New', 'eduma' ),
					'grid'  => esc_html__( 'Grid', 'eduma' )
				],
				'default' => 'base'
			]
		);
		$this->add_control(
			'limit_instructor',
			[
				'label'     => esc_html__( 'Limit', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 0,
				'step'      => 1,
				'condition' => [
					'layout' => [ 'base' ]
				]
			]
		);
		$this->add_control(
			'visible_item',
			[
				'label'   => esc_html__( 'Visible Instructors', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 0,
				'step'    => 1,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 2,
				'max'     => 5,
				'step'    => 1,
				'condition' => [
					'layout' => [ 'grid' ]
				]
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'   => esc_html__( 'Show Pagination?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'layout!' => [ 'grid' ]
				]
			]
		);
		$this->add_control(
			'show_navigation',
			[
				'label'   => esc_html__( 'Show navigation?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'layout!' => [ 'grid' ]
				]
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
				'step'        => 100,
				'condition' => [
					'layout!' => [ 'grid' ]
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'panel_img',
			[
				'label'   => esc_html__( 'Avatar', 'eduma' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'panel_id',
			[
				'label'   => esc_html__( 'Instructor', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => thim_get_instructors( array( '' => esc_html__( 'Select', 'eduma' ) ) ),
				'default' => '',
			]
		);

		$this->add_control(
			'panel',
			[
				'label'     => esc_html__( 'Select Instructor', 'eduma' ),
				'type'      => Controls_Manager::REPEATER,
				'separator' => 'before',
				'fields'    => $repeater->get_controls(),
				'condition' => [
					'layout' => [ 'new' ]
				]
			]
		);

		$this->end_controls_section();
		$this->_register_style_settings();
	}


	protected function _register_style_settings() {

		$this->start_controls_section(
			'section_style_setting',
			array(
				'label' => esc_html__( 'Setting', 'eduma' ),
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
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .name',
				'exclude'  => [ 'letter_spacing', 'word_spacing' ],
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
					'{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .name a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'text_title_hover',
			[
				'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label'        => esc_html__( 'Title Hover', 'eduma' ),
				'label_off'    => esc_html__( 'Default', 'eduma' ),
				'label_on'     => esc_html__( 'Custom', 'eduma' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();
		$this->add_control(
			'title_text_color_hover',
			array(
				'label'     => esc_html__( 'Text Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .name a:hover' => 'color: {{VALUE}};',
				),
				'condition' => [
					'text_title_hover' => 'yes'
				],
			)
		);
		$this->add_control(
			'text_title_decoration_hover',
			array(
				'label'     => esc_html__( 'Decoration', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''             => esc_html__( 'Default', 'eduma' ),
					'underline'    => esc_html__( 'Underline', 'eduma' ),
					'overline'     => esc_html__( 'Overline', 'eduma' ),
					'line-through' => esc_html__( 'Line Through', 'eduma' ),
					'none'         => esc_html__( 'None', 'eduma' ),
				],
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .name a:hover' => 'text-decoration: {{VALUE}};',
				),
			)
		);

		$this->end_popover();

		$this->add_control(
			'heading_desc_style',
			array(
				'label'     => esc_html__( 'Description', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout!' => [ 'grid' ]
				]
			)
		);
		$this->add_control(
			'desc_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .description' => 'color: {{VALUE}};',
				),
				'condition' => [
					'layout!' => [ 'grid' ]
				]
			)
		);

		$this->add_control(
			'instructor_position_style',
			array(
				'label'     => esc_html__( 'Position', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout' => [ 'grid' ]
				]
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'position_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .job',
				'condition' => [
					'layout' => [ 'grid' ]
				]
			)
		);

		$this->add_control(
			'position_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .job' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);


		$this->add_control(
			'position_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .instructor-info .job' => 'color: {{VALUE}};',
				),
				'condition' => [
					'layout' => [ 'grid' ]
				]
			)
		);

		$this->add_control(
			'heading_avatar_style',
			array(
				'label'     => esc_html__( 'Avatar', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_responsive_control(
			'content_avatar_padding',
			array(
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .instructor-item .avatar_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'content_avatar_margin',
			array(
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .instructor-item .avatar_item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'avatar_border',
				'selector' => '{{WRAPPER}} .instructor-item .avatar_item',
			)
		);
		$this->add_control(
			'avatar_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .instructor-item .avatar_item, {{WRAPPER}} .instructor-item .avatar_item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .instructor-item .avatar_item:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'background_overlay_hover',
			array(
				'label'     => esc_html__( 'Overlay Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-list-instructors.instructor-grid .instructor-item:hover .avatar_item::before' => 'background: {{VALUE}}',
				),
				'condition' => [
					'layout' => [ 'grid' ]
				]
			)
		);
		$this->add_control(
			'heading_social_style',
			array(
				'label'     => esc_html__( 'Social', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'social_text_color',
			array(
				'label'     => esc_html__( 'Social Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .thim-author-social li a:not(:hover)' => 'color: {{VALUE}};border-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'social_hover_color',
			array(
				'label'     => esc_html__( 'Social Hover Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-list-instructors .info_ins .thim-author-social li a:hover' => 'color: {{VALUE}};',
				),
				'condition' => [
					'layout' => [ 'grid' ]
				]
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Map variables between Elementor and SiteOrigin
		$instance = array(
			'layout'           => $settings['layout'],
			'limit_instructor' => $settings['limit_instructor'],
			'visible_item'     => $settings['visible_item'],
			'show_pagination'  => $settings['show_pagination'],
			'show_navigation'  => $settings ['show_navigation'],
			'thim_kits_class'  => 'thim-ekits-list-instructors',
			'auto_play'        => $settings['auto_play'],
			'panel'            => $settings['panel'],
			'columns'          => $settings['columns'],
		);

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $instance
		), $settings['layout'] );
	}

}
