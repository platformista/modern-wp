<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Navigation_Menu extends Widget_Base {

	public function get_name() {
		return 'thim-navigation-menu';
	}

	public function get_title() {
		return esc_html__( 'Navigation Menu', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-link';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	public function get_navigation_menu() {
		$menus        = wp_get_nav_menus();
		$options      = array();
		$options['0'] = esc_html__( '&mdash; Select &mdash;', 'eduma' );

		foreach ( $menus as $menu ) {
			$options[$menu->term_id] = $menu->name;
		}

		return $options;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content',
			[
				'label' => esc_html__( 'Navigation Menu', 'eduma' )
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
			'line',
			[
				'label'   => esc_html__( 'Show Separator?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);
		$this->add_control(
			'menu',
			[
				'label'   => esc_html__( 'Select Menu', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_navigation_menu(),
				'default' => '0'
			]
		);

		$this->end_controls_section();
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


		$this->start_controls_section(
			'list_settings',
			[
				'label' => esc_html__( 'List', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'view',
			[
				'label'       => esc_html__( 'Layout', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'block',
				'options'     => [
					'block'  => [
						'title' => esc_html__( 'Default', 'eduma' ),
						'icon'  => 'eicon-editor-list-ul',
					],
					'inline' => [
						'title' => esc_html__( 'Inline', 'eduma' ),
						'icon'  => 'eicon-ellipsis-h',
					],
				],
				'label_block' => false,
				'selectors'   => [
					'{{WRAPPER}} .widget_nav_menu .menu .menu-item' => 'display: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'list_column',
			[
				'label'     => esc_html__( 'Coumn', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .widget_nav_menu .menu' => 'column-count: {{SIZE}};',
				],
				'condition' => [
					'view' => 'block'
				],
			]
		);

		$this->add_responsive_control(
			'list_margin',
			[
				'label'      => esc_html__( 'Margin (px)', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .widget_nav_menu .menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'text_settings',
			[
				'label' => esc_html__( 'Text', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .widget_nav_menu .menu a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .widget_nav_menu .menu a',
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
			'item_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget_nav_menu .menu a' => 'color: {{VALUE}};'
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
			'item_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget_nav_menu .menu a:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
		$this->start_controls_section(
			'separator_settings',
			[
				'label'     => esc_html__( 'Separator', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'line' => 'yes'
				],
			]
		);
		$this->add_control(
			'w_separator',
			[
				'label'     => esc_html__( 'Width (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .widget-title .line' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'h_separator',
			[
				'label'     => esc_html__( 'Height (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .widget-title .line' => 'height: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'bg_line',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget-title .line' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'margin_top_separator',
			[
				'label'     => esc_html__( 'Spacing Top (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .widget-title .line' => 'margin-top: {{SIZE}}px;',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$nav_menu = ! empty( $settings['menu'] ) ? wp_get_nav_menu_object( $settings['menu'] ) : false;

		echo '<div class="widget widget_nav_menu">';

		if ( isset( $settings['title'] ) && $settings['title'] ) {
			echo '<h4 class="widget-title">' . $settings['title'];
			if ( isset( $settings['line'] ) && $settings['line'] <> '' ) {
				echo '<span class="line"></span>';
			}
			echo '</h4>';
		}
		if ( $nav_menu ) {
			$nav_menu_args = array(
				'fallback_cb' => '',
				'menu'        => $nav_menu
			);
			wp_nav_menu( $nav_menu_args );

		} else {
			echo '<small>' . esc_html__( 'Edit widget and choose a menu', 'eduma' ) . '</small>';
		}

		echo '</div>';
	}
}
