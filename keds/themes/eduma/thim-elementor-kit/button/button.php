<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Button extends Widget_Base {

	public function get_name() {
		return 'thim-button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-button';
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-button';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_tabs',
			[
				'label' => __( 'Content', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Button Text', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'READ MORE', 'eduma' ),
				'placeholder' => esc_html__( 'READ MORE', 'eduma' )
			]
		);

		$this->add_control(
			'url',
			[
				'label'       => esc_html__( 'Button URL', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'https://your-link.com', 'eduma' ),
				'default'     => '#',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'new_window',
			[
				'label'   => esc_html__( 'Open in New Window?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);
		$this->add_control(
			'nofollow',
			[
				'label'   => esc_html__( 'Add nofollow', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no'
			]
		);


		$this->add_control(
			'section_settings',
			[
				'label'     => esc_html__( 'Settings', 'eduma' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_group',
			[
				'label'     => esc_html__( 'Add icon? ', 'eduma' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => esc_html__( 'Yes', 'eduma' ),
				'label_off' => esc_html__( 'No', 'eduma' ),
			]
		);

		$this->add_control(
			'icons',
			[
				'label'            => esc_html__( 'Select Icon:', 'eduma' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block'      => false,
				'skin'             => 'inline',
				'condition'        => [
					'icon_group' => 'yes'
				]
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'before',
				'options'   => [
					'before' => esc_html__( 'Before', 'eduma' ),
					'after'  => esc_html__( 'After', 'eduma' ),
				],
				'condition' => [
					'icon_group' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'icon_align',
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}}.thim-widget-button' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_size',
			[
				'label'     => esc_html__( 'Button Size', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'normal' => esc_html__( 'Normal', 'eduma' ),
					'small'  => esc_html__( 'Small', 'eduma' ),
					'medium' => esc_html__( 'Medium', 'eduma' ),
					'large'  => esc_html__( 'Large', 'eduma' ),
				],
				'default'   => 'normal',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Button', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'     => esc_html__( 'Width (%)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .widget-button' => 'width: {{SIZE}}%;',
				]
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .widget-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .widget-button',
			]
		);

		$this->start_controls_tabs( 'tabs_style' );

		$this->start_controls_tab(
			'tabnormal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget-button' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget-button i'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .widget-button svg path' => 'fill: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget-button' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .widget-button:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'hover_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .widget-button:hover i'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .widget-button:hover svg path' => 'fill: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .widget-button:hover' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

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
					'{{WRAPPER}} .widget-button' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .widget-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'condition' => [
					'border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .widget-button' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .widget-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_border_hover',
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
				'condition' => [
					'border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .widget-button:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .widget-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_style',
			[
				'label'     => esc_html__( 'Icon', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon_group' => 'yes'
				]
			]
		);
		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => __( 'Icon Font Size (px)', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 14,
				'min'       => 0,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} .widget-button > i' => 'font-size: {{SIZE}}px;',
					'{{WRAPPER}} .widget-button > svg' => 'width: {{SIZE}}px;'
				),
			)
		);
		$this->add_responsive_control(
			'icon_padding_left',
			[
				'label'      => esc_html__( 'Add space after icon (px)', 'eduma' ),
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
					'size' => 5,
				],
				'selectors'  => [
					'{{WRAPPER}} .widget-button > i,{{WRAPPER}} .widget-button > svg'           => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .widget-button > i,.rtl {{WRAPPER}} .widget-button > svg' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
				'condition'  => [
					'icon_position' => 'before'
				]
			]
		);
		$this->add_responsive_control(
			'icon_padding_right',
			[
				'label'      => esc_html__( 'Add space before icon', 'eduma' ),
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
					'size' => 5,
				],
				'selectors'  => [
					'{{WRAPPER}} .widget-button > i,{{WRAPPER}} .widget-button > svg'      => 'margin-left: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .widget-button > i,.rtl {{WRAPPER}} .widget-button > svg' => 'margin-left: 0; margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'icon_position' => 'after'
				]
			]
		);

		$this->add_responsive_control(
			'icon_vertical_align',
			array(
				'label'      => esc_html__( 'Move icon  Vertically', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px'  => array(
						'min' => - 20,
						'max' => 20,
					),
					'em'  => array(
						'min' => - 5,
						'max' => 5,
					),
					'rem' => array(
						'min' => - 5,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .widget-button i,{{WRAPPER}} .widget-button svg' => ' -webkit-transform: translateY({{SIZE}}{{UNIT}}); -ms-transform: translateY({{SIZE}}{{UNIT}}); transform: translateY({{SIZE}}{{UNIT}})',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'box_shadow_style',
			[
				'label' => esc_html__( 'Shadow', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow_group',
				'selector' => '{{WRAPPER}} .widget-button',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		extract( $settings );
		$old_settings = $this->get_data( 'settings' );
		// Title
		$icon = $icon_size = $url_opt = $btn_class = $style = '';

		if ( isset( $settings['url'] ) && $settings['url'] ) {
			$url_opt = 'href="' . $settings['url'] . '"';
			$url_opt .= isset( $settings['new_window'] ) && $settings['new_window'] ? ' target="_blank"' : '';
			$url_opt .= isset( $settings['nofollow'] ) && $settings['nofollow'] ? ' rel="nofollow"' : '';
		}
		// old data
		if ( ! isset( $old_settings['typography_typography'] ) ) {
			if ( isset( $settings['font_size'] ) && $settings['font_size'] ) {
				$style .= "--widget-button-font-size: " . $settings['font_size'] . "px;";
			}
			if ( isset( $settings['font_weight'] ) && $settings['font_weight'] ) {
				$style .= "--widget-button-font-weight: " . $settings['font_weight'] . ";";
			}
		}
		if ( ! isset( $old_settings['border_dimensions'] ) ) {
			if ( isset( $settings['border_width'] ) && $settings['border_width'] ) {
				$style .= "--widget-button-border-width: {$settings['border_width']}px; border-style: solid;";
			}
		}
		if ( $style ) {
			$url_opt .= ' style="' . $style . '"';
		}

		$btn_class .= isset( $settings['button_size'] ) ? ' ' . $settings['button_size'] : '';
		$btn_class .= isset( $settings['rounding'] ) ? ' ' . $settings['rounding'] : '';

		// Icon Size
		if ( $icon_size ) {
			$icon_size = ' style="font-size: ' . $icon_size . 'px;"';
		}

		// Icon
		// new icon
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
					$icon = '<i class="' . $settings['icon'] . '"' . $icon_size . '></i> ';
				} else {
					$icon = '<i class="fa fa-' . $settings['icon'] . '"' . $icon_size . '></i> ';
				}
			}
		}

		if ( isset( $settings['icon_position'] ) && $settings['icon_position'] == 'after' ) {
			$content_button = $settings['title'] . $icon;
			$btn_class      .= ' position-after';
		} else {
			$content_button = $icon . $settings['title'];
		}

		echo '<a class="widget-button' . $btn_class . '" ' . $url_opt . '>' . $content_button . '</a>';

	}
}
