<?php
/**
 * Thim_Builder Carousel Categories config class
 *
 * @version     1.0.0
 * @author      ThimPress
 * @package     Thim_Builder/Classes
 * @category    Classes
 * @author      Thimpress, tuanta
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Thim_Builder_Config_Carousel_Categories' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Carousel_Categories extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Carousel_Categories constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'carousel-categories';
			self::$name = esc_html__( 'Thim: Carousel Categories', 'eduma' );
			self::$desc = esc_html__( 'Display categories with Carousel', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-carousel-categories';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Heading', 'eduma' ),
					'param_name'  => 'title',
					'allow_html_formatting' => true,
					'std'         => esc_html__( 'Carousel Categories', 'eduma' ),
				),

				array(
					'type'        => 'dropdown_multiple',
					'heading'     => __( 'Categories', 'eduma' ),
					'param_name'  => 'cat_id',
					'value'      => thim_get_cat_taxonomy( 'category', array(), true ),
 					'description' => __( 'Select categories', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Visible items', 'eduma' ),
					'param_name'  => 'visible',
					'std'         => '1',
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Posts per category', 'eduma' ),
					'param_name'  => 'post_limit',
					'std'         => '4',
					'description' => esc_html__( 'Posts limit display on each category', 'eduma' ),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Show Navigation', 'eduma' ),
					'param_name'  => 'show_nav',
					'value'       => array(
						esc_html__( 'Yes', 'eduma' ) => 'yes',
					),
					'std'         => 'yes',
					'save_always' => true,
				),

				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Show Pagination', 'eduma' ),
					'param_name'  => 'show_pagination',
					'value'       => array(
						esc_html__( 'Yes', 'eduma' ) => 'yes',
					),
					'save_always' => true,
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Auto Play Speed (in ms)', 'eduma' ),
					'param_name'  => 'auto_play',
					'std'         => '0',
					'description' => esc_html__( 'Set 0 to disable auto play.', 'eduma' ),
					'group'       => esc_html__( 'Slider Settings', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link View All', 'eduma' ),
					'param_name'  => 'link_view_all',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text View All', 'eduma' ),
					'param_name'  => 'text_view_all',
				),

			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}