<?php
/**
 * Thim_Builder Empty Space config class
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

if ( ! class_exists( 'Thim_Builder_Config_Empty_Space' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Empty_Space extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Empty_Space constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'empty-space';
			self::$name = esc_html__( 'Thim: Empty Space', 'eduma' );
			self::$desc = esc_html__( 'Add space width custom height', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-empty-space';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
 				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Height', 'eduma' ),
					'param_name'  => 'height',
					'description' => esc_html__( 'Enter empty space height.', 'eduma' ),
					'std'         => '30',
 				),
 			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}