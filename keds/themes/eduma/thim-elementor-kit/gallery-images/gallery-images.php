<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Gallery_Images extends Widget_Base {

	public function get_name() {
		return 'thim-gallery-images';
	}

	public function get_title() {
		return esc_html__( 'Gallery Images', 'eduma' );
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-gallery-images';
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-gallery-images';
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
				'label' => esc_html__( 'Content', 'eduma' )
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
			'image',
			[
				'label'      => __( 'Add Images', 'elementor' ),
				'type'       => Controls_Manager::GALLERY,
				'show_label' => false
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude'   => [ 'custom' ],
				'separator' => 'none',
			]
		);
		$this->add_control(
			'show_alt_title',
			[
				'label'   => esc_html__( 'Show Alt Title', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);
		$this->add_control(
			'image_link',
			[
				'label'       => esc_html__( 'Image Link', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter URL if you want this image to have a link. These links are separated by comma (Ex: #,#,#,#)', 'eduma' ),
				'label_block' => true,
				'placeholder' => esc_html__( 'Add your links here', 'eduma' )
			]
		);

		$this->add_control(
			'link_target',
			[
				'label'       => esc_html__( 'Link Target', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'_self'  => [
						'title' => esc_html__( 'Same window', 'elementor' ),
						'icon'  => 'fa fa-window-maximize',
					],
					'_blank' => [
						'title' => esc_html__( 'New window', 'elementor' ),
						'icon'  => 'fa fa-window-restore',
					],
				],
				'default'     => '_self',
				'toggle'      => false,
				'label_block' => false
			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'slider_setting',
			[
				'label' => esc_html__( 'Slider Setting', 'eduma' ) 
			]
		);
		$this->add_responsive_control(
			'item',
			[
				'label'           => esc_html__( 'Visible Items', 'eduma' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'step'            => 1,
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => 4,
				'tablet_default'  => 2,
				'mobile_default'  => 1
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'   => esc_html__( 'Show Pagination?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'   => esc_html__( 'Show Navigation?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'have_color',
			[
				'label'   => esc_html__( 'Color Image?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'auto_play',
			[
				'label'       => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
				'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1000,
				'min'         => 0,
				'step'        => 100
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'gallery_image_setting',
			[
				'label'     => esc_html__( 'Setting', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE, 
			]
		);
		$this->add_control(
			'gallery_image_opacity',
			[
				'label'      => esc_html__( 'Image Opacity', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					],
				],
 				'selectors'  => [
					'{{WRAPPER}} .gallery-img .item:not(:hover) img' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->end_controls_section();

		$this->_register_setting_slider_dot_style();
		$this->_register_setting_slider_nav_style();
		$this->_register_alt_title_image_style();
	}
	protected function _register_alt_title_image_style(){
		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => esc_html__( 'Title', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_alt_title' => 'yes'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} h4',
			]
		);
		$this->add_control(
			'textcolor',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} h4' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'title_color_hover',
			[
				'label'     => esc_html__( 'Color Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} h4:hover' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}
	protected function _register_setting_slider_dot_style() {
		// dot style
		$this->start_controls_section(
			'slider_dot_tab',
			[
				'label'     => esc_html__( 'Dot', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pagination' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'slider_dot_top_spacing',
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
					'size' => 25,
				],
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_dot_margin',
			[
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
                    'top' => 0,
					'bottom' => 0,
					'left' => 5,
					'right' => 5,
                    'unit' => 'px',
                ],
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_dot_border_radius',
			[
				'label'      => esc_html__( 'Border radius', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'dot_setting_tab'
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
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page' => 'width: {{SIZE}}{{UNIT}};',
				],
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
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'slider_dot_background',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page' => 'background-color: {{VALUE}}; opacity: 1;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_dot_border',
				'label'    => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}} .gallery-img .owl-pagination .owl-page:not(.active)',
			]
		);

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
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page.active' => 'width: {{SIZE}}{{UNIT}};',
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
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page.active' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slider_dot_active_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .gallery-img .owl-pagination .owl-page:hover,{{WRAPPER}} .gallery-img .owl-pagination .owl-page.active' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_dot_active_border',
				'label'    => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}} .gallery-img .owl-pagination .owl-page.active,{{WRAPPER}} .gallery-img .owl-pagination .owl-page:hover',
			]
		);

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
					'show_navigation' => 'yes'
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
					'{{WRAPPER}} .gallery-img .owl-prev' => 'left: auto; {{prev_offset_orientation_h.VALUE}}:{{VALUE}}px;',
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
					'{{WRAPPER}} .gallery-img .owl-next' => '{{next_offset_orientation_h.VALUE}}:{{VALUE}}px',
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
					'{{WRAPPER}} .gallery-img .owl-buttons > button' => 'top:{{VALUE}}%;',
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
					'{{WRAPPER}} .gallery-img .owl-buttons > button' => '-webkit-transform: translateY({{VALUE}}px); -ms-transform: translateY({{SIZE}}px); transform: translateY({{SIZE}}px);',
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
					'size' => 14,
				],
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-buttons > button i' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .gallery-img .owl-buttons > button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
					'size' => 30,
				],
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-buttons > button' => 'width: {{SIZE}}{{UNIT}};'
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
					'size' => 30,
				],
				'selectors'  => [
					'{{WRAPPER}} .gallery-img .owl-buttons > button' => 'height: {{SIZE}}{{UNIT}};'
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
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .gallery-img .owl-buttons > button i' => 'color: {{VALUE}}'
				],
			]
		);
		$this->add_responsive_control(
			'slider_nav_bg_color_normal',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .gallery-img .owl-buttons > button' => 'background-color: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slider_nav_box_shadow_normal',
				'label'    => esc_html__( 'Box Shadow', 'eduma' ),
				'selector' => '{{WRAPPER}} .gallery-img .owl-buttons > button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_nav_border_normal',
				'label'    => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}} .gallery-img .owl-buttons > button',
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
					'{{WRAPPER}} .gallery-img .owl-buttons > button i' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'slider_nav_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gallery-img .owl-buttons > button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'slider_nav_box_shadow_hover',
				'label'    => esc_html__( 'Box Shadow', 'eduma' ),
				'selector' => '{{WRAPPER}} .gallery-img .owl-buttons > button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'slider_nav_border_hover',
				'label'    => esc_html__( 'Border', 'eduma' ),
				'selector' => '{{WRAPPER}} .gallery-img .owl-buttons > button:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if($settings['slider_nav_border_normal_border'] == ''){
			$this->add_render_attribute(
				'_wrapper', 'class', 'nav-border-none'
			);
		}

		if($settings['slider_dot_border_border'] == ''){
			$this->add_render_attribute(
				'_wrapper', 'class', 'dot-border-none'
			);
		}

		if($settings['slider_dot_active_border_border'] == ''){
			$this->add_render_attribute(
				'_wrapper', 'class', 'dot-active-border-none'
			);
		}

		$settings['image'] =  array_map( function ( $ar ) {
					return $ar['id'];
			}, $settings['image'] );
		 
		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">'; 
		$args['after_title']  = '</h3>';

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings,
			'args'     => $args
		) );
	}
}
