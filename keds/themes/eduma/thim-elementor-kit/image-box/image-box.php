<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Image_Box extends Widget_Base {

	public function get_name() {
		return 'thim-image-box';
	}

	public function get_title() {
		return esc_html__( 'Image Box', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-image-box';
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
				'label' => esc_html__( 'Image box', 'eduma' )
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'     => esc_html__( 'Default', 'eduma' ),
					'layout-2' => esc_html__( 'Layout 2', 'eduma' ),
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$this->add_control(
			'title_tag',
			array(
				'label'   => __( 'Title HTML Tag', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
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
				'default' => 'h3'
			)
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Add your description here', 'eduma' ),
				'label_block' => true,
				'condition'   => [
					'style' => [ 'layout-2' ]
				]
			]
		);
		$this->add_control(
			'desc_position',
			[
				'label'     => esc_html__( 'Description Position', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'before_title' => esc_html__( 'Before Title', 'eduma' ),
					'after_title'  => esc_html__( 'After Title', 'eduma' )
				],
				'default'   => 'after_title',
				'condition' => [
					'style' => [ 'layout-2' ]
				]
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
			'hover_style',
			[
				'label'     => esc_html__( 'Hover Style', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'icon' => esc_html__( 'Icon', 'eduma' ),
					'text' => esc_html__( 'Read More Text', 'eduma' ),
				],
				'condition' => [
					'style' => [ 'base' ]
				],
				'default'   => 'icon'
			]
		);

		$this->add_control(
			'text_read_more_hover',
			[
				'label'       => esc_html__( 'Text Read More', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'hover_style' => [ 'text' ],
					'style'       => [ 'base' ],
				]
			]
		);

		$this->add_control(
			'icon_hover',
			[
				'label'       => esc_html__( 'Icon Hover', 'eduma' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',
				'condition'   => [
					'style'       => [ 'base' ],
					'hover_style' => [ 'icon' ],
				]
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Icon Font Size (px)', 'eduma' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 24,
				'min'       => 0,
				'step'      => 1,
				'condition' => [
					'style'       => [ 'base' ],
					'icon_hover!' => 'none',
					'hover_style' => [ 'icon' ],
				],
				'selectors' => [
					'{{WRAPPER}} .thim-image-box .icon-hover i'   => 'font-size: {{VALUE}}px;',
					'{{WRAPPER}} .thim-image-box .icon-hover svg' => 'width: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'widget_setting',
			[
				'label' => esc_html__( 'Setting', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius Image', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-image-box .wrapper-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'image_background_overlay',
			[
				'label'     => esc_html__( 'Background Overlay', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-image-box .wrapper-image:before' => 'content:""; background-color: {{VALUE}}; transition: all 0.3s ease-in-out;'
				],
			]
		);

		$this->add_control(
			'image_background_overlay_hover',
			[
				'label'     => esc_html__( 'Background Overlay Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-image-box:hover .wrapper-image:before' => 'content:""; background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'icon_color_hover',
			[
				'label'     => esc_html__( 'Color Icon Hover', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thim-image-box:hover .icon-hover' => 'color: {{VALUE}};fill: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'readmore_typography',
				'label'     => esc_html__( 'Read More Typography', 'eduma' ),
				'selector'  => '{{WRAPPER}} .thim-image-box .icon-hover',
				'condition' => [
					'hover_style' => [ 'text' ],
				],

			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'title_setting',
			[
				'label' => esc_html__( 'Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'     => esc_html__( 'Text Alignment', 'eduma' ),
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
					]
				],
				'condition' => [
					'style' => [ 'layout-2' ]
				],
				'selectors' => [
					'{{WRAPPER}} .thim-image-box.template-layout-2 .thim-image-info ' => 'text-align: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-image-box .thim-image-info .title .title-tag',

			]
		);

		$this->add_control(
			'title_padding',
			array(
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .template-layout-2 .thim-image-info .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => [
					'style' => [ 'layout-2' ]
				]
			)
		);

		$this->add_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .template-layout-2 .thim-image-info .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => [
					'style' => [ 'layout-2' ]
				]
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_shadow_title',
				'selector'  => '{{WRAPPER}} .template-layout-2 .thim-image-info .title',
				'condition' => [
					'style' => [ 'layout-2' ]
				]
			]
		);
		$this->add_responsive_control(
			'title_vertical_align',
			array(
				'label'     => esc_html__( 'Vertically Top (px)', 'eduma' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => - 200,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-image-box.template-layout-2 .thim-image-info' => 'margin-top:{{SIZE}}px;',
				),
				'condition' => [
					'style' => [ 'layout-2' ]
				]
			)
		);

		$this->add_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Box Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-image-box.template-layout-2 .thim-image-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => [
					'style' => [ 'layout-2' ]
				]
			)
		);

		$this->start_controls_tabs( 'tabs_background_box_style' );
		$this->start_controls_tab(
			'tab_background_box_normal',
			[
				'label' => esc_html__( 'Normal', 'eduma' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-image-box .thim-image-info .title .title-tag' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'title_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .template-layout-2 .thim-image-info .title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .thim-image-box .title'                     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'           => 'background_box',
				'label'          => esc_html__( 'Background Gradient', 'eduma' ),
				'types'          => [ 'gradient' ],
				'fields_options' => [
					'background' => [
						'label' => esc_html__( 'Background Gradient', 'eduma' ),
					],
				],
				'condition'      => [
					'style' => [ 'layout-2' ]
				],
				'selector'       => '{{WRAPPER}} .thim-image-box.template-layout-2 .thim-image-info .title',
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
			'title_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-image-box:hover .thim-image-info .title .title-tag' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'title_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .template-layout-2:hover .thim-image-info .title' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .thim-image-box:hover .title'                     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'           => 'background_box_hover',
				'label'          => esc_html__( 'Background Gradient', 'eduma' ),
				'types'          => [ 'gradient' ],
				'fields_options' => [
					'background' => [
						'label' => esc_html__( 'Background Gradient', 'eduma' ),
					],
				],
				'condition'      => [
					'style' => [ 'layout-2' ]
				],
				'selector'       => '{{WRAPPER}} .thim-image-box.template-layout-2:hover .thim-image-info .title',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'text_align_title_base',
			[
				'label'     => esc_html__( 'Text Alignment', 'eduma' ),
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
					]
				],
				'condition' => [
					'style' => [ 'base' ]
				],
				'selectors' => [
					'{{WRAPPER}} .thim-image-box .title' => 'text-align: {{VALUE}}; width: 100%;'
				],
			]
		);

		$this->add_responsive_control(
			'text_title_baseposition_v',
			array(
				'label'       => esc_html__( 'Vertical Position', 'eduma' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
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
				'condition'   => [
					'style' => [ 'base' ]
				],
				'render_type' => 'ui',
				'selectors'   => [
					'{{WRAPPER}} .thim-image-box .title' => 'top:{{VALUE}}%;',
				],
			)
		);

		$this->add_control(
			'title_padding_base',
			array(
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-image-box .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => [
					'style' => [ 'base' ]
				]
			)
		);

		$this->add_control(
			'title_margin_base',
			array(
				'label'      => esc_html__( 'Margin', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-image-box .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => [
					'style' => [ 'base' ]
				]
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'desc_setting',
			[
				'label'     => esc_html__( 'Description', 'eduma' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => [ 'layout-2' ]
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .description',
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .description' => 'color: {{VALUE}};'
				]
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( isset( $settings['image'] ) && isset( $settings['image']['id'] ) ) {
			if ( isset( $settings['link'] ) && $settings['link'] ) {
				echo '<a href="' . esc_url( $settings['link'] ) . '">';
			}
			echo '<div class="thim-image-box template-' . esc_attr( $settings['style'] ) . '">';
			echo '<div class="wrapper-image">' . wp_get_attachment_image( $settings['image']['id'], 'full' ) . '</div>';
			echo '<div class="thim-image-info">';

			if ( isset( $settings['icon_hover'] ) && $settings['icon_hover'] ) {
				ob_start();
				Icons_Manager::render_icon( $settings['icon_hover'], [ 'aria-hidden' => 'true' ] );
				$icon = ob_get_contents();
				ob_end_clean();
				if ( $icon ) {
					echo '<div class="icon-hover">' . $icon . '</div>';
				}
			}

			if ( isset( $settings['text_read_more_hover'] ) && $settings['text_read_more_hover'] ) {
				echo '<div class="icon-hover">' . $settings['text_read_more_hover'] . '</div>';
			}

			if ( $settings['desc_position'] == 'before_title' ) {
				echo isset( $settings['description'] ) ? '<div class="description">' . $settings['description'] . '</div>' : '';
			}

			if ( isset( $settings['title'] ) ) { ?>
				<div class="title">
				<<?php Utils::print_validated_html_tag( $settings['title_tag'] ); ?> class="title-tag">
				<?php esc_html_e( $settings['title'], 'eduma' ); ?>
				</<?php Utils::print_validated_html_tag( $settings['title_tag'] ); ?>>
				</div>
			<?php }

			echo isset( $settings['description'] ) ? '<div class="description">' . $settings['description'] . '</div>' : '';

			echo '</div>';

			echo '</div>';

			if ( isset( $settings['link'] ) && $settings['link'] ) {
				echo '</a>';
			}
		}
	}
}
