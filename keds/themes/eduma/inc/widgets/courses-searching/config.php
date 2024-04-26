<?php
/**
 * Thim_Builder Courses Searching config class
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

if ( ! class_exists( 'Thim_Builder_Config_Courses_Searching' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Courses_Searching extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Courses_Searching constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'courses-searching';
			self::$name = esc_html__( 'Thim: Courses Searching', 'eduma' );
			self::$desc = esc_html__( 'Display courses search box.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-courses-searching';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' ) => 'base',
						esc_html__( 'Overlay', 'eduma' ) => 'overlay',
					),
					'std'      => 'base'
				),
				array(
					'type'        => 'dropdown',
 					'heading'     => esc_html__( 'Icon Style', 'eduma' ),
					'param_name'  => 'icon_style_overlay',
					'value'       => array(
						esc_html__( 'Default', 'eduma' ) => '',
						esc_html__( 'Background Circle', 'eduma' )    => 'bg_circle',
 					),
					'std'         => '',
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'overlay',
					),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'title',
					'std'         => esc_html__( 'Search Courses', 'eduma' ),
					'dependency'  => array(
						'element' => 'layout',
						'value'   => 'base',
					),
				),

				array(
					'type'        => 'textarea',
					'admin_label' => true,
					'heading'     => esc_html__( 'Description', 'eduma' ),
					'param_name'  => 'description',
					'std'         => esc_html__( 'Description for search course.', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Placeholder Input', 'eduma' ),
					'param_name'  => 'placeholder',
					'std'         => esc_html__( 'What do you want to learn today?', 'eduma' ),
				),
			);
		}

	}
}