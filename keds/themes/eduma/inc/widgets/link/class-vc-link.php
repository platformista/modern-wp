<?php
/**
 * Thim_Builder Visual Composer Link shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Link' ) ) {
	/**
	 * Class Thim_Builder_VC_Link
	 */
	class Thim_Builder_VC_Link extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Link constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Link';

			parent::__construct();
		}
		// overwriter param in file config
		function get_config_options() {
			return array(
				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Title', 'eduma' ),
					'param_name'  => 'text',
					'std'         => esc_html__( 'Title on here', 'eduma' ),
					'save_always' => true,
				),

				array(
					'type'        => 'textfield',
					'admin_label' => true,
					'heading'     => esc_html__( 'Link of title', 'eduma' ),
					'param_name'  => 'link',
					'save_always' => true,
				),

				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Add description', 'eduma' ),
					'param_name'  => 'description',
					'value'       => esc_html__( 'Write a short description, that will describe the title or something informational and useful.', 'eduma' ),
					'save_always' => true,
				),
			);
		}
		// convert setting
		function thim_convert_setting( $settings ) {
			$settings['content'] = $settings['description'];
			return $settings;
		}
	}
}

new Thim_Builder_VC_Link();