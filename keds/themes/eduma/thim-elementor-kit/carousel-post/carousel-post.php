<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Carousel_Post extends Widget_Base {

	public function get_name() {
		return 'thim-carousel-post';
	}

	public function get_title() {
		return esc_html__( 'Carousel Posts', 'eduma' );
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-carousel-posts';
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
				'label' => __( 'Carousel Posts', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Heading', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Add your text here', 'eduma' ),
				'label_block' => false
			]
		);

		$this->add_control(
			'cat_id',
			[
				'label'   => esc_html__( 'Select Category', 'eduma' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => thim_get_cat_taxonomy( 'category', array( 'all' => esc_html__( 'All', 'eduma' ) ) ),
				'default' => 'all'
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'base'     => esc_html__( 'Default', 'eduma' ),
					'layout-2' => esc_html__( 'Layout 2', 'eduma' ),
					'layout-3' => esc_html__( 'Layout 3', 'eduma' )
				],
				'default' => 'base'
			]
		);
		$this->add_control(
			'number_posts',
			[
				'label'   => esc_html__( 'Number Posts', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'popular' => esc_html__( 'Popular', 'eduma' ),
					'recent'  => esc_html__( 'Date', 'eduma' ),
					'title'   => esc_html__( 'Title', 'eduma' ),
					'random'  => esc_html__( 'Random', 'eduma' )
				],
				'default' => 'recent'
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'eduma' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'ASC', 'eduma' ),
					'desc' => esc_html__( 'DESC', 'eduma' )
				],
				'default' => 'desc'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_setting',
			[
				'label' => esc_html__( 'Carousel Setting', 'eduma' )
			]
		);
		$this->add_control(
			'visible_post',
			[
				'label'   => esc_html__( 'Posts Visible', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'show_nav',
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
			'auto_play',
			[
				'label'       => esc_html__( 'Auto play speed (in ms)', 'eduma' ),
				'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'min'         => 0,
				'step'        => 100
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings             = $this->get_settings_for_display();
		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings,
			'args'     => $args
		), $settings['layout'] );
	}

}
