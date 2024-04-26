<?php
/**
 * Thim_Builder Button config class
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

if ( ! class_exists( 'Thim_Builder_Config_Countdown_Box' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Countdown_Box extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Countdown_Box constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'countdown-box';
			self::$name =  esc_html__( 'Thim: Countdown Box', 'eduma' );
			self::$desc = esc_html__( 'Display Countdown Box.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-countdown-box';
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
					'heading'     => esc_html__( 'Text Days', 'eduma' ),
					'param_name'  => 'text_days',
					'std'         => esc_html__( 'days', 'eduma' ),
					'group'       => esc_html__( 'Text Settings', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text Hours', 'eduma' ),
					'param_name'  => 'text_hours',
					'std'         => esc_html__( 'hours', 'eduma' ),
					'group'       => esc_html__( 'Text Settings', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text Minutes', 'eduma' ),
					'param_name'  => 'text_minutes',
					'std'         => esc_html__( 'minutes', 'eduma' ),
					'group'       => esc_html__( 'Text Settings', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text Seconds', 'eduma' ),
					'param_name'  => 'text_seconds',
					'std'         => esc_html__( 'seconds', 'eduma' ),
					'group'       => esc_html__( 'Text Settings', 'eduma' ),
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Year', 'eduma' ),
					'param_name'  => 'time_year',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Month', 'eduma' ),
					'param_name'  => 'time_month',
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Day', 'eduma' ),
					'param_name'  => 'time_day',
				),

				array(
					'type'        => 'textfield',
					'type_el'        => 'datetimepicker',
					'admin_label' => true,
					'heading'     => esc_html__( 'Hour', 'eduma' ),
					'param_name'  => 'time_hour',
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' )         => '',
						esc_html__( 'Pie', 'eduma' )   => 'pie',
						esc_html__( 'Pie Gradient', 'eduma' )   => 'pie-gradient',
						esc_html__( 'Square', 'eduma' )   => 'square',
					),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Style Color', 'eduma' ),
					'param_name'  => 'style_color',
					'value'       => array(
						esc_html__( 'Select', 'eduma' ) => '',
						esc_html__( 'White', 'eduma' )  => 'white',
						esc_html__( 'Black', 'eduma' )  => 'black',
					),
					'group'       => esc_html__( 'Text Settings', 'eduma' ),
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Text alignment', 'eduma' ),
					'param_name'  => 'text_align',
					'value'       => array(
						esc_html__( 'Select', 'eduma' )         => '',
						esc_html__( 'Text at left', 'eduma' )   => 'text-left',
						esc_html__( 'Text at center', 'eduma' ) => 'text-center',
						esc_html__( 'Text at right', 'eduma' )  => 'text-right',
					),
					'group'       => esc_html__( 'Text Settings', 'eduma' ),
				),

			);
		}

	}
}