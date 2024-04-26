<?php
/**
 * Thim_Builder Tab Event config class
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

if ( ! class_exists( 'Thim_Builder_Config_Tab_Event' ) ) {
	/**
	 * Class Thim_Builder_Config_Tab_Event
	 */
	class Thim_Builder_Config_Tab_Event extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Tab_Event constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'tab-event';
			self::$name = esc_html__( 'Thim: Tab events', 'eduma' );
			self::$desc = esc_html__( 'Show all event with tab', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-tab-event';
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
					'allow_html_formatting' => true,
					'value'       => '',
				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}