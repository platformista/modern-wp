<?php

namespace Elementor;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Accordion extends Widget_Base {

	public function get_name() {
		return 'thim-accordion';
	}

	public function get_title() {
		return esc_html__( 'Accordion', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-accordion';
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
				'label' => esc_html__( 'Accordion', 'eduma' )
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
			'style',
			[
				'label'   => esc_html__( 'Style', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'   => esc_html__( 'Default', 'eduma' ),
					'new-style' => esc_html__( 'Style 01', 'eduma' ),
				],
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'panel_title',
			[
				'label'       => esc_html__( 'Panel Title', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$repeater->add_control(
			'panel_body',
			[
				'label'       => esc_html__( 'Panel Body', 'eduma' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => true
			]
		);

		$this->add_control(
			'panel',
			[
				'label'       => esc_html__( 'Panel List', 'eduma' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ panel_title }}}',
				'separator'   => 'before'
			]
		);

		$this->end_controls_section();
		$this->register_style_title_controls();
		$this->register_style_content_controls();
	}

	protected function register_style_title_controls() {
		$this->start_controls_section(
			'section_panel_title',
			[
				'label' => esc_html__( 'Panel Title', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-widget-accordion .panel-title a',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_space',
			[
				'label'      => esc_html__( 'Space', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => - 10,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'title_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a.collapsed' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'title_color_active',
			[
				'label'     => esc_html__( 'Text Color Active', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'title_border_radius',
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
					'{{WRAPPER}} .thim-widget-accordion .panel-title a.collapsed' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_border_style',
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
				'default'   => 'dashed',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'title_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_border_color',
			[
				'label'     => esc_html_x( 'Border Color', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'title_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a.collapsed' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_border_color_active',
			[
				'label'     => esc_html_x( 'Border Color Active', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'title_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_border_radius_active',
			[
				'label'      => esc_html__( 'Border Radius Active', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-accordion .panel-title a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_content_controls() {
		$this->start_controls_section(
			'section_panel_content',
			[
				'label' => esc_html__( 'Panel Content', 'eduma' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'eduma' ),
				'selector' => '{{WRAPPER}} .thim-widget-accordion .panel-collapse .panel-body',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'eduma' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse .panel-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_space',
			[
				'label'      => esc_html__( 'Space', 'eduma' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'content_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Text Color', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse .panel-body' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
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
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_border_style',
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
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_border_dimensions',
			[
				'label'     => esc_html_x( 'Width', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => [
					'content_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'content_border_color',
			[
				'label'     => esc_html_x( 'Border Color', 'Border Control', 'eduma' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'content_border_style!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .thim-widget-accordion .panel-collapse' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$class = '';

		$settings = $this->get_settings_for_display();
		$group_id = 'accordion_' . $this->get_id();

		$title = $settings['title'] ? $settings['title'] : '';

		if ( isset( $settings['style'] ) && $settings['style'] == 'new-style' ) {
			$class = ' accordion-new-style';
		}
		$panel_list = $settings['panel'] ? $settings['panel'] : '';

		echo '<div class="thim-widget-accordion' . $class . '">';
		if ( $title != '' ) {
			echo '<h3 class="widget-title">' . $title . '</h3>';
		}
		echo '<div id="' . esc_attr( $group_id ) . '" class="panel-group" role="tablist" aria-multiselectable="true">';
		foreach ( $panel_list as $key => $panel ) : ?>

			<div class="panel panel-default">
				<div class="panel-heading" role="tab"
					 id="<?php echo esc_attr( 'heading_' . $group_id . '_' . $key ); ?>">
					<h4 class="panel-title">
						<a role="button" class="collapsed" data-toggle="collapse"
						   data-parent="#<?php echo esc_attr( $group_id ); ?>"
						   href="<?php echo esc_attr( '#collapse_' . $group_id . '_' . $key ); ?>" aria-expanded="false"
						   aria-controls="<?php echo esc_attr( 'collapse_' . $group_id . '_' . $key ); ?>">
							<?php echo esc_html( $panel['panel_title'] ); ?>
						</a>
					</h4>
				</div>
				<div id="<?php echo esc_attr( 'collapse_' . $group_id . '_' . $key ); ?>"
					 class="panel-collapse collapse"
					 role="tabpanel" aria-labelledby="<?php echo esc_attr( 'heading_' . $group_id . '_' . $key ); ?>">
					<div class="panel-body">
						<?php echo wpautop( $panel['panel_body'] ); ?>
					</div>
				</div>
			</div>

		<?php endforeach;

		echo '</div>';
		echo '</div>';
	}
}
