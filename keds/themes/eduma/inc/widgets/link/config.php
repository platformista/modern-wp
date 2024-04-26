<?php
/**
 * Thim_Builder Link config class
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

if ( ! class_exists( 'Thim_Builder_Config_Link' ) ) {
	/**
	 * Class Thim_Builder_Config_Accordion
	 */
	class Thim_Builder_Config_Link extends Thim_Builder_Abstract_Config {

		/**
		 * Thim_Builder_Config_Link constructor.
		 */
		public function __construct() {
			// info
			self::$base = 'link';
			self::$name = esc_html__( 'Thim: Link', 'eduma' );
			self::$desc = esc_html__( 'Display link and description', 'eduma' );
			self::$icon = 'thim-widget-icon thim-widget-icon-link';
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
					'param_name'  => 'text',
					'allow_html_formatting' => true,
					'std'         => esc_html__( 'Title on here', 'eduma' ),
					'save_always' => true,
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link of title', 'eduma' ),
					'param_name'  => 'link',
					'allow_html_formatting' => true,
					'save_always' => true,
				),

				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Add description', 'eduma' ),
					'param_name'  => 'content',
					'allow_html_formatting' => true,
					'value'       => esc_html__( 'Write a short description, that will describe the title or something informational and useful.', 'eduma' ),
					'save_always' => true,
				),
			);
		}

		public function get_template_name() {
			return 'base';
		}
	}
}