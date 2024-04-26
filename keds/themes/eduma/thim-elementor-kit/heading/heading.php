<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Heading extends Widget_Base {

	public function get_name() {
		return 'thim-heading';
	}

	public function get_title() {
		return esc_html__( 'Heading', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-heading';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

	protected function get_html_wrapper_class() {
		return 'thim-ekits-heading elementor-widget-' . $this->get_name();
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
				'label'       => esc_html__( 'Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' )
			]
		);
		$this->add_control(
			'main_title',
			[
				'label'       => esc_html__( 'Main Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'description' => esc_html__( 'Write the Main title for the heading.', 'eduma' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => esc_html__( 'HTML Tag', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'sub_heading',
			[
				'label'       => esc_html__( 'Sub Title', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'sub_position',
			[
				'label'   => esc_html__( 'Sub Title Position', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'before_title' => esc_html__( 'Before Title', 'eduma' ),
					'after_title'  => esc_html__( 'After Title', 'eduma' )
				],
				'default' => 'after_title',
			]
		);

		$this->add_control(
			'clone_title',
			[
				'label'   => esc_html__( 'Clone Title?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'line',
			[
				'label'   => esc_html__( 'Show Separator?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'        => esc_html__( 'Text Alignment', 'eduma' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'text-left'   => [
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => esc_html__( 'Center', 'eduma' ),
						'icon'  => 'eicon-text-align-center',
					],
					'text-right'  => [
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-text-align-right',
					]
				],
				'prefix_class' => 'thim-ekits-heading-%s',
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
					'{{WRAPPER}} .sc_heading .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .sc_heading .title',
			]
		);
		$this->add_control(
			'textcolor',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sc_heading .title,{{WRAPPER}} .sc_heading .clone' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'main_title_color',
			[
				'label'     => esc_html__( 'Main Title Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sc_heading .title .thim-color' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sub_title_settings',
			[
				'label' => esc_html__( 'Sub Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'sub_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sc_heading .sub-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .sc_heading .sub-heading',
			]
		);
		$this->add_control(
			'sub_heading_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sc_heading .sub-heading' => 'color: {{VALUE}};'
				]
			]
		);
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
					'{{WRAPPER}} .sc_heading .line' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'h_separator',
			[
				'label'     => esc_html__( 'Height (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .sc_heading .line' => 'height: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'bg_line',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sc_heading .line' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->render_html( $settings );
	}

	public function render_html( $settings ) {

		$class = '';
		if ( isset( $settings['text_align'] ) ) {
			$class .= ' ' . $settings['text_align'];
		}
		$title_main = ( isset( $settings['main_title'] ) && $settings['main_title'] != '' ) ? ' <span class="thim-color">' . $settings['main_title'] . '</span>' : '';

		$class .= ! empty( $settings['clone_title'] ) ? ' clone_title' : '';
		echo '<div class="sc_heading' . $class . '">';
		if ( isset( $settings['sub_heading'] ) && $settings['sub_heading'] <> '' && $settings['sub_position'] == 'before_title' ) {
			echo '<div class="sub-heading">' . wpautop( $settings['sub_heading'] ) . '</div>';
		}

		if ( isset( $settings['title'] ) && $settings['title'] ) {
			$title_tag = Utils::validate_html_tag( $settings['size'] );
			echo sprintf( '<%s class="title">%s %s</%s>', $title_tag, wp_kses_post( $settings['title'] ), $title_main, $title_tag );
		}
		if ( isset( $settings['clone_title'] ) && isset( $settings['title'] ) && $settings['clone_title'] ) {
			echo '<div class="clone">' . wp_kses_post( $settings['title'] ) . '</div>';
		}
		if ( isset( $settings['sub_heading'] ) && $settings['sub_heading'] <> '' && $settings['sub_position'] == 'after_title' ) {
			echo '<div class="sub-heading">' . wpautop( $settings['sub_heading'] ) . '</div>';
		}
		if ( isset( $settings['line'] ) && $settings['line'] <> '' ) {
			echo '<span class="line"></span>';
		}
		echo '</div>';
	}
}
