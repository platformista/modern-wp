<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Video extends Widget_Base {

	public function get_name() {
		return 'thim-video';
	}

	public function get_title() {
		return esc_html__( 'Video', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-video';
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
				'label' => esc_html__( 'Video', 'eduma' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'        => esc_html__( 'Basic', 'eduma' ),
					'popup'       => esc_html__( 'Popup', 'eduma' ),
					'image-popup' => esc_html__( 'Image Popup', 'eduma' ),
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'video_width',
			[
				'label'       => esc_html__( 'Width video', 'eduma' ),
				'description' => esc_html__( 'Enter width of video. Example 100% or 600. ', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'video_height',
			[
				'label'       => esc_html__( 'Height video', 'eduma' ),
				'description' => esc_html__( 'Enter height of video. Example 100% or 600. ', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'video_type',
			[
				'label'   => esc_html__( 'Video Source', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'vimeo'   => esc_html__( 'Vimeo', 'eduma' ),
					'youtube' => esc_html__( 'Youtube', 'eduma' ),
				],
				'default' => 'vimeo'
			]
		);


		$this->add_control(
			'external_video',
			[
				'label'       => esc_html__( 'Vimeo Video ID', 'eduma' ),
				'description' => esc_html__( 'Enter vimeo video ID . Example if link video https://player.vimeo.com/video/61389324 then video ID is 61389324 ', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'video_type' => [ 'vimeo' ]
				]
			]
		);


		$this->add_control(
			'youtube_id',
			[
				'label'       => esc_html__( 'Youtube Video ID', 'eduma' ),
				'description' => esc_html__( 'Enter Youtube video ID . Example if link video https://www.youtube.com/watch?v=orl1nVy4I6s then video ID is orl1nVy4I6s ', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'video_type' => [ 'youtube' ]
				]
			]
		);

		$this->add_control(
			'poster',
			[
				'label'       => esc_html__( 'Poster', 'eduma' ),
				'description' => esc_html__( 'Poster background display on popup video', 'eduma' ),
				'type'        => Controls_Manager::MEDIA,
				'condition'   => [
					'layout' => [ 'popup', 'image-popup' ]
				]
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'eduma' ),
				'description' => esc_html__( 'Title display on popup video', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'layout' => [ 'popup']
				]
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'eduma' ),
				'description' => esc_html__( 'Description display on popup video', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'condition'   => [
					'layout' => [ 'popup']
				]
			]
		);

		$this->end_controls_section();

		$this->register_style_options();
	}

	protected function register_style_options() {
		$this->start_controls_section(
			'content_video',
			[
				'label' => __( 'Content', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'layout' =>  'popup',
				]
			]
		);

		$this->add_responsive_control(
			'content_pg_video',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-video-popup .video-info ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mw_content_video',
			[
				'label'     => esc_html__( 'Max Width (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
					'%' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info' => 'max-width: {{SIZE}}{{UNIT}}; margin: auto;',
				],
			]
		);

		$this->add_control(
			'color_background_overlay',
			[
				'label'     => esc_html__( 'Background Overlay', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup:before' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'button_popup_video',
			[
				'label' => __( 'Video Button', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'layout' =>  'popup',
				]
			]
		);

		$this->add_responsive_control(
			'w_button_popup_video',
			[
				'label'     => esc_html__( 'Width (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'h_button_popup_video',
			[
				'label'     => esc_html__( 'Height (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup' => 'height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'font_size_icon_video',
			[
				'label'     => __( 'Icon Font Size (px)', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'step'      => 2,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup i' => 'font-size: {{VALUE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'line-height_icon_video',
			[
				'label'     => __( 'Icon Line Height (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup i' => 'line-height: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_border_style',
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
				'default'   => 'solid',
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'button_icon_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_button_popup_style' );
		$this->start_controls_tab(
			'tab_icon_button_popup_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'color_icon_popup_video',
			[
				'label'     => esc_html__( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup i' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'color_icon_bg_popup_video',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'button_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_icon_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_button_popup_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);

		$this->add_control(
			'color_icon_popup_video_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup:hover i' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'color_icon_bg_popup_video_hover',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup:hover' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'button_icon_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_icon_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .button-popup:hover' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'title_video',
			[
				'label' => __( 'Video Content', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'layout' =>  'popup',
				]
			]
		);

		$this->add_responsive_control(
			'custom_mg_title',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-video-popup .video-info .video-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'font_title_video',
				'label'    => esc_html__( 'Typography Title', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-video-popup .video-info .video-title',
			]
		);

		$this->add_control(
			'color_title_video',
			[
				'label'     => esc_html__( 'Title Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .video-title' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'font_description_video',
				'label'    => esc_html__( 'Typography Description', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-video-popup .video-info .video-description',
			]
		);

		$this->add_control(
			'color_description_video',
			[
				'label'     => esc_html__( 'Description Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-video-popup .video-info .video-description' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings            = $this->get_settings_for_display();
		$settings ['poster'] = isset( $settings['poster'] ) ? $settings['poster']['id'] : '';
		thim_ekit_get_widget_template( $this->get_base(), array( 'instance' => $settings ), $settings['layout'] );
	}

}
