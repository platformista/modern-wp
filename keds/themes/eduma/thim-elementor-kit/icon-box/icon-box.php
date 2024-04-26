<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Icon_Box extends Widget_Base {

	public function get_name() {
		return 'thim-icon-box';
	}

	public function get_title() {
		return esc_html__( 'Icon Box', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-icon-box';
	}

	public function get_categories() {
		return [ 'thim_ekit' ];
	}

//	protected function get_html_wrapper_class() {
//		return 'thim-widget-icon-box';
//	}

	protected function register_controls() {
		$this->register_style_heading();
		$this->register_style_description();
		$this->register_style_icons();
		$this->register_style_link();


		$this->start_controls_section(
			'layout_group',
			[
				'label' => esc_html__( 'Layout Options', 'eduma' ),
			]
		);

		$this->add_control(
			'pos',
			[
				'label'   => esc_html__( 'Box Style:', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					"left"  => esc_html__( "Icon at Left", 'eduma' ),
					"right" => esc_html__( "Icon at Right", 'eduma' ),
					"top"   => esc_html__( "Icon at Top", 'eduma' )
				],
				'default' => 'top'
			]
		);

		$this->add_responsive_control(
			'text_align_sc',
			[
				'label'        => esc_html__( 'Text Align Shortcode:', 'eduma' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					"text-left"   => esc_html__( "Text Left", 'eduma' ),
					"text-right"  => esc_html__( "Text Right", 'eduma' ),
					"text-center" => esc_html__( "Text Center", 'eduma' )
				],
				'default'      => 'text-left',
				'prefix_class' => 'iconbox-%s',
			]
		);

		$this->add_control(
			'style_box',
			[
				'label'   => esc_html__( 'Type Icon Box', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					""             => esc_html__( "Default", 'eduma' ),
					"overlay"      => esc_html__( "Overlay", 'eduma' ),
					"contact_info" => esc_html__( "Contact Info", 'eduma' ),
					"image_box"    => esc_html__( "Image Box", 'eduma' ),
				],
				'default' => ''
			]
		);

		$this->add_control(
			'dot_line',
			[
				'label'       => esc_html__( 'Dot - Line Top Button', 'eduma' ),
				'description' => esc_html__( 'Show line center of the dot from top page to bottom page', 'eduma' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'condition'   => [
					'style_box' => [ 'contact_info' ]
				]
			]
		);

		$this->add_control(
			'bg_image_box',
			[
				'label'     => esc_html__( 'Select background image', 'eduma' ),
				'type'      => Controls_Manager::MEDIA,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon' => 'background-image: url("{{URL}}");background-repeat:no-repeat;',
				],
				'condition' => [
					'style_box' => [ 'image_box' ]
				],
			]
		);
		$this->add_control(
			'bg_image_pos',
			[
				'label'       => __( 'Background Position', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'input position of background image.Ex: top left', 'eduma' ),
				'selectors'   => [
					'{{WRAPPER}} .wrapper-box-icon' => 'background-position:{{VAULE}};',
				],
				'condition'   => [
					'style_box' => [ 'image_box' ]
				]
			]
		);
		$this->add_responsive_control(
			'bg_image_size',
			[
				'label'     => esc_html__( 'Size', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				//				'responsive' => true,
				'default'   => '',
				'options'   => [
					''        => esc_html__( 'Default', 'eduma' ),
					'auto'    => esc_html__( 'Auto', 'eduma' ),
					'cover'   => esc_html__( 'Cover', 'eduma' ),
					'contain' => esc_html__( 'Contain', 'eduma' ),
				],
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon' => 'background-size: {{VALUE}};',
				],
				'condition' => [
					'style_box' => [ 'image_box' ]
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'widget_setting',
			[
				'label' => esc_html__( 'Widget Setting', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'widget_background',
			[
				'label'     => esc_html__( 'Widget Background', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					"none"     => esc_html__( "None", 'eduma' ),
					"bg_color" => esc_html__( "Background Color", 'eduma' ),
					"bg_video" => esc_html__( "Video Background", 'eduma' )
				],
				'default'   => 'none',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'bg_box_color',
			[
				'label'     => esc_html__( 'Background Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'widget_background' => [ 'bg_color' ]
				]
			]
		);

		$this->add_control(
			'self_video',
			[
				'label'       => esc_html__( 'Select video', 'eduma' ),
				'description' => esc_html__( 'Select an uploaded video in mp4 format. Other formats, such as webm and ogv will work in some browsers. You can use an online service such as \'http://video.online-convert.com/convert-to-mp4\' to convert your videos to mp4.', 'eduma' ),
				'type'        => Controls_Manager::MEDIA,
				'media_type'  => 'video',
				'condition'   => [
					'widget_background' => [ 'bg_video' ]
				],
			]
		);

		$this->add_control(
			'self_poster',
			[
				'label'     => esc_html__( 'Select cover image', 'eduma' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'widget_background' => [ 'bg_video' ]
				]
			]
		);
		$this->end_controls_section();
	}

	protected function register_style_heading() {
		$this->start_controls_section(
			'title_group',
			[
				'label' => __( 'Title', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$this->add_control( 
			'size',
			[
				'label'   => __( 'HTML Tag', 'eduma' ),
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
			'line_after_title',
			[
				'label'   => __( 'Show Separator?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'options' => [
					true  => __( 'Yes', 'eduma' ),
					false => __( 'No', 'eduma' ),
				],
				'default' => false
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
			'custom_mg_bt',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wrapper-box-icon .sc-heading .heading__primary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'font_heading',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .wrapper-box-icon .sc-heading .heading__primary',
			]
		);
		$this->add_control(
			'color_title',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .sc-heading .heading__primary, {{WRAPPER}} .wrapper-box-icon .sc-heading .heading__primary a' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'color_title_hover',
			[
				'label'     => esc_html__( 'Link Hover Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .sc-heading .heading__primary a:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'separator_settings',
			[
				'label'     => esc_html__( 'Separator', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'line_after_title' => 'yes'
				],
			]
		);
		$this->add_responsive_control(
			'w_separator',
			[
				'label'     => esc_html__( 'Width (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .sc-heading .line-heading' => 'width: {{SIZE}}px;',
				],
			]
		);
		$this->add_responsive_control(
			'h_separator',
			[
				'label'     => esc_html__( 'Height (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .sc-heading .line-heading' => 'height: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'bg_line',
			[
				'label'     => esc_html__( 'Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .sc-heading .line-heading' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_description() {
		$this->start_controls_section(
			'desc_group',
			[
				'label' => __( 'Description', 'eduma' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => __( 'Add Description', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'desc_settings',
			[
				'label' => esc_html__( 'Description', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'desc_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wrapper-box-icon .desc-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'custom_font_size_des',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .wrapper-box-icon .desc-content',
			]
		);
		$this->add_control(
			'color_description',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .desc-content' => 'color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_section();

	}

	protected function register_style_icons() {

		$this->start_controls_section(
			'icon_group',
			[
				'label' => __( 'Icon', 'eduma' ),
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'   => __( 'Icon Type', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					"font-awesome"  => esc_html__( "Font Awesome Icon", 'eduma' ),
					"font_ionicons" => esc_html__( "Ionicons", 'eduma' ),
					"font-7-stroke" => esc_html__( "Font 7 stroke Icon", 'eduma' ),
					"font-flaticon" => esc_html__( "Font Flat Icon", 'eduma' ),
					"custom"        => esc_html__( "Custom Image", 'eduma' ),
					"text_number"   => esc_html__( "Text Number", 'eduma' )
				],
				'default' => 'font-awesome'
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

				'condition' => [
					'icon_type' => [ 'font-awesome' ]
				]
			]
		);


		$this->add_control(
			'flat_icon',
			[
				'label'       => esc_html__( 'Select Icon:', 'eduma' ),
				'type'        => Controls_Manager::ICON,
				'placeholder' => esc_html__( 'Choose...', 'eduma' ),
				'options'     => apply_filters( 'thim-builder-el-flat_icon-icon', array() ),
				'exclude'     => array_keys( Control_Icon::get_icons() ),
				'condition'   => [
					'icon_type' => [ 'font-flaticon' ]
				]
			]
		);
		$this->add_control(
			'font_ionicons',
			[
				'label'       => esc_html__( 'Select Icon:', 'eduma' ),
				'type'        => Controls_Manager::ICON,
				'placeholder' => esc_html__( 'Choose...', 'eduma' ),
				'options'     => apply_filters( 'thim-builder-el-ionicons-icon', array() ),
				'exclude'     => array_keys( Control_Icon::get_icons() ),
				'condition'   => [
					'icon_type' => [ 'font_ionicons' ]
				]
			]
		);

		$this->add_control(
			'stroke_icon',
			[
				'label'       => esc_html__( 'Select Icon:', 'eduma' ),
				'type'        => Controls_Manager::ICON,
				'placeholder' => esc_html__( 'Choose...', 'eduma' ),
				'options'     => apply_filters( 'thim-builder-el-stroke_icon-icon', array() ),
				'exclude'     => array_keys( Control_Icon::get_icons() ),
				'condition'   => [
					'icon_type' => [ 'font-7-stroke' ]
				]
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Icon Font Size (px)', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 14,
				'min'       => 0,
				'step'      => 1,
				'condition' => [
					'icon_type!' => [ 'custom' ]
				],
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon' => 'font-size: {{VALUE}}px;',
				],
			]
		);


		$this->add_control(
			'icon_img',
			[
				'label'     => esc_html__( 'Choose Image', 'eduma' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'icon_type' => [ 'custom' ]
				]
			]
		);
		$this->add_control(
			'text_number',
			[
				'label'       => __( 'Number', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'icon_type' => [ 'text_number' ]
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_setting',
			[
				'label' => esc_html__( 'Icon', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width_icon_box',
			[
				'label'      => esc_html__( 'Width Box Icon (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon'                                      => 'width: {{SIZE}}px;',
					'{{WRAPPER}} .wrapper-box-icon .iconbox-left .content-inner,
					{{WRAPPER}} .wrapper-box-icon .iconbox-right .content-inner' => 'width: calc(100% - {{SIZE}}px - 15px);',
				],
			]
		);

		$this->add_responsive_control(
			'height_icon_box',
			[
				'label'      => esc_html__( 'Height Box Icon (px)', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon' => 'height: {{SIZE}}px; line-height: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin_btn',
			[
				'label'     => esc_html__( 'Margin Bottom (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .thim-widget-icon-box .wrapper-box-icon .boxes-icon' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_style',
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
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'icon_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_color_icon_border_style' );
		$this->start_controls_tab(
			'tab_color_color_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon'                               => 'color: {{VALUE}};',
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon .icon svg path:not(.nochange)' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .dot_line_buttom_top .dot-line,
					{{WRAPPER}} .dot_line_buttom_top .dot-line span'      => 'color: {{VALUE}};background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_color',
			[
				'label'     => esc_html__( 'Border Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'     => esc_html__( 'Background Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_icon_radius',
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
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_color_icon_border_hover',
			[
				'label' => esc_html__( 'Hover', 'eduma' ),
			]
		);
		$this->add_control(
			'icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color:', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'border_icon_radius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wrapper-box-icon .boxes-icon:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	protected function register_style_link() {
		$this->start_controls_section(
			'read_more_group',
			[
				'label' => __( 'Link', 'eduma' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'         => __( 'URL', 'eduma' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'eduma' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'read_more',
			[
				'label'   => __( 'Apply to', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					"complete_box" => esc_html__( "Complete Box", 'eduma' ),
					"title"        => esc_html__( "Box Title", 'eduma' ),
					"link_icon"    => esc_html__( "Link To Icon", 'eduma' ),
					"more"         => esc_html__( "Display Read More", 'eduma' ),
				],
				'default' => 'complete_box'
			]
		);
		$this->add_control(
			'link_image_title',
			[
				'label'     => __( 'Enable URL Tile & Icon', 'eduma' ),
				'type'      => Controls_Manager::SWITCHER,
				'options'   => [
					true  => __( 'Yes', 'eduma' ),
					false => __( 'No', 'eduma' ),
				],
				'default'   => false,
				'condition' => [
					'read_more' => [ 'more' ]
				]
			]
		);
		$this->add_control(
			'read_text',
			[
				'label'       => __( 'Read More Text', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'default'     => esc_html__( 'Read More', 'eduma' ),
				'label_block' => true,
				'condition'   => [
					'read_more' => [ 'more' ]
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'link_read_more_style_tabs',
			[
				'label'     => esc_html__( 'Read More', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'read_more' => [ 'more' ]
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
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_read_more_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read',
			]
		);

		$this->add_responsive_control(
			'link_read_more_style',
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
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'link_read_more_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_color_link_read_more_style' );
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
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_read_more_text',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_read_more_text',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'border_read_more_text_hover',
			[
				'label'     => __( 'Border Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'bg_read_more_text_hover',
			[
				'label'     => __( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .wrapper-box-icon .content-inner .smicon-read:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}


	protected function render_title( $settings ) {
		$html_title = $css_old_custom = '';
		if ( isset( $settings['link'] ) && ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'render_link_title', $settings['link'] );
		}
		// add link for title
		$before_link_title = ( $settings['link_image_title'] == true || $settings['read_more'] == 'title' || $settings['read_more'] == 'complete_box' ) && $this->get_render_attribute_string( 'render_link_title' ) ? '<a class="icon-box-link" ' . $this->get_render_attribute_string( 'render_link_title' ) . '>' : '';
		$after_link_title  = $before_link_title ? '</a>' : '';
		$tag = Utils::validate_html_tag($settings['size']);
		if ( isset( $settings['title'] ) && $settings['title'] ) {
			$html_title .= '<div class="sc-heading">';
			$html_title .= '<' . $tag . ' class="heading__primary"' . $this->render_style_old_title() . '>';
			$html_title .= $before_link_title . $settings['title'] . $after_link_title;
			$html_title .= '</' . $tag . '>';
			if ( isset( $settings['line_after_title'] ) && $settings['line_after_title'] ) {
				$html_title .= '<span class="line-heading"></span>';
			}
			$html_title .= '</div>';
		}

		return $html_title;
	}

	protected function render_icon( $settings ) {

		if ( isset( $settings['link'] ) && ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'render_link_icon', $settings['link'] );
		}
		// old data $icon_layout
		$icon_layout = ( isset( $settings['box_icon_style'] ) && $settings['box_icon_style'] ) ? ' ' . $settings['box_icon_style'] : '';
		if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font-awesome' ) {
			// new icon
			$migrated = isset( $settings['__fa4_migrated']['icons'] );
			// Check if its a new widget without previously selected icon using the old Icon control
			$is_new = empty( $settings['icon'] );
			if ( $is_new || $migrated ) {
				// new icon
				ob_start();
				Icons_Manager::render_icon( $settings['icons'], [ 'aria-hidden' => 'true' ] );
				$html_icon = '<span class="icon">' . ob_get_contents() . '</span>';
				ob_end_clean();
			} else {
				if ( isset( $settings['icon'] ) ) {
					if ( strpos( $settings['icon'], 'fa' ) !== false ) {
						$html_icon = '<span class="icon"><i class="' . $settings['icon'] . '"></i></span>';
					} else {
						$html_icon = '<span class="icon"><i class="fa fa-' . $settings['icon'] . '"></i></span>';
					}
				}
			}
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font-7-stroke' ) {
			wp_enqueue_style( 'font-pe-icon-7' );
			$html_icon = isset( $settings['stroke_icon'] ) && $settings['stroke_icon'] != 'none' ? '<span class="icon"><i class="' . $settings['stroke_icon'] . '"></i></span>' : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'icomoon' ) {
			wp_enqueue_style( 'thim-linearicons-font' );
			$html_icon = isset( $settings['font_ionicons'] ) && $settings['font_ionicons'] != 'none' ? '<span class="icon"><i class="' . $settings['font_ionicons'] . '"></i></span>' : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font-flaticon' ) {
			wp_enqueue_style( 'flaticon' );
			$html_icon = isset( $settings['flat_icon'] ) && $settings['flat_icon'] != 'none' ? '<span class="icon"><i class="' . $settings['flat_icon'] . '"></i></span>' : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font_ionicons' ) {
			wp_enqueue_style( 'ionicons' );
			$html_icon = isset( $settings['font_ionicons'] ) && $settings['font_ionicons'] != 'none' ? '<span class="icon"><i class="' . $settings['font_ionicons'] . '"></i></span>' : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'text_number' ) {
			$html_icon = isset( $settings['text_number'] ) && $settings['text_number'] ? '<span class="text-number-icon">' . $settings['text_number'] . '</span>' : '';
		} else {
			$html_icon = isset( $settings['icon_img'] ) && $settings['icon_img']['id'] ? '<span class="icon icon-images">' . thim_get_feature_image( $settings['icon_img']['id'] ) . '</span>' : '';
		}
		// add link for icon
		$before_link_icon = ( $settings['link_image_title'] == true || $settings['read_more'] == 'link_icon' || $settings['read_more'] == 'complete_box' ) && $this->get_render_attribute_string( 'render_link_icon' ) ? '<a class="icon-box-link" ' . $this->get_render_attribute_string( 'render_link_icon' ) . '>' : '';
		$after_link_icon  = $before_link_icon ? '</a>' : '';

		return '<div class="boxes-icon' . $icon_layout . '"' . $this->render_style_old_icon( $settings ) . '>' . $before_link_icon . '<span class="inner-icon">' . $html_icon . '</span>' . $after_link_icon . '</div>';
	}

	protected function render_style_old_icon( $settings ) {
		$icon_font_size = $css_style = '';
		$old_settings   = $this->get_data( 'settings' );

		if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font-awesome' ) {
			$icon_font_size = isset( $settings['font_awesome_icon_size'] ) ? $settings['font_awesome_icon_size'] : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font-7-stroke' ) {
			$icon_font_size = isset( $settings['stroke_icon_size'] ) ? $settings['stroke_icon_size'] : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'icomoon' ) {
			$icon_font_size = isset( $settings['font_ionicons_size'] ) ? $settings['font_ionicons_size'] : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font-flaticon' ) {
			$icon_font_size = isset( $settings['flat_icon_size'] ) ? $settings['flat_icon_size'] : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'font_ionicons' ) {
			$icon_font_size = isset( $settings['font_awesome_icon_size'] ) ? $settings['font_awesome_icon_size'] : '';
		} else if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'text_number' ) {
			$icon_font_size = isset( $settings['text_number_font_size'] ) ? $settings['text_number_font_size'] : '';
		}
		if ( isset( $icon_font_size ) && $icon_font_size && ( ! isset( $old_settings['icon_size'] ) ) ) {
			$css_style = 'font-size:' . $icon_font_size . 'px;';
		}
		if ( isset( $old_settings['width_icon_box']['size'] ) && $old_settings['width_icon_box']['size'] == '0' ) {
			$css_style .= 'width: inherit';
		}

		return $css_style ? ' style="' . $css_style . '"' : '';
	}

	protected function render_style_old_title() {
		// old custom
		$css_old_custom            = '';
		$custom_title_settings_old = $this->get_data( 'settings' );
		if ( isset( $custom_title_settings_old['font_heading'] ) && $custom_title_settings_old['font_heading'] == 'custom' ) {
			if ( ! isset( $custom_title_settings_old['font_heading_typography'] ) ) {
				$css_old_custom = isset( $custom_title_settings_old['custom_font_size_heading'] ) ? 'font-size:' . $custom_title_settings_old['custom_font_size_heading'] . 'px;' : '';
				$css_old_custom .= isset( $custom_title_settings_old['custom_font_weight_heading'] ) ? 'font-weight:' . $custom_title_settings_old['custom_font_weight_heading'] . ';' : '';
			}
			if ( isset( $custom_title_settings_old['custom_mg_bt'] ) && ! is_array( $custom_title_settings_old['custom_mg_bt'] ) ) {
				$css_old_custom .= ( isset( $custom_title_settings_old['custom_mg_bt'] ) && $custom_title_settings_old['custom_mg_bt'] != '0' ) ? 'margin-bottom:' . $custom_title_settings_old['custom_mg_bt'] . 'px;' : '';
				$css_old_custom .= ( isset( $custom_title_settings_old['custom_mg_top'] ) && $custom_title_settings_old['custom_mg_top'] != '0' ) ? 'margin-top:' . $custom_title_settings_old['custom_mg_top'] . 'px;' : '';
			}
			if ( ! isset( $custom_title_settings_old['custom_mg_bt'] ) && isset( $custom_title_settings_old['custom_mg_top'] ) ) {
				$css_old_custom .= ( isset( $custom_title_settings_old['custom_mg_top'] ) && $custom_title_settings_old['custom_mg_top'] != '0' ) ? 'margin-top:' . $custom_title_settings_old['custom_mg_top'] . 'px;' : '';
			}
		}

		// end old custom

		return $css_old_custom ? ' style="' . $css_old_custom . '"' : '';
	}

	protected function render_desc( $settings ) {
		if ( isset( $settings['link'] ) && ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'render_link_desc', $settings['link'] );
		}

		$html_content = $close_des = '';
		$before_desc  = ( $settings['read_more'] == 'complete_box' ) && $this->get_render_attribute_string( 'render_link_desc' ) ? '<a class="icon-box-link" ' . $this->get_render_attribute_string( 'render_link_desc' ) . '>' : '';
		$after_desc   = $before_desc ? '</a>' : '';

		if ( isset( $settings['content'] ) && $settings['content'] ) {
			$close_des    = true;
			$html_content .= '<div class="desc-icon-box"><div class="desc-content">' . $before_desc . $settings['content'] . $after_desc . '</div>';
		}
		if ( isset ( $settings['read_text'] ) && $settings['read_text'] && $settings['read_more'] == 'more' && $this->get_render_attribute_string( 'render_link_desc' ) ) {
			$html_content .= '<a class="smicon-read sc-btn" ' . $this->get_render_attribute_string( 'render_link_desc' ) . '>' . $settings['read_text'] . ' <i class="fa fa-chevron-right"></i></a>';
		}

		$html_content .= $close_des ? "</div>" : '';


		return $html_content;
	}
	protected function render() {
		$settings = $this->get_settings_for_display();

		$extent_class = $html_dot = $bg_video = $icon_play = '';

		if ( isset( $settings['icon_img'] ) && $settings['icon_img']['id'] ) {
			$extent_class .= ' has_custom_image';
		}

		if ( isset( $settings['icon_type'] ) && $settings['icon_type'] == 'text_number' ) {
			$extent_class .= ' layout_text_number';
		}

		if ( isset( $settings['text_align_sc'] ) ) {
			$extent_class .= ' ' . $settings['text_align_sc'];
		}

		if ( isset( $settings['style_box'] ) ) {
			$extent_class .= ' ' . $settings['style_box'];
		}

		if ( isset( $settings['widget_background'] ) && $settings['widget_background'] == 'bg_video' && isset( $settings['self_video'] ) && $settings['self_video'] != '' ) {
			$poster       = isset( $settings['self_poster'] ) && $settings['self_poster']['id'] ? ' poster="' . wp_get_attachment_url( $settings['self_poster']['id'] ) . '"' : '';
			$src          = wp_get_attachment_url( $settings['self_video'] );
			$bg_video     = '<video loop muted' . $poster . ' class="full-screen-video"><source src="' . $src . '" type="video/mp4"></video>';
			$extent_class .= ' background-video';
			$icon_play    = '<span class="bg-video-play"></span>';
		}

		if ( isset( $settings['style_box'] ) && $settings['style_box'] == 'contact_info' && isset( $settings['dot_line'] ) && $settings['dot_line'] != '' ) {
			$extent_class .= ' dot_line_buttom_top';
			$html_dot     = '<span class="dot-line"><span></span></span>';
		}

		//start div wrapper-box-icon
		$html = '<div class="thim-widget-icon-box"><div class="wrapper-box-icon' . $extent_class . '">';
		$html .= '<div class="smicon-box iconbox-' . $settings['pos'] . '">';
		// show icon
		$html .= $this->render_icon( $settings );
		// show title
		$html .= '<div class="content-inner">';
		$html .= $html_dot;
		$html .= $this->render_title( $settings );

		// show content
		$html .= $this->render_desc( $settings );
		$html .= $icon_play;
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= $bg_video;
		$html .= '</div>';
		echo ent2ncr( $html );
	}
}
