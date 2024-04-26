<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Testimonials extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'thim-testimonials';
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-testimonials';
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
				'label' => __( 'Testimonials', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Heading Text', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => false
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'     => esc_html__( 'Default', 'eduma' ),
					'slider'   => esc_html__( 'Slider', 'eduma' ),
					'slider-2' => esc_html__( 'Slider 2', 'eduma' ),
					'carousel' => esc_html__( 'Carousel Slider', 'eduma' ),
				],
				'default' => 'base'
			]
		);

		$this->add_control(
			'carousel_style',
			[
				'label'     => esc_html__( 'Carousel Style', 'eduma' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'style_1' => esc_html__( 'Carousel Style 1', 'eduma' ),
					'style_2' => esc_html__( 'Carousel Style 2', 'eduma' ),
					'style_3' => esc_html__( 'Carousel Style 3', 'eduma' ),
				],
				'default'   => 'style_1',
				'condition' => [
					'layout' => [ 'carousel' ]
				]
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit Posts', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 7,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'activepadding',
			[
				'label'     => esc_html__( 'Item Padding', 'elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'step'      => 1,
				'condition' => [
					'layout' => [ 'slider', 'slider-2' ]
				]
			]
		);

		$this->add_control(
			'item_visible',
			[
				'label'   => esc_html__( 'Item Visible', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'pause_time',
			[
				'label'   => esc_html__( 'Time(ms)', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5000,
				'min'     => 0,
				'step'    => 100
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Auto play?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'layout' => [ 'base', 'slider', 'slider-2' ]
				]
			]
		);

		$this->add_control(
			'mousewheel',
			[
				'label'        => esc_html__( 'Mousewheel Scroll?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'layout' => [ 'base', 'slider', 'slider-2' ]
				]
			]
		);

		$this->add_control(
			'link_to_single',
			[
				'label'        => esc_html__( 'Link To Single?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => ''
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_layout',
			[
				'label'     => __( 'Carousel Layout Option', 'eduma' ),
				'condition' => [
					'layout' => [ 'carousel' ]
				]
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'        => esc_html__( 'Show Pagination?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => ''
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'        => esc_html__( 'Show Navigation?', 'eduma' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'eduma' ),
				'label_off'    => esc_html__( 'No', 'eduma' ),
				'return_value' => 'yes',
				'default'      => ''
			]
		);

		$this->add_control(
			'autoplay_time',
			[
				'label'   => esc_html__( 'Auto Play Time(ms)', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
				'step'    => 100
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		// Map variables between Elementor and SiteOrigin
		$instance = array(
			'title'            => $settings['title'],
			'carousel_style'   => $settings['carousel_style'],
			'layout'           => $settings['layout'],
			'limit'            => $settings['limit'],
			'item_visible'     => $settings['item_visible'],
			'pause_time'       => $settings['pause_time'],
			'autoplay'         => $settings['autoplay'],
			'carousel-options' => array(
				'show_navigation' => $settings['show_navigation'],
				'autoplay'        => $settings['autoplay_time'],
				'show_pagination' => $settings['show_pagination']
			),
			'mousewheel'       => $settings['mousewheel'],
			'link_to_single'   => $settings['link_to_single'],
			'activepadding'    => $settings['activepadding']
		);

		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';
		$layout               = ( isset( $instance['layout'] ) && $instance['layout'] != 'default' ) ? $instance['layout'] : 'base';
		if ( $layout != 'carousel' ) {
			wp_enqueue_script( 'thim-content-slider' );
		}

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $instance,
			'args'     => $args
		), $settings['layout'] );
	}

}
