<?php
/**
 * Thim_Builder Timetable config class
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

if ( ! class_exists( 'Thim_Builder_Config_Timetable' ) ) {
	/**
	 * Class Thim_Builder_Config_Timetable
	 */
	class Thim_Builder_Config_Timetable extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Timetable constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'timetable';
			self::$name = esc_html__( 'Thim: Timetable', 'eduma' );
			self::$desc = esc_html__( 'Display Timetable.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-timetable';
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
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'title',
					'value'       => '',
				),

				array(
					'type'        => 'param_group',
					'admin_label' => true,
					'heading'     => esc_html__( 'Timetable Items', 'eduma' ),
					'param_name'  => 'panel',
					'params'      => array(
						array(
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => esc_html__( 'Course Title', 'eduma' ),
							'std'        => esc_html__( 'Course Title', 'eduma' ),
							'param_name' => 'panel_title',
						),
						array(
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => esc_html__( 'Time Activity', 'eduma' ),
							'std'        => esc_html__( '8:00 AM - 10:00 AM', 'eduma' ),
							'param_name' => 'panel_time',
						),

						array(
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => esc_html__( 'Teacher Name', 'eduma' ),
							'std'        => esc_html__( 'Mr John Doe', 'eduma' ),
							'param_name' => 'panel_teacher',
						),

						array(
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => esc_html__( 'Location', 'eduma' ),
							'std'        => esc_html__( 'Playground', 'eduma' ),
							'param_name' => 'panel_location',
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => true,
							'heading'     => esc_html__( 'Background Color', 'eduma' ),
							'param_name'  => 'panel_background',
						),

						array(
							'type'        => 'colorpicker',
							'admin_label' => true,
							'heading'     => esc_html__( 'Background Hover Color', 'eduma' ),
							'param_name'  => 'panel_background_hover',
						),

						array(
							'type'        => 'dropdown',
							'admin_label' => true,
							'heading'     => esc_html__( 'Color Style', 'eduma' ),
							'param_name'  => 'panel_color_style',
							'value'       => array(
								esc_html__( 'Select', 'eduma' ) => '',
								esc_html__( 'Light', 'eduma' )  => 'light',
								esc_html__( 'Dark', 'eduma' )   => 'dark',
								esc_html__( 'Gray', 'eduma' )   => 'gray',
							),
							'description' => esc_html__( "Select Color Style.", 'eduma' ),
						),

					)
				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}