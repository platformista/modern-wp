<?php
/**
 * Thim_Builder Courses Collection config class
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

if ( ! class_exists( 'Thim_Builder_Config_Courses_Collection' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Courses_Collection extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Courses_Collection constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'courses-collection';
			self::$name = esc_html__( 'Thim: Courses Collection', 'eduma' );
			self::$desc = esc_html__( 'Display list courses collection', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-courses-collection';
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
						esc_html__( 'Select', 'eduma' )          => '',
						esc_html__( 'Slider', 'eduma' )          => 'slider',
					),
					'std' => ''
				),

				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Limit collections', 'eduma' ),
					'param_name'  => 'limit',
					'std'         => '8',
				),


				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Columns', 'eduma' ),
					'param_name'  => 'columns',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '1', 'eduma' )      => '1',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
					),
					'std' => '3'
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Feature Items', 'eduma' ),
					'param_name'  => 'feature_items',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( '1', 'eduma' )      => '1',
						esc_html__( '2', 'eduma' )      => '2',
						esc_html__( '3', 'eduma' )      => '3',
						esc_html__( '4', 'eduma' )      => '4',
					),
					'std' => '2'
				),

			);
		}
	}
}