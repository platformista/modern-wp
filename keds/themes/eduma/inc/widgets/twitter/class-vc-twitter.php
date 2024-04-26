<?php
/**
 * Thim_Builder Visual Composer Twitter shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Twitter' ) ) {
	/**
	 * Class Thim_Builder_VC_Twitter
	 */
	class Thim_Builder_VC_Twitter extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Twitter constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Twitter';

			parent::__construct();
		}
		// overwriter param in file config
		function get_config_options() {
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
					'param_name'  => 'number',
				),
			);
		}
		// convert setting
		function thim_convert_setting( $settings ) {
			$settings['display'] = $settings['number'];
			return $settings;
		}
	}
}

new Thim_Builder_VC_Twitter();