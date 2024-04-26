<?php
/**
 * Thim_Builder Twitter config class
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

if ( ! class_exists( 'Thim_Builder_Config_Twitter' ) ) {
	/**
	 * Class Thim_Builder_Config_Twitter
	 */
	class Thim_Builder_Config_Twitter extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Twitter constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'twitter';
			self::$name = esc_html__( 'Thim: Twitter', 'eduma' );
			self::$desc = esc_html__( 'Display twitter feed', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-twitter';
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
				),

				array(
					'type'        => 'dropdown',
					'admin_label' => true,
					'heading'     => esc_html__( 'Layout', 'eduma' ),
					'param_name'  => 'layout',
					'value'       => array(
						esc_html__( 'Default', 'eduma' ) => '',
						esc_html__( 'Slider', 'eduma' )  => 'slider',
					),
					'std'         => ''
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Username', 'eduma' ),
					'param_name'  => 'username',
				),
				array(
					'type'        => 'number',
					'admin_label' => true,
					'heading'     => esc_html__( 'Tweets Display:', 'eduma' ),
					'param_name'  => 'display',
				),
			);
		}
	}
}