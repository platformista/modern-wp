<?php
/**
 * Thim_Builder Visual Composer Accordion shortcode
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

if ( ! class_exists( 'Thim_Builder_VC_Accordion' ) ) {
	/**
	 * Class Thim_Builder_VC_Accordion
	 */
	class Thim_Builder_VC_Accordion extends Thim_Builder_VC_Shortcode {

		/**
		 * Thim_Builder_VC_Accordion constructor.
		 */
		public function __construct() {
			// set config class
			$this->config_class = 'Thim_Builder_Config_Accordion';

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
					'value'       => '',
				),

				array(
					'type'        => 'param_group',
					'admin_label' => false,
					'heading'     => esc_html__( 'Accordion Items', 'eduma' ),
					'param_name'  => 'items',
					'params'      => array(
						array(
							'type'       => 'textfield',
							'admin_label' => true,
							'value'      => '',
							'heading'    => esc_html__( 'Title', 'eduma' ),
							'std'        => esc_html__( 'Title', 'eduma' ),
							'param_name' => 'panel_title',
						),
						array(
							'type'        => 'textarea',
							'admin_label' => false,
							'heading'     => esc_html__( 'Content', 'eduma' ),
							'param_name'  => 'panel_body',
							'std'         => esc_html__( 'Write a short description, that will describe the title or something informational and useful.', 'eduma' ),
						),

					)
				),
			);
		}
		// convert setting
		function thim_convert_setting( $settings ) {
			$settings['panel'] = $settings['items'];
			return $settings;
		}
	}
}

new Thim_Builder_VC_Accordion();