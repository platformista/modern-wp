<?php
/**
 * Thim_Builder Login Form config class
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

if ( ! class_exists( 'Thim_Builder_Config_Login_Form' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Login_Form extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Login_Form constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'login-form';
			self::$name = esc_html__( 'Thim: Login Form', 'eduma' );
			self::$desc = esc_html__( 'Display Login Form.', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-login-form';
			parent::__construct();
		}

		/**
		 * @return array
		 */
		public function get_options() {

			// options
			return array(
				array(
					'type'        => 'checkbox',
					'admin_label' => true,
					'heading'     => esc_html__( 'Use Captcha?', 'eduma' ),
					'param_name'  => 'captcha',
					'desc'        => esc_html__( 'Use captcha in register and login form', 'eduma' ),
				),

				array(
					'type'          => 'textfield',
					'type_el'          => 'vc_link',
					'heading'       => esc_html__( 'Terms of Service link', 'eduma' ),
					'param_name'    => 'term',
					'value'         => '',
 					'description'   => esc_html__( 'Leave empty to disable this field.', 'eduma' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Open in new window', 'eduma' ),
					'param_name' => 'is_external',
					'std'        => false,
//					'description'   => esc_html__( '(not show when Enable register form of LearnPress.)', 'eduma' ),

				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Add nofollow', 'eduma' ),
					'param_name' => 'nofollow',
					'std'        => false,
					'description'   =>esc_html__( '(not show when Enable register form of LearnPress.)', 'eduma' ),
 				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}