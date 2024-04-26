<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Single_Images extends Widget_Base {

	public function get_name() {
		return 'thim-single-images';
	}

	public function get_title() {
		return esc_html__( 'Single Images', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-single-images';
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
				'label' => esc_html__( 'Single Images', 'eduma' )
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'     => esc_html__( 'Default', 'eduma' ),
					'layout-2' => esc_html__( 'Show Image Title', 'eduma' ),
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'image_hover',
			[
				'label'     => esc_html__( 'Image Hover', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''          => esc_html__( 'Preset 1', 'eduma' ),
					'svg-hover' => esc_html__( 'Preset 2', 'eduma' ),
				],
				'default'   => '',
				'condition' => array(
					'layout' => [ 'layout-2' ],
				)
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Upload Image', 'eduma' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);

		$this->add_control(
			'image_title',
			[
				'label'       => esc_html__( 'Image Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'layout' => [ 'layout-2' ]
				]
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'on_click_action',
			[
				'label'   => esc_html__( 'On click action', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'        => esc_html__( 'none', 'eduma' ),
					'custom-link' => esc_html__( 'Open custom link', 'eduma' ),
					'popup'       => esc_html__( 'Open popup', 'eduma' ),
				],
				'default' => 'none'
			]
		);

		$this->add_control(
			'image_link',
			[
				'label'       => esc_html__( 'Image Link', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'on_click_action' => [ 'custom-link' ]
				]
			]
		);

		$this->add_control(
			'link_target',
			[
				'label'     => esc_html__( 'Link Target', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'_self'  => esc_html__( 'Same window', 'eduma' ),
					'_blank' => esc_html__( 'New window', 'eduma' )
				],
				'default'   => '_self',
				'condition' => [
					'on_click_action' => [ 'custom-link' ]
				]
			]
		);
		$this->add_control(
			'image_alignment',
			[
				'label'     => esc_html__( 'Text Alignment', 'eduma' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'eduma' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'eduma' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'eduma' ),
						'icon'  => 'eicon-text-align-right',
					]
				],
				'default'   => 'left',
				'selectors' => [
					'.single-image.template-layout-2 .single-image-hover' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_image',
			[
				'label'     => esc_html__( 'Style Title', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layout' => [ 'layout-2' ],
				)
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .single-image .single-image-hover .inner-info'
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color Text', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-image .single-image-hover .inner-info,
					{{WRAPPER}} .single-image .single-image-hover i' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label'     => esc_html__( 'Background Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-image.template-layout-2.svg-hover .single-image-hover,
					 {{WRAPPER}} .template-layout-2:not(.svg-hover) .single-image-hover' => 'background-color: {{VALUE}};'
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
					'{{WRAPPER}} .single-image .single-image-hover .inner-info'                                   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .single-image .single-image-hover i'                                             => 'padding-left:  {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .single-image.template-layout-2:not(.svg-hover) .single-image-hover .inner-info' => 'padding-top:0',
				],
			]
		);

		$this->add_responsive_control(
			'height_svg',
			[
				'label'      => esc_html__( 'Height (%)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					]
				],
				'selectors'  => [
					'{{WRAPPER}} .single-image.template-layout-2.svg-hover .single-image-hover' => 'height: {{SIZE}}%;',
				],
				'condition'  => array(
					'image_hover' => [ 'svg-hover' ],
				)
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$link_before     = $after_link = '';
		$layout_template = $settings['layout'];
		$layout_template .= $settings['image_hover'] ? ' ' . $settings['image_hover'] : '';


		if ( isset( $settings['image'] ) && isset( $settings['image']['id'] ) ) {
			if ( isset( $settings['on_click_action'] ) && $settings['on_click_action'] == 'custom-link' && isset( $settings['image_link'] ) && $settings['image_link'] ) {
				$link_before = '<a target="' . $settings['link_target'] . '" href="' . $settings['image_link'] . '">';
				$after_link  = '</a>';
			} elseif ( isset( $settings['on_click_action'] ) && $settings['on_click_action'] == 'popup' ) {
				$src = wp_get_attachment_image_src( $settings['image']['id'], 'full' );
				if ( $src ) {
					$link_before = '<a href="' . $src[0] . '">';
					$after_link  = '</a>';
				}
			}

			echo '<div class="single-image template-' . $layout_template . '">' . $link_before;

			if ( $settings['image_size'] == 'custom' ) {
				$w          = isset( $settings['image_custom_dimension']['width'] ) ? $settings['image_custom_dimension']['width'] : '150';
				$h          = isset( $settings['image_custom_dimension']['height'] ) ? $settings['image_custom_dimension']['height'] : '150';
				$image_size = array( $w, $h );
			} else {
				$image_size = $settings['image_size'];
			}

			echo wp_get_attachment_image( $settings['image']['id'], $image_size );

			if ( $settings['layout'] == 'layout-2' ) {
				echo '<div class="single-image-hover">';
				echo '<i class="fas fa-expand"></i>';
				if ( isset( $settings['image_title'] ) ) {
					echo '<span class="inner-info">' . $settings['image_title'] . '</span>';
				}
				echo '</div>';
			}

			echo $after_link . '</div>';
		}
	}
}
