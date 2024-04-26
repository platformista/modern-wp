<?php

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Thim_Ekit_Widget_Carousel_Categories extends Widget_Base {

	public function get_name() {
		return 'thim-carousel-categories';
	}

	//
	public function get_title() {
		return esc_html__( 'Carousel Categories', 'eduma' );
	}

	protected function get_html_wrapper_class() {
		return 'thim-widget-carousel-categories';
	}

	public function get_icon() {
		return 'thim-eicon thim-widget-icon thim-widget-icon-carousel-categories';
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
				'label' => esc_html__( 'Carousel Posts', 'eduma' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Heading', 'eduma' ),
				'default'     => esc_html__( 'Carousel Categories', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false
			]
		);

		$this->add_control(
			'cat_id',
			[
				'label'    => esc_html__( 'Select Category', 'eduma' ),
				'type'     => Controls_Manager::SELECT2,
				'options'  => thim_get_cat_taxonomy( 'category', array() ),
				'multiple' => true,
				'default'  => 'all'
			]
		);
		$this->add_control(
			'post_limit',
			[
				'label'       => esc_html__( 'Number Posts', 'eduma' ),
				'description' => esc_html__( 'Posts limit display on each category', 'eduma' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 6,
				'min'         => 1,
				'step'        => 1
			]
		);

		$this->add_control(
			'link_view_all',
			[
				'label'       => esc_html__( 'Link View All', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'text_view_all',
			[
				'label'       => esc_html__( 'Text View All', 'eduma' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true
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
			'visible',
			[
				'label'   => esc_html__( 'Visible items', 'eduma' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'step'    => 1
			]
		);

		$this->add_control(
			'show_nav',
			[
				'label'   => esc_html__( 'Show Navigation?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => true
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'   => esc_html__( 'Show Pagination?', 'eduma' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => false
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
		$settings = $this->get_settings_for_display();

		$args                 = array();
		$args['before_title'] = '<h3 class="widget-title">';
		$args['after_title']  = '</h3>';

		thim_ekit_get_widget_template( $this->get_base(), array(
			'instance' => $settings,
			'args'     => $args
		) );
	}

}
